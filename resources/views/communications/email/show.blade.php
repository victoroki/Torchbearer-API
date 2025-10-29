@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-envelope"></i> Email Communication Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-secondary float-right" href="{{ route('communications.email.index') }}">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Email Information
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Subject:</strong></label>
                            <p>{{ $communication->subject }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Status:</strong></label>
                            <p>
                                @if($communication->status == 'draft')
                                    <span class="badge badge-warning">Draft</span>
                                @elseif($communication->status == 'sending')
                                    <span class="badge badge-info">Sending</span>
                                @elseif($communication->status == 'sent')
                                    <span class="badge badge-success">Sent</span>
                                @elseif($communication->status == 'failed')
                                    <span class="badge badge-danger">Failed</span>
                                @elseif($communication->status == 'partial')
                                    <span class="badge badge-warning">Partially Sent</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>From:</strong></label>
                            <p>
                                @if($communication->emailDetails)
                                    {{ $communication->emailDetails->from_name ?? 'N/A' }} 
                                    &lt;{{ $communication->emailDetails->from_email ?? 'N/A' }}&gt;
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Reply To:</strong></label>
                            <p>
                                @if($communication->emailDetails && $communication->emailDetails->reply_to)
                                    {{ $communication->emailDetails->reply_to }}
                                @else
                                    <span class="text-muted">Not set</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($communication->emailDetails && ($communication->emailDetails->cc || $communication->emailDetails->bcc))
                <div class="row">
                    @if($communication->emailDetails->cc)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>CC:</strong></label>
                            <p>{{ $communication->emailDetails->cc }}</p>
                        </div>
                    </div>
                    @endif
                    
                    @if($communication->emailDetails->bcc)
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>BCC:</strong></label>
                            <p>{{ $communication->emailDetails->bcc }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Created At:</strong></label>
                            <p>{{ $communication->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>Created By:</strong></label>
                            <p>{{ $communication->creator->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                </div>

                @if($communication->emailDetails && $communication->emailDetails->attachment_path)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Attachment:</strong></label>
                            <p>
                                <i class="fas fa-paperclip"></i> 
                                <a href="{{ Storage::url($communication->emailDetails->attachment_path) }}" target="_blank">
                                    {{ basename($communication->emailDetails->attachment_path) }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>Content:</strong></label>
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($communication->content)) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recipients Section -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-info text-white">
                <h3 class="card-title mb-0">
                    <i class="fas fa-users"></i> Recipients ({{ $communication->recipients->count() }})
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($communication->recipients as $recipient)
                            <tr>
                                <td>{{ $recipient->name ?? 'N/A' }}</td>
                                <td>{{ $recipient->email }}</td>
                                <td>
                                    <span class="badge badge-secondary">
                                        {{ ucfirst($recipient->recipient_type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($recipient->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($recipient->status == 'sent')
                                        <span class="badge badge-success">Sent</span>
                                    @elseif($recipient->status == 'failed')
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $recipient->status_message ?? '-' }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    No recipients found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <div class="btn-group" role="group">
                    @if($communication->status == 'draft')
                        <!-- Edit Button -->
                        <a href="{{ route('communications.email.edit', $communication->id) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Send Button -->
                        <form action="{{ route('communications.email.send', $communication->id) }}" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('Are you sure you want to send this email to {{ $communication->recipients->count() }} recipient(s)?')">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Send Now
                            </button>
                        </form>
                    @endif

                    <!-- Delete Button -->
                    <form action="{{ route('communications.email.destroy', $communication->id) }}" 
                          method="POST" 
                          style="display:inline;"
                          onsubmit="return confirm('Are you sure you want to delete this email?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>

                    <!-- Back Button -->
                    <a href="{{ route('communications.email.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection