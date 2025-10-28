<?php

namespace App\Http\Controllers;

use App\Jobs\SendWhatsAppMessage;
use App\Models\WhatsAppContact;
use App\Models\WhatsAppMessage;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WhatsAppController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->middleware('auth');
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Display WhatsApp dashboard
     */
    public function index()
    {
        $totalContacts = WhatsAppContact::where('is_active', true)->count();
        $totalMessages = WhatsAppMessage::count();
        $sentMessages = WhatsAppMessage::where('status', 'sent')->count();
        $failedMessages = WhatsAppMessage::where('status', 'failed')->count();

        $recentMessages = WhatsAppMessage::with(['contact', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('communications.whatsapp.index', compact(
            'totalContacts',
            'totalMessages',
            'sentMessages',
            'failedMessages',
            'recentMessages'
        ));
    }

    /**
     * Display contacts list
     */
    public function contacts()
    {
        $contacts = WhatsAppContact::orderBy('created_at', 'desc')->paginate(20);
        return view('communications.whatsapp.contacts', compact('contacts'));
    }

    /**
     * Store a new contact
     */
    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:whatsapp_contacts,phone_number',
            'email' => 'nullable|email',
            'notes' => 'nullable|string',
            'group' => 'nullable|string|max:255',
        ]);

        $validated['is_active'] = true;

        WhatsAppContact::create($validated);

        return redirect()->route('communications.whatsapp.contacts')
            ->with('success', 'Contact added successfully.');
    }

    /**
     * Update a contact
     */
    public function updateContact(Request $request, $id)
    {
        $contact = WhatsAppContact::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|unique:whatsapp_contacts,phone_number,' . $id,
            'email' => 'nullable|email',
            'notes' => 'nullable|string',
            'group' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $contact->update($validated);

        return redirect()->route('communications.whatsapp.contacts')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Delete a contact
     */
    public function destroyContact($id)
    {
        $contact = WhatsAppContact::findOrFail($id);
        $contact->delete();

        return redirect()->route('communications.whatsapp.contacts')
            ->with('success', 'Contact deleted successfully.');
    }

    /**
     * Show send message form
     */
    public function sendForm()
    {
        $contacts = WhatsAppContact::where('is_active', true)->get();
        return view('communications.whatsapp.send', compact('contacts'));
    }

    /**
     * Send a single message
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'contact_id' => 'nullable|exists:whatsapp_contacts,id',
            'recipient_phone' => 'nullable|string',
            'recipient_name' => 'nullable|string',
            'message' => 'required|string',
            'media_type' => 'nullable|in:image,document,video,audio',
            'media_url' => 'nullable|url',
            'media_caption' => 'nullable|string',
        ]);

        // Get contact details if contact_id is provided
        if ($request->contact_id) {
            $contact = WhatsAppContact::findOrFail($request->contact_id);
            $validated['recipient_phone'] = $contact->phone_number;
            $validated['recipient_name'] = $contact->name;
        }

        // Validate that we have a recipient phone number
        if (empty($validated['recipient_phone'])) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['recipient_phone' => 'Please select a contact or enter a phone number.']);
        }

        // Create message record
        $message = WhatsAppMessage::create([
            'contact_id' => $request->contact_id,
            'recipient_phone' => $validated['recipient_phone'],
            'recipient_name' => $validated['recipient_name'] ?? null,
            'message' => $validated['message'],
            'media_type' => $validated['media_type'] ?? null,
            'media_url' => $validated['media_url'] ?? null,
            'media_caption' => $validated['media_caption'] ?? null,
            'status' => 'pending',
            'user_id' => Auth::id(),
        ]);

        // Dispatch job to send message
        SendWhatsAppMessage::dispatch($message->id);

        return redirect()->route('communications.whatsapp.history')
            ->with('success', 'Message queued for sending.');
    }

    /**
     * Show broadcast form
     */
    public function broadcastForm()
    {
        $contacts = WhatsAppContact::where('is_active', true)->get();
        $groups = WhatsAppContact::where('is_active', true)
            ->whereNotNull('group')
            ->distinct()
            ->pluck('group');
        
        return view('communications.whatsapp.broadcast', compact('contacts', 'groups'));
    }

    /**
     * Broadcast message to multiple contacts
     */
    public function broadcast(Request $request)
    {
        $validated = $request->validate([
            'contact_ids' => 'required|array|min:1',
            'contact_ids.*' => 'exists:whatsapp_contacts,id',
            'message' => 'required|string',
            'media_type' => 'nullable|in:image,document,video,audio',
            'media_url' => 'nullable|url',
            'media_caption' => 'nullable|string',
        ]);

        $contacts = WhatsAppContact::whereIn('id', $validated['contact_ids'])->get();
        $messageCount = 0;

        foreach ($contacts as $contact) {
            $message = WhatsAppMessage::create([
                'contact_id' => $contact->id,
                'recipient_phone' => $contact->phone_number,
                'recipient_name' => $contact->name,
                'message' => $validated['message'],
                'media_type' => $validated['media_type'] ?? null,
                'media_url' => $validated['media_url'] ?? null,
                'media_caption' => $validated['media_caption'] ?? null,
                'status' => 'pending',
                'user_id' => Auth::id(),
            ]);

            // Dispatch job to send message
            SendWhatsAppMessage::dispatch($message->id);
            $messageCount++;
        }

        return redirect()->route('communications.whatsapp.history')
            ->with('success', "Broadcast queued for {$messageCount} contacts.");
    }

    /**
     * Display message history
     */
    public function history(Request $request)
    {
        $query = WhatsAppMessage::with(['contact', 'user']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('recipient_phone', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('communications.whatsapp.history', compact('messages'));
    }

    /**
     * Check account balance
     */
    public function checkBalance()
    {
        $result = $this->whatsAppService->checkBalance();

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'balance' => $result['data'],
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Failed to check balance',
        ], 500);
    }
}
