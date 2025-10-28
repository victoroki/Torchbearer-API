<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="certificates-table">
            <thead class="thead-light">
            <tr>
                <th>Certificate ID</th>
                <th>Recipient Name</th>
                <th>Recipient Email</th>
                <th>Course Name</th>
                <th>Issue Date</th>
                <th class="text-center">Status</th>
                <th class="text-center">Email Sent</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($certificates as $certificate)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $certificate->certificate_id }}">
                            {{ Str::limit($certificate->certificate_id, 20) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $certificate->recipient_name }}">
                            {{ Str::limit($certificate->recipient_name, 25) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $certificate->recipient_email }}">
                            {{ Str::limit($certificate->recipient_email, 30) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $certificate->course_name }}">
                            {{ Str::limit($certificate->course_name, 30) }}
                        </span>
                    </td>
                    <td>
                        @if($certificate->issue_date)
                            {{ \Carbon\Carbon::parse($certificate->issue_date)->format('M d, Y') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($certificate->status == 'issued')
                            <span class="badge badge-success">Issued</span>
                        @elseif($certificate->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($certificate->status) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($certificate->email_sent_at)
                            <span class="badge badge-success">Yes</span>
                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($certificate->email_sent_at)->format('M d') }}</small>
                        @else
                            <span class="badge badge-light">No</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['certificates.destroy', $certificate->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('certificates.show', [$certificate->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('certificates.edit', [$certificate->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $certificates])
        </div>
    </div>
</div>
