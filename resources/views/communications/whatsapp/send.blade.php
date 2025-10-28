@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Send WhatsApp Message</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-secondary float-right" href="{{ route('communications.whatsapp.index') }}">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Message Details</h3>
            </div>
            <form action="{{ route('communications.whatsapp.send.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Recipient Type</label>
                                <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="typeContact" name="recipient_type" 
                                               class="custom-control-input" value="contact" checked 
                                               onchange="toggleRecipientType()">
                                        <label class="custom-control-label" for="typeContact">From Contacts</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="typeManual" name="recipient_type" 
                                               class="custom-control-input" value="manual" 
                                               onchange="toggleRecipientType()">
                                        <label class="custom-control-label" for="typeManual">Manual Entry</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="contactSelection" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_id">Select Contact <span class="text-danger">*</span></label>
                                <select class="form-control" id="contact_id" name="contact_id">
                                    <option value="">-- Select Contact --</option>
                                    @foreach($contacts as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->phone_number }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="manualEntry" class="row" style="display: none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="recipient_phone">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="recipient_phone" 
                                       name="recipient_phone" placeholder="e.g., 254712345678">
                                <small class="form-text text-muted">Include country code without +</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="recipient_name">Recipient Name (Optional)</label>
                                <input type="text" class="form-control" id="recipient_name" name="recipient_name">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="message">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                <small class="form-text text-muted">
                                    <span id="charCount">0</span> characters
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="includeMedia" 
                                           onchange="toggleMediaFields()">
                                    <label class="custom-control-label" for="includeMedia">Include Media</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="mediaFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="media_type">Media Type</label>
                                    <select class="form-control" id="media_type" name="media_type">
                                        <option value="">-- Select Type --</option>
                                        <option value="image">Image</option>
                                        <option value="document">Document (PDF, Word, Excel, etc.)</option>
                                        <option value="video">Video</option>
                                        <option value="audio">Audio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="media_url">Media URL</label>
                                    <input type="url" class="form-control" id="media_url" name="media_url" 
                                           placeholder="https://example.com/file.pdf">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="media_caption">Media Caption (Optional)</label>
                                    <input type="text" class="form-control" id="media_caption" name="media_caption">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                    <a href="{{ route('communications.whatsapp.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function toggleRecipientType() {
    const isContact = document.getElementById('typeContact').checked;
    document.getElementById('contactSelection').style.display = isContact ? 'block' : 'none';
    document.getElementById('manualEntry').style.display = isContact ? 'none' : 'block';
    
    if (isContact) {
        document.getElementById('contact_id').required = true;
        document.getElementById('recipient_phone').required = false;
    } else {
        document.getElementById('contact_id').required = false;
        document.getElementById('recipient_phone').required = true;
    }
}

function toggleMediaFields() {
    const includeMedia = document.getElementById('includeMedia').checked;
    document.getElementById('mediaFields').style.display = includeMedia ? 'block' : 'none';
    
    if (includeMedia) {
        document.getElementById('media_type').required = true;
        document.getElementById('media_url').required = true;
    } else {
        document.getElementById('media_type').required = false;
        document.getElementById('media_url').required = false;
    }
}

// Character counter
document.getElementById('message').addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});
</script>
@endsection
