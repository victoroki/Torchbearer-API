@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-edit"></i> Edit Email</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-secondary float-right" href="{{ route('communications.email.show', $communication->id) }}">
                        <i class="fas fa-arrow-left"></i> Back to Email
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card shadow-sm">
            <form action="{{ route('communications.email.update', $communication->id) }}" method="POST" enctype="multipart/form-data" id="emailForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <!-- Email Header Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> 
                                <strong>Edit your draft email.</strong>
                                Modify the content and recipients before sending.
                            </div>
                        </div>
                    </div>

                    <!-- Subject Field -->
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="subject"><i class="fas fa-heading"></i> Subject <span class="text-danger">*</span></label>
                            <input type="text" name="subject" id="subject" class="form-control form-control-lg" 
                                   placeholder="Enter email subject" required value="{{ old('subject', $communication->subject) }}">
                        </div>
                    </div>

                    <!-- From Details -->
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="from_name"><i class="fas fa-user"></i> From Name <span class="text-danger">*</span></label>
                            <input type="text" name="from_name" id="from_name" class="form-control" 
                                   placeholder="Your name" required value="{{ old('from_name', $communication->emailDetails->from_name ?? auth()->user()->name) }}">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="from_email"><i class="fas fa-at"></i> From Email <span class="text-danger">*</span></label>
                            <input type="email" name="from_email" id="from_email" class="form-control" 
                                   placeholder="your@email.com" required value="{{ old('from_email', $communication->emailDetails->from_email ?? config('mail.from.address')) }}">
                        </div>
                    </div>

                    <!-- Additional Email Options -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#additionalOptions" aria-expanded="false">
                                            <i class="fas fa-cog"></i> Additional Options (Reply-To, CC, BCC, Attachment)
                                        </button>
                                    </h5>
                                </div>
                                <div id="additionalOptions" class="collapse">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="reply_to"><i class="fas fa-reply"></i> Reply To (Optional)</label>
                                                <input type="email" name="reply_to" id="reply_to" class="form-control" 
                                                       placeholder="reply@email.com" value="{{ old('reply_to', $communication->emailDetails->reply_to ?? '') }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="attachment"><i class="fas fa-paperclip"></i> Attachment (Optional)</label>
                                                <input type="file" name="attachment" id="attachment" class="form-control">
                                                <small class="form-text text-muted">Max size: 10MB</small>
                                                @if($communication->emailDetails && $communication->emailDetails->attachment_path)
                                                    <div class="mt-1">
                                                        <small class="text-success">
                                                            <i class="fas fa-check"></i> Current attachment: {{ basename($communication->emailDetails->attachment_path) }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="cc"><i class="fas fa-copy"></i> CC (Optional, comma separated)</label>
                                                <input type="text" name="cc" id="cc" class="form-control" 
                                                       placeholder="email1@example.com, email2@example.com" value="{{ old('cc', $communication->emailDetails->cc ?? '') }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label for="bcc"><i class="fas fa-user-secret"></i> BCC (Optional, comma separated)</label>
                                                <input type="text" name="bcc" id="bcc" class="form-control" 
                                                       placeholder="email1@example.com, email2@example.com" value="{{ old('bcc', $communication->emailDetails->bcc ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Content -->
                    <div class="row mt-3">
                        <div class="form-group col-md-12">
                            <label for="content"><i class="fas fa-pen"></i> Email Content <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" class="form-control" rows="12" required 
                                      placeholder="Write your email message here...">{{ old('content', $communication->content) }}</textarea>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> You can use HTML formatting if needed.
                            </small>
                        </div>
                    </div>

                    <!-- Recipients Section -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-users"></i> Recipients <span class="text-warning">*</span></h5>
                                </div>
                                <div class="card-body">
                                    <ul class="nav nav-tabs mb-3" id="recipientTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="contacts-tab" data-bs-toggle="tab" 
                                                    data-bs-target="#contacts" type="button" role="tab">
                                                <i class="fas fa-address-book"></i> From Contacts
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="manual-tab" data-bs-toggle="tab" 
                                                    data-bs-target="#manual" type="button" role="tab">
                                                <i class="fas fa-keyboard"></i> Manual Entry
                                            </button>
                                        </li>
                                    </ul>

                                    @php
                                        $existingContactIds = $communication->recipients()
                                            ->where('recipient_type', 'contact')
                                            ->pluck('recipient_id')
                                            ->toArray();
                                        $manualRecipients = $communication->recipients()
                                            ->where('recipient_type', 'manual')
                                            ->get();
                                    @endphp

                                    <div class="tab-content" id="recipientTabsContent">
                                        <!-- From Contacts Tab -->
                                        <div class="tab-pane fade show active" id="contacts" role="tabpanel">
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                    <input type="text" id="contact-search" class="form-control" 
                                                           placeholder="Search contacts by name or email...">
                                                </div>
                                                
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllContacts()">
                                                            <i class="fas fa-check-double"></i> Select All
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllContacts()">
                                                            <i class="fas fa-times"></i> Deselect All
                                                        </button>
                                                    </div>
                                                    <span class="badge bg-info" id="contactCount">0 selected</span>
                                                </div>

                                                <div class="contact-list border rounded p-3" style="max-height: 400px; overflow-y: auto; background: #f8f9fa;">
                                                    @forelse($contacts as $contact)
                                                        <div class="form-check mb-2 contact-item">
                                                            <input class="form-check-input contact-checkbox" type="checkbox" 
                                                                   id="contact-{{ $contact->id }}" 
                                                                   name="recipients_contacts[]" 
                                                                   value="{{ $contact->id }}" 
                                                                   onchange="updateContactCount()"
                                                                   {{ in_array($contact->id, $existingContactIds) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="contact-{{ $contact->id }}">
                                                                <strong>{{ $contact->name }}</strong> 
                                                                @if($contact->email)
                                                                    <span class="text-muted">&lt;{{ $contact->email }}&gt;</span>
                                                                @else
                                                                    <span class="text-muted">({{ $contact->phone }})</span>
                                                                @endif
                                                            </label>
                                                        </div>
                                                    @empty
                                                        <div class="text-center text-muted">
                                                            <i class="fas fa-inbox fa-3x mb-2"></i>
                                                            <p>No contacts available</p>
                                                            <a href="{{ route('communications.contacts.create') }}" class="btn btn-sm btn-primary" target="_blank">
                                                                <i class="fas fa-plus"></i> Add New Contact
                                                            </a>
                                                        </div>
                                                    @endforelse
                                                </div>

                                                @if($contacts->count() > 0)
                                                    <div class="mt-2">
                                                        <a href="{{ route('communications.contacts.create') }}" class="btn btn-sm btn-success" target="_blank">
                                                            <i class="fas fa-plus"></i> Add New Contact
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Manual Entry Tab -->
                                        <div class="tab-pane fade" id="manual" role="tabpanel">
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle"></i> 
                                                Add recipients manually. At least one valid email address is required.
                                            </div>
                                            <div id="manual-recipients">
                                                @if($manualRecipients->count() > 0)
                                                    @foreach($manualRecipients as $index => $recipient)
                                                        <div class="row manual-recipient mb-2 align-items-end">
                                                            <div class="col-md-5">
                                                                <label>Name (Optional)</label>
                                                                <input type="text" name="manual_recipients[{{ $index }}][name]" class="form-control" 
                                                                       placeholder="Recipient name" value="{{ $recipient->name }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label>Email <span class="text-danger">*</span></label>
                                                                <input type="email" name="manual_recipients[{{ $index }}][email]" class="form-control" 
                                                                       placeholder="recipient@example.com" value="{{ $recipient->email }}">
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-danger remove-recipient" 
                                                                        onclick="removeRecipient(this)" {{ $index === 0 && $manualRecipients->count() === 1 ? 'disabled' : '' }}>
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="row manual-recipient mb-2 align-items-end">
                                                        <div class="col-md-5">
                                                            <label>Name (Optional)</label>
                                                            <input type="text" name="manual_recipients[0][name]" class="form-control" 
                                                                   placeholder="Recipient name">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label>Email <span class="text-danger">*</span></label>
                                                            <input type="email" name="manual_recipients[0][email]" class="form-control" 
                                                                   placeholder="recipient@example.com">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger remove-recipient" 
                                                                    onclick="removeRecipient(this)" disabled>
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <button type="button" id="add-recipient" class="btn btn-primary mt-2" onclick="addRecipient()">
                                                <i class="fas fa-plus"></i> Add Another Recipient
                                            </button>
                                            <span class="badge bg-info ms-2" id="manualCount">{{ $manualRecipients->count() > 0 ? $manualRecipients->count() : 1 }} recipient{{ $manualRecipients->count() === 1 ? '' : 's' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Email
                    </button>
                    <a href="{{ route('communications.email.show', $communication->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
// Contact search functionality
document.getElementById('contact-search').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const contacts = document.querySelectorAll('.contact-item');
    
    contacts.forEach(contact => {
        const text = contact.textContent.toLowerCase();
        contact.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});

// Update contact count
function updateContactCount() {
    const count = document.querySelectorAll('.contact-checkbox:checked').length;
    document.getElementById('contactCount').textContent = count + ' selected';
}

// Select all contacts
function selectAllContacts() {
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(cb => {
        if (cb.closest('.contact-item').style.display !== 'none') {
            cb.checked = true;
        }
    });
    updateContactCount();
}

// Deselect all contacts
function deselectAllContacts() {
    document.querySelectorAll('.contact-checkbox').forEach(cb => cb.checked = false);
    updateContactCount();
}

// Manual recipients management
let recipientCount = {!! $manualRecipients->count() > 0 ? $manualRecipients->count() : 1 !!};

function addRecipient() {
    const html = `
        <div class="row manual-recipient mb-2 align-items-end">
            <div class="col-md-5">
                <label>Name (Optional)</label>
                <input type="text" name="manual_recipients[${recipientCount}][name]" class="form-control" 
                       placeholder="Recipient name">
            </div>
            <div class="col-md-6">
                <label>Email <span class="text-danger">*</span></label>
                <input type="email" name="manual_recipients[${recipientCount}][email]" class="form-control" 
                       placeholder="recipient@example.com">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger remove-recipient" onclick="removeRecipient(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    document.getElementById('manual-recipients').insertAdjacentHTML('beforeend', html);
    recipientCount++;
    updateManualCount();
}

function removeRecipient(button) {
    button.closest('.manual-recipient').remove();
    updateManualCount();
}

function updateManualCount() {
    const count = document.querySelectorAll('.manual-recipient').length;
    document.getElementById('manualCount').textContent = count + (count === 1 ? ' recipient' : ' recipients');
    
    // Enable/disable first remove button based on count
    const firstRemove = document.querySelector('.manual-recipient .remove-recipient');
    if (firstRemove) {
        firstRemove.disabled = count === 1;
    }
}

// Form validation before submit
document.getElementById('emailForm').addEventListener('submit', function(e) {
    const contactsChecked = document.querySelectorAll('.contact-checkbox:checked').length;
    const manualRecipients = document.querySelectorAll('.manual-recipient input[type="email"]');
    let manualCount = 0;
    
    manualRecipients.forEach(input => {
        if (input.value.trim()) manualCount++;
    });
    
    if (contactsChecked === 0 && manualCount === 0) {
        e.preventDefault();
        alert('Please select at least one recipient from contacts or add a manual recipient.');
        return false;
    }
});

// Initialize contact count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateContactCount();
});
</script>
@endsection
