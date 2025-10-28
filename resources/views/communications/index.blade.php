@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Communications</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Email Communications</h3>
                    </div>
                    <div class="card-body">
                        <p>Send bulk emails to your contacts with customizable templates.</p>
                        <a href="{{ route('communications.email.index') }}" class="btn btn-primary">
                            <i class="fas fa-envelope mr-1"></i> Manage Emails
                        </a>
                        <a href="{{ route('communications.email.create') }}" class="btn btn-success">
                            <i class="fas fa-plus mr-1"></i> Create New Email
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection