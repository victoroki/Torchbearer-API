@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Broadcast WhatsApp Message</h1>
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
                <h3 class="card-title">Broadcast Message to Multiple Contacts</h3>
            </div>
            <form action="{{ route('communications.whatsapp.broadcast.store') }}" method="POST" id="broadcastForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                Select multiple contacts to send the same message to all of them. 
                                Messages will be queued and sent individually to each recipient.
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Filter by Group</label>
                                <div class="btn-group btn-group-sm mb-2" role="group">
                                    <button type="button" class="btn btn-outline-primary" onclick="selectAll()">
                                        Select All
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" onclick="deselectAll()">
                                        Deselect All
                                    </button>
                                    @foreach($groups as $group)
                                        <button type="button" class="btn btn-outline-info" 
                                                onclick="selectByGroup('{{ $group }}')">
                                            {{ $group }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select Recipients <span class="text-danger">*</span></label>
                                <div class="border p-3" style="max-height: 300px; overflow-y: auto;">
                                    <div class="row">
                                        @forelse($contacts as $contact)
                                            <div class="col-md-4 mb-2">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input contact-checkbox" 
                                                           id="contact_{{ $contact->id }}" 
                                                           name="contact_ids[]" 
                                                           value="{{ $contact->id }}"
                                                           data-group="{{ $contact->group }}">
                                                    <label class="custom-control-label" for="contact_{{ $contact->id }}">
                                                        {{ $contact->name }}
                                                        <br>
                                                        <small class="text-muted">{{ $contact->phone_number }}</small>
                                                        @if($contact->group)
                                                            <br><span class="badge badge-info badge-sm">{{ $contact->group }}</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-md-12">
                                                <p class="text-center text-muted">No active contacts found. 
                                                    <a href="{{ route('communications.whatsapp.contacts') }}">Add contacts</a>
                                                </p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <small class="form-text text-muted">
                                    <span id="selectedCount">0</span> contact(s) selected
                                </small>
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
                    <button type="submit" class="btn btn-success" id="broadcastBtn">
                        <i class="fas fa-broadcast-tower"></i> Broadcast Message
                    </button>
                    <a href="{{ route('communications.whatsapp.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
// Character counter
document.getElementById('message').addEventListener('input', function() {
    document.getElementById('charCount').textContent = this.value.length;
});

// Count selected contacts
document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
    checkbox.addEventListener('change', updateSelectedCount);
});

function updateSelectedCount() {
    const count = document.querySelectorAll('.contact-checkbox:checked').length;
    document.getElementById('selectedCount').textContent = count;
}

function selectAll() {
    document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
        checkbox.checked = true;
    });
    updateSelectedCount();
}

function deselectAll() {
    document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
        checkbox.checked = false;
    });
    updateSelectedCount();
}

function selectByGroup(group) {
    document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
        if (checkbox.dataset.group === group) {
            checkbox.checked = true;
        }
    });
    updateSelectedCount();
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

// Form validation
document.getElementById('broadcastForm').addEventListener('submit', function(e) {
    const selectedCount = document.querySelectorAll('.contact-checkbox:checked').length;
    
    if (selectedCount === 0) {
        e.preventDefault();
        alert('Please select at least one contact to broadcast to.');
        return false;
    }
    
    if (!confirm(`Are you sure you want to send this message to ${selectedCount} contact(s)?`)) {
        e.preventDefault();
        return false;
    }
    
    // Show loading state
    document.getElementById('broadcastBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Broadcasting...';
    document.getElementById('broadcastBtn').disabled = true;
});
</script>
@endsection
