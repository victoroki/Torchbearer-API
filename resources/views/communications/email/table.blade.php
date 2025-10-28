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
        @foreach($emailCommunications as $communication)
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
                    @endif
                </td>
                <td class="text-center"><span class="badge badge-light">{{ $communication->recipients->count() }}</span></td>
                <td>{{ $communication->created_at->format('M d, Y') }}</td>
                <td class="text-center">
                    {!! Form::open(['route' => ['communications.email.destroy', $communication->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('communications.email.show', [$communication->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        @if($communication->status == 'draft')
                            <a href="{{ route('communications.email.edit', [$communication->id]) }}"
                               class='btn btn-default btn-xs'>
                                <i class="far fa-edit"></i>
                            </a>
                            <a href="{{ route('communications.email.send', [$communication->id]) }}"
                               class='btn btn-info btn-xs' onclick="return confirm('Are you sure you want to send this email?')">
                                <i class="fas fa-paper-plane"></i>
                            </a>
                        @endif
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>