<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\CommunicationRecipient;
use App\Models\EmailCommunication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EmailCommunicationController extends Controller
{
    /**
     * Display the email communications dashboard.
     */
    public function index()
    {
        $emailCommunications = Communication::where('type', 'email')
            ->with(['emailDetails', 'recipients'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('communications.email.index', compact('emailCommunications'));
    }

    /**
     * Show the form for creating a new email communication.
     */
    public function create()
    {
        $contacts = \App\Models\CommunicationContact::all();
        return view('communications.email.create', compact('contacts'));
    }

    /**
     * Store a newly created email communication in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'subject' => 'required|string|max:255',
                'content' => 'required|string',
                'from_email' => 'required|email',
                'from_name' => 'nullable|string|max:255',
                'reply_to' => 'nullable|email',
                'cc' => 'nullable|string',
                'bcc' => 'nullable|string',
                'attachment' => 'nullable|file|max:10240', // 10MB max
            ]);

            // Create the communication record
            $communication = Communication::create([
                'type' => 'email',
                'subject' => $request->subject,
                'content' => $request->content,
                'status' => 'draft',
                'user_id' => Auth::id(),
            ]);

            // Handle attachment if present
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachmentPath = $request->file('attachment')->store('email_attachments');
            }

            // Create email details
            EmailCommunication::create([
                'communication_id' => $communication->id,
                'from_email' => $request->from_email,
                'from_name' => $request->from_name,
                'reply_to' => $request->reply_to,
                'cc' => $request->cc,
                'bcc' => $request->bcc,
                'attachment_path' => $attachmentPath,
            ]);

            // Process contact recipients
            $recipientCount = 0;
            if ($request->has('recipients_contacts')) {
                foreach ($request->input('recipients_contacts', []) as $contactId) {
                    $contact = \App\Models\CommunicationContact::find($contactId);
                    if ($contact && $contact->email) {
                        CommunicationRecipient::create([
                            'communication_id' => $communication->id,
                            'recipient_type' => 'contact',
                            'recipient_id' => $contact->id,
                            'email' => $contact->email,
                            'name' => $contact->name,
                            'status' => 'pending',
                        ]);
                        $recipientCount++;
                    }
                }
            }

            // Process manual recipients
            if ($request->has('manual_recipients')) {
                foreach ($request->input('manual_recipients', []) as $manualRecipient) {
                    if (!empty($manualRecipient['email'])) {
                        CommunicationRecipient::create([
                            'communication_id' => $communication->id,
                            'recipient_type' => 'manual',
                            'recipient_id' => null,
                            'email' => $manualRecipient['email'],
                            'name' => $manualRecipient['name'] ?? null,
                            'status' => 'pending',
                        ]);
                        $recipientCount++;
                    }
                }
            }
            
            // Check if we have recipients
            if ($recipientCount === 0) {
                $communication->delete();
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Please add at least one recipient.');
            }
            
            // Log the email communication creation
            Log::info('Email communication created', [
                'id' => $communication->id,
                'subject' => $request->subject,
                'recipients' => $recipientCount,
                'user_id' => Auth::id(),
            ]);
            
            // If send_now is true, send immediately
            if ($request->has('send_now') && $request->send_now == '1') {
                return $this->sendEmails($communication->id);
            }
            
            return redirect()->route('communications.email.show', $communication->id)
                ->with('success', "Email created successfully with {$recipientCount} recipient(s). Click 'Send' to deliver.");
        } catch (\Exception $e) {
            Log::error('Error creating email communication: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create email communication: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified email communication.
     */
    public function show($id)
    {
        $communication = Communication::with(['emailDetails', 'recipients', 'creator'])
            ->findOrFail($id);
            
        if ($communication->type !== 'email') {
            return redirect()->route('communications.email.index')
                ->with('error', 'The requested communication is not an email.');
        }
        
        return view('communications.email.show', compact('communication'));
    }

    /**
     * Send emails to all recipients of a communication.
     */
    public function sendEmails($id)
    {
        $communication = Communication::with(['emailDetails', 'recipients'])
            ->findOrFail($id);
            
        if ($communication->type !== 'email') {
            return redirect()->route('communications.email.index')
                ->with('error', 'The requested communication is not an email.');
        }

        $emailDetails = $communication->emailDetails;
        
        // Update communication status
        $communication->update(['status' => 'sending']);
        
        // Process each recipient
        foreach ($communication->recipients as $recipient) {
            try {
                // Send email
                Mail::send('emails.bulk', ['content' => $communication->content], function ($message) use ($communication, $emailDetails, $recipient) {
                    $message->subject($communication->subject);
                    
                    // Set from
                    if ($emailDetails->from_name) {
                        $message->from($emailDetails->from_email, $emailDetails->from_name);
                    } else {
                        $message->from($emailDetails->from_email);
                    }
                    
                    // Set recipient
                    if ($recipient->name) {
                        $message->to($recipient->email, $recipient->name);
                    } else {
                        $message->to($recipient->email);
                    }
                    
                    // Set reply-to if provided
                    if ($emailDetails->reply_to) {
                        $message->replyTo($emailDetails->reply_to);
                    }
                    
                    // Set CC if provided
                    if ($emailDetails->cc) {
                        $ccAddresses = explode(',', $emailDetails->cc);
                        foreach ($ccAddresses as $cc) {
                            $message->cc(trim($cc));
                        }
                    }
                    
                    // Set BCC if provided
                    if ($emailDetails->bcc) {
                        $bccAddresses = explode(',', $emailDetails->bcc);
                        foreach ($bccAddresses as $bcc) {
                            $message->bcc(trim($bcc));
                        }
                    }
                    
                    // Attach file if present
                    if ($emailDetails->attachment_path) {
                        $message->attach(Storage::path($emailDetails->attachment_path));
                    }
                });
                
                // Update recipient status
                $recipient->update([
                    'status' => 'sent',
                    'status_message' => 'Email sent successfully'
                ]);
                
            } catch (\Exception $e) {
                // Log error
                Log::error('Failed to send email', [
                    'communication_id' => $communication->id,
                    'recipient_id' => $recipient->id,
                    'error' => $e->getMessage()
                ]);
                
                // Update recipient status
                $recipient->update([
                    'status' => 'failed',
                    'status_message' => $e->getMessage()
                ]);
            }
        }
        
        // Update communication status based on recipients
        $failedCount = $communication->recipients()->where('status', 'failed')->count();
        $totalCount = $communication->recipients()->count();
        
        if ($failedCount === 0) {
            $communication->update(['status' => 'sent']);
        } elseif ($failedCount === $totalCount) {
            $communication->update(['status' => 'failed']);
        } else {
            $communication->update(['status' => 'partial']);
        }
        
        return redirect()->route('communications.email.show', $communication->id)
            ->with('success', 'Emails have been processed.');
    }
}