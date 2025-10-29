<div class="table-responsive">
    <table class="table table-hover" id="emailCommunications-table">
        <thead class="thead-light">
        <tr>
            <th>Subject</th>
            <th>Status</th>
            <th class="text-center">Recipients</th>
            <th>Date</th>
            <th class="text-center">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($emailCommunications as $communication)
            <tr>
                <td class="font-weight-medium">
                    <span title="{{ $communication->subject }}">
                        {{ Str::limit($communication->subject, 40) }}
                    </span>
                </td>
                <td>
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
                    @else
                        <span class="badge badge-secondary">{{ ucfirst($communication->status) }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <span class="badge badge-light">{{ $communication->recipients->count() }}</span>
                </td>
                <td>{{ $communication->created_at->format('M d, Y') }}</td>
                <td class="text-center">
                    <div class='btn-group'>
                        <!-- View Button -->
                        <a href="{{ route('communications.email.show', [$communication->id]) }}"
                           class='btn btn-default btn-xs'
                           title="View">
                            <i class="far fa-eye"></i>
                        </a>
                        
                        @if($communication->status == 'draft')
                            <!-- Edit Button (only for drafts) -->
                            <a href="{{ route('communications.email.edit', [$communication->id]) }}"
                               class='btn btn-default btn-xs'
                               title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                            
                            <!-- Send Button (only for drafts) -->
                            <form action="{{ route('communications.email.send', $communication->id) }}" 
                                  method="POST" 
                                  style="display:inline;"
                                  onsubmit="return confirm('Are you sure you want to send this email to {{ $communication->recipients->count() }} recipient(s)?')">
                                @csrf
                                <button type="submit" class='btn btn-info btn-xs' title="Send Email">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        @endif
                        
                        <!-- Delete Button -->
                        <form action="{{ route('communications.email.destroy', $communication->id) }}" 
                              method="POST" 
                              style="display:inline;"
                              onsubmit="return confirm('Are you sure you want to delete this email communication?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class='btn btn-danger btn-xs' title="Delete">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                        <p class="mb-2">No email communications found</p>
                        <a href="{{ route('communications.email.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Your First Email
                        </a>
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>