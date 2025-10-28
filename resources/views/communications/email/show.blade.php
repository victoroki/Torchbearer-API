@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Email Communication Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('communications.email.index') }}">
                        Back
                    </a>
                    @if($communication->status == 'draft')
                        <a href="{{ route('communications.email.send', [$communication->id]) }}" class="btn btn-primary float-right mr-2">
                            <i class="fas fa-paper-plane"></i> Send Email
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Email Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Subject:</label>
                            <p>{{ $communication->subject }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status:</label>
                            <p>
                                @if($communication->status == 'draft')
                                    <span class="badge badge-warning">Draft</span>
                                @elseif($communication->status == 'sending')
                                    <span class="badge badge-info">Sending</span>
                                @elseif($communication->status == 'sent')
                                    <span class="badge badge-success">Sent</span>
                                @elseif($communication->status == 'failed')
                                    <span class="badge badge-danger">Failed</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>From:</label>
                            <p>{{ $emailDetails->from_name }} &lt;{{ $emailDetails->from_email }}&gt;</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Reply To:</label>
                            <p>{{ $emailDetails->reply_to ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>CC:</label>
                            <p>{{ $emailDetails->cc ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>BCC:</label>
                            <p>{{ $emailDetails->bcc ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Attachment:</label>
                            <p>
                                @if($emailDetails->attachment_path)
                                    <a href="{{ asset('storage/' . $emailDetails->attachment_path) }}" target="_blank">
                                        <i class="fas fa-paperclip"></i> View Attachment
                                    </a>
                                @else
                                    No Attachment
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Created At:</label>
                            <p>{{ $communication->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Email Content:</label>
                            <div class="p-3 bg-light border rounded">
                                {!! $communication->content !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recipients ({{ $communication->recipients->count() }})</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Status Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($communication->recipients as $recipient)
                                <tr>
                                    <td>{{ $recipient->name }}</td>
                                    <td>{{ $recipient->email }}</td>
                                    <td>
                                        @if($recipient->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($recipient->status == 'sent')
                                            <span class="badge badge-success">Sent</span>
                                        @elseif($recipient->status == 'failed')
                                            <span class="badge badge-danger">Failed</span>
                                        @endif
                                    </td>
                                    <td>{{ $recipient->status_message ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection