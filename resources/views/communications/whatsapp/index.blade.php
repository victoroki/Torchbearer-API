@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>WhatsApp Communications</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')
        
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalContacts }}</h3>
                        <p>Active Contacts</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <a href="{{ route('communications.whatsapp.contacts') }}" class="small-box-footer">
                        Manage Contacts <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $sentMessages }}</h3>
                        <p>Sent Messages</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <a href="{{ route('communications.whatsapp.history', ['status' => 'sent']) }}" class="small-box-footer">
                        View Details <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalMessages }}</h3>
                        <p>Total Messages</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <a href="{{ route('communications.whatsapp.history') }}" class="small-box-footer">
                        View History <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $failedMessages }}</h3>
                        <p>Failed Messages</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <a href="{{ route('communications.whatsapp.history', ['status' => 'failed']) }}" class="small-box-footer">
                        View Failed <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="{{ route('communications.whatsapp.send') }}" class="btn btn-primary btn-block btn-lg">
                                    <i class="fas fa-paper-plane"></i> Send Single Message
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('communications.whatsapp.broadcast') }}" class="btn btn-success btn-block btn-lg">
                                    <i class="fas fa-broadcast-tower"></i> Broadcast Message
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('communications.whatsapp.contacts') }}" class="btn btn-info btn-block btn-lg">
                                    <i class="fas fa-users"></i> Manage Contacts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Messages</h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Recipient</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Sent By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMessages as $message)
                                    <tr>
                                        <td>{{ $message->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            {{ $message->recipient_name ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $message->recipient_phone }}</small>
                                        </td>
                                        <td>{{ \Str::limit($message->message, 50) }}</td>
                                        <td>
                                            @if($message->status == 'sent')
                                                <span class="badge badge-success">Sent</span>
                                            @elseif($message->status == 'failed')
                                                <span class="badge badge-danger">Failed</span>
                                            @elseif($message->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-info">{{ ucfirst($message->status) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $message->user->name ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No messages found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
