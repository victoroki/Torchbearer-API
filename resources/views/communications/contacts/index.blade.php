@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Communication Contacts</h3>
                <a href="{{ route('communications.contacts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Contact
                </a>
            </div>

            <div class="card-body">
                @include('flash::message')

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Name</th>
                                <th>Contact Info</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td class="font-weight-medium">{{ $contact->name }}</td>
                                    <td>
                                        @if($contact->email)
                                            <div><i class="fas fa-envelope text-muted mr-1"></i> {{ $contact->email }}</div>
                                        @endif
                                        @if($contact->phone)
                                            <div><i class="fas fa-phone text-muted mr-1"></i> {{ $contact->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('communications.contacts.edit', $contact->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('communications.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection