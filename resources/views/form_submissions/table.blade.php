<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="form-submissions-table">
            <thead class="thead-light">
            <tr>
                <th>Email</th>
                <th>Phone</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Form Type</th>
                <th class="text-center">Status</th>
                <th>Date</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($formSubmissions as $formSubmission)
                <tr>
                    <td>
                        <span title="{{ $formSubmission->email }}">
                            {{ Str::limit($formSubmission->email, 25) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $formSubmission->phone }}">
                            {{ Str::limit($formSubmission->phone, 15) }}
                        </span>
                    </td>
                    <td class="font-weight-medium">
                        <span title="{{ $formSubmission->subject }}">
                            {{ Str::limit($formSubmission->subject, 30) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $formSubmission->message }}">
                            {{ Str::limit($formSubmission->message, 40) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($formSubmission->form_type) }}</span>
                    </td>
                    <td class="text-center">
                        @if($formSubmission->status == 'new')
                            <span class="badge badge-warning">New</span>
                        @elseif($formSubmission->status == 'read')
                            <span class="badge badge-info">Read</span>
                        @elseif($formSubmission->status == 'replied')
                            <span class="badge badge-success">Replied</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($formSubmission->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($formSubmission->created_at)
                            {{ $formSubmission->created_at->format('M d, Y') }}
                            <br><small class="text-muted">{{ $formSubmission->created_at->format('g:i A') }}</small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['form-submissions.destroy', $formSubmission->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('form-submissions.show', [$formSubmission->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('form-submissions.edit', [$formSubmission->id]) }}"
                               class='btn btn-default btn-xs' title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')", 'title' => 'Delete']) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $formSubmissions])
        </div>
    </div>
</div>
