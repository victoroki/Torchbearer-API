<?php

namespace App\Http\Controllers;

use App\Models\Communication;
use App\Models\CommunicationRecipient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CommunicationController extends Controller
{
    /**
     * Display a listing of the communications.
     */
    public function index()
    {
        // Just return the main communications dashboard view
        // This serves as an entry point to email and WhatsApp sections
        return view('communications.index');
    }

    /**
     * Show the form for creating a new communication.
     */
    public function create()
    {
        $users = User::all();
        return view('communications.create', compact('users'));
    }

    /**
     * Store a newly created communication in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,whatsapp',
            'subject' => 'required_if:type,email',
            'content' => 'required',
            'recipients' => 'required|array',
        ]);

        // Create the communication record
        $communication = Communication::create([
            'type' => $request->type,
            'subject' => $request->subject,
            'content' => $request->content,
            'status' => 'pending',
            'user_id' => Auth::id(),
        ]);

        // Process recipients
        foreach ($request->recipients as $recipient) {
            CommunicationRecipient::create([
                'communication_id' => $communication->id,
                'recipient_type' => $recipient['type'],
                'recipient_id' => $recipient['id'] ?? null,
                'email' => $recipient['email'] ?? null,
                'phone' => $recipient['phone'] ?? null,
                'name' => $recipient['name'] ?? null,
                'status' => 'pending',
            ]);
        }

        // Log the communication creation
        Log::info('Communication created', ['id' => $communication->id, 'type' => $request->type, 'user_id' => Auth::id()]);

        return redirect()->route('communications.show', $communication->id)
            ->with('success', 'Communication created successfully.');
    }

    /**
     * Display the specified communication.
     */
    public function show(Communication $communication)
    {
        $communication->load(['recipients', 'user']);
        
        if ($communication->type === 'email') {
            $communication->load('emailDetails');
        } else {
            $communication->load('whatsappDetails');
        }
        
        return view('communications.show', compact('communication'));
    }

    /**
     * Remove the specified communication from storage.
     */
    public function destroy(Communication $communication)
    {
        $communication->delete();
        
        Log::info('Communication deleted', ['id' => $communication->id, 'user_id' => Auth::id()]);
        
        return redirect()->route('communications.index')
            ->with('success', 'Communication deleted successfully.');
    }
}