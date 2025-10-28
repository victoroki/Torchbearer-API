<?php

namespace App\Http\Controllers;

use App\Models\CommunicationContact;
use Illuminate\Http\Request;

class CommunicationContactController extends Controller
{
    /**
     * Display a listing of the contacts.
     */
    public function index()
    {
        $contacts = CommunicationContact::latest()->paginate(10);
        return view('communications.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('communications.contacts.create');
    }

    /**
     * Store a newly created contact in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        CommunicationContact::create($request->all());

        return redirect()->route('communications.contacts.index')
            ->with('success', 'Contact created successfully.');
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(CommunicationContact $contact)
    {
        return view('communications.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified contact in storage.
     */
    public function update(Request $request, CommunicationContact $contact)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $contact->update($request->all());

        return redirect()->route('communications.contacts.index')
            ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(CommunicationContact $contact)
    {
        $contact->delete();

        return redirect()->route('communications.contacts.index')
            ->with('success', 'Contact deleted successfully.');
    }
}