@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WhatsApp Message History</h1>
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

        <!-- Filters -->
        <div class="card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Filters</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('communications.whatsapp.history') }}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_from">Date From</label>
                                <input type="date" class="form-control" id="date_from" name="date_from" 
                                       value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_to">Date To</label>
                                <input type="date" class="form-control" id="date_to" name="date_to" 
                                       value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">Search</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Name, phone, message..." value="{{ request('search') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Apply Filters
                            </button>
                            <a href="{{ route('communications.whatsapp.history') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Messages Table -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Date & Time</th>
                                <th>Recipient</th>
                                <th>Message</th>
                                <th>Media</th>
                                <th>Status</th>
                                <th>Sent By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                                <tr>
                                    <td>{{ $message->id }}</td>
                                    <td>
                                        {{ $message->created_at->format('Y-m-d') }}<br>
                                        <small class="text-muted">{{ $message->created_at->format('H:i:s') }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $message->recipient_name ?? 'N/A' }}</strong><br>
                                        <small class="text-muted">{{ $message->recipient_phone }}</small>
                                        @if($message->contact)
                                            <br><span class="badge badge-info badge-sm">Contact</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" 
                                             title="{{ $message->message }}">
                                            {{ $message->message }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($message->media_type)
                                            <span class="badge badge-secondary">
                                                <i class="fas fa-file"></i> {{ ucfirst($message->media_type) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($message->status == 'sent')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check"></i> Sent
                                            </span>
                                            @if($message->sent_at)
                                                <br><small class="text-muted">{{ $message->sent_at->format('H:i:s') }}</small>
                                            @endif
                                        @elseif($message->status == 'failed')
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times"></i> Failed
                                            </span>
                                            @if($message->error_message)
                                                <br><small class="text-danger" title="{{ $message->error_message }}">
                                                    {{ \Str::limit($message->error_message, 30) }}
                                                </small>
                                            @endif
                                        @elseif($message->status == 'pending')
                                            <span class="badge badge-warning">
                                                <i class="fas fa-clock"></i> Pending
                                            </span>
                                        @elseif($message->status == 'delivered')
                                            <span class="badge badge-info">
                                                <i class="fas fa-check-double"></i> Delivered
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($message->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $message->user->name ?? 'N/A' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" 
                                                onclick="viewMessage({{ $message->id }}, '{{ addslashes($message->recipient_name ?? 'N/A') }}', '{{ $message->recipient_phone }}', '{{ addslashes($message->message) }}', '{{ $message->status }}', '{{ $message->created_at->format('Y-m-d H:i:s') }}', '{{ addslashes($message->error_message ?? '') }}', '{{ $message->media_type ?? '' }}', '{{ $message->media_url ?? '' }}', '{{ addslashes($message->media_caption ?? '') }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No messages found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $messages->appends(request()->query())->links() }}
                </div>
                <div class="float-left">
                    Showing {{ $messages->firstItem() ?? 0 }} to {{ $messages->lastItem() ?? 0 }} 
                    of {{ $messages->total() }} messages
                </div>
            </div>
        </div>
    </div>

    <!-- View Message Modal -->
    <div class="modal fade" id="viewMessageModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Message Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">Message ID</th>
                            <td id="view_message_id"></td>
                        </tr>
                        <tr>
                            <th>Recipient Name</th>
                            <td id="view_recipient_name"></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td id="view_recipient_phone"></td>
                        </tr>
                        <tr>
                            <th>Message</th>
                            <td id="view_message" style="white-space: pre-wrap;"></td>
                        </tr>
                        <tr id="media_row" style="display: none;">
                            <th>Media</th>
                            <td>
                                <strong>Type:</strong> <span id="view_media_type"></span><br>
                                <strong>URL:</strong> <a id="view_media_url" href="#" target="_blank"></a><br>
                                <strong>Caption:</strong> <span id="view_media_caption"></span>
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td id="view_status"></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td id="view_created_at"></td>
                        </tr>
                        <tr id="error_row" style="display: none;">
                            <th>Error Message</th>
                            <td id="view_error_message" class="text-danger"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
function viewMessage(id, name, phone, message, status, createdAt, errorMessage, mediaType, mediaUrl, mediaCaption) {
    document.getElementById('view_message_id').textContent = id;
    document.getElementById('view_recipient_name').textContent = name;
    document.getElementById('view_recipient_phone').textContent = phone;
    document.getElementById('view_message').textContent = message;
    document.getElementById('view_status').innerHTML = getStatusBadge(status);
    document.getElementById('view_created_at').textContent = createdAt;
    
    // Handle media
    if (mediaType) {
        document.getElementById('media_row').style.display = '';
        document.getElementById('view_media_type').textContent = mediaType;
        document.getElementById('view_media_url').textContent = mediaUrl;
        document.getElementById('view_media_url').href = mediaUrl;
        document.getElementById('view_media_caption').textContent = mediaCaption || 'N/A';
    } else {
        document.getElementById('media_row').style.display = 'none';
    }
    
    // Handle error message
    if (errorMessage) {
        document.getElementById('error_row').style.display = '';
        document.getElementById('view_error_message').textContent = errorMessage;
    } else {
        document.getElementById('error_row').style.display = 'none';
    }
    
    $('#viewMessageModal').modal('show');
}

function getStatusBadge(status) {
    const badges = {
        'sent': '<span class="badge badge-success"><i class="fas fa-check"></i> Sent</span>',
        'failed': '<span class="badge badge-danger"><i class="fas fa-times"></i> Failed</span>',
        'pending': '<span class="badge badge-warning"><i class="fas fa-clock"></i> Pending</span>',
        'delivered': '<span class="badge badge-info"><i class="fas fa-check-double"></i> Delivered</span>'
    };
    return badges[status] || '<span class="badge badge-secondary">' + status + '</span>';
}
</script>
@endsection
