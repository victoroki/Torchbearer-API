@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Create Email Communication</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('adminlte-templates::common.errors')

        <div class="card">
            <form action="{{ route('communications.email.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <!-- Subject Field -->
                        <div class="form-group col-sm-12">
                            <label for="subject">Subject:</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>

                        <!-- From Name Field -->
                        <div class="form-group col-sm-6">
                            <label for="from_name">From Name:</label>
                            <input type="text" name="from_name" id="from_name" class="form-control" required>
                        </div>

                        <!-- From Email Field -->
                        <div class="form-group col-sm-6">
                            <label for="from_email">From Email:</label>
                            <input type="email" name="from_email" id="from_email" class="form-control" required>
                        </div>

                        <!-- Reply To Field -->
                        <div class="form-group col-sm-6">
                            <label for="reply_to">Reply To (optional):</label>
                            <input type="email" name="reply_to" id="reply_to" class="form-control">
                        </div>

                        <!-- CC Field -->
                        <div class="form-group col-sm-6">
                            <label for="cc">CC (optional, comma separated):</label>
                            <input type="text" name="cc" id="cc" class="form-control">
                        </div>

                        <!-- BCC Field -->
                        <div class="form-group col-sm-6">
                            <label for="bcc">BCC (optional, comma separated):</label>
                            <input type="text" name="bcc" id="bcc" class="form-control">
                        </div>

                        <!-- Attachment Field -->
                        <div class="form-group col-sm-6">
                            <label for="attachment">Attachment (optional):</label>
                            <input type="file" name="attachment" id="attachment" class="form-control-file">
                        </div>

                        <!-- Content Field -->
                        <div class="form-group col-sm-12">
                            <label for="content">Email Content:</label>
                            <textarea name="content" id="content" class="form-control" rows="10" required></textarea>
                        </div>

                        <!-- Recipients Section -->
                        <div class="form-group col-sm-12">
                            <label>Recipients:</label>
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs" id="recipientTabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="true">Contacts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="manual-tab" data-toggle="tab" href="#manual" role="tab" aria-controls="manual" aria-selected="false">Manual</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content mt-3" id="recipientTabsContent">
                                        <div class="tab-pane fade show active" id="contacts" role="tabpanel">
                                            <div class="form-group">
                                                <input type="text" id="contact-search" class="form-control mb-3" placeholder="Search contacts...">
                                                <div class="contact-list" style="max-height: 300px; overflow-y: auto;">
                                                    @foreach($contacts as $contact)
                                                        <div class="custom-control custom-checkbox mb-2">
                                                            <input type="checkbox" class="custom-control-input" id="contact-{{ $contact->id }}" name="recipients_contacts[]" value="{{ $contact->id }}">
                                                            <label class="custom-control-label" for="contact-{{ $contact->id }}">{{ $contact->name }} ({{ $contact->email ?: $contact->phone }})</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="mt-2">
                                                    <a href="{{ route('communications.contacts.create') }}" class="btn btn-sm btn-success" target="_blank">
                                                        <i class="fas fa-plus"></i> Add New Contact
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="manual" role="tabpanel">
                                            <div id="manual-recipients">
                                                <div class="row manual-recipient mb-2">
                                                    <div class="col-md-4">
                                                        <input type="text" name="manual_recipients[0][name]" class="form-control" placeholder="Name">
                                                    </div>
                                                    <div class="col-md-7">
                                                        <input type="email" name="manual_recipients[0][email]" class="form-control" placeholder="Email" required>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger remove-recipient"><i class="fas fa-times"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" id="add-recipient" class="btn btn-sm btn-primary mt-2">Add Recipient</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('communications.email.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('page_scripts')
<script>
    $(document).ready(function() {
        // Initialize rich text editor for email content
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('content');
        }
        
        // User search functionality
        $("#user-search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".custom-checkbox").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        
        // Add manual recipient
        let recipientCount = 1;
        $("#add-recipient").click(function() {
            let newRecipient = `
                <div class="row manual-recipient mb-2">
                    <div class="col-md-4">
                        <input type="text" name="manual_recipients[${recipientCount}][name]" class="form-control" placeholder="Name">
                    </div>
                    <div class="col-md-7">
                        <input type="email" name="manual_recipients[${recipientCount}][email]" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger remove-recipient"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `;
            $("#manual-recipients").append(newRecipient);
            recipientCount++;
        });
        
        // Remove manual recipient
        $(document).on("click", ".remove-recipient", function() {
            $(this).closest(".manual-recipient").remove();
        });
    });
</script>
@endpush