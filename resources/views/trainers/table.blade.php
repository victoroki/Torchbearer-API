<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="trainers-table">
            <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Bio</th>
                <th class="text-center">Courses</th>
                <th>Experience</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trainers as $trainer)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $trainer->name }}">
                            {{ Str::limit($trainer->name, 25) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ $trainer->role }}</span>
                    </td>
                    <td>
                        <span title="{{ $trainer->bio }}">
                            {{ Str::limit($trainer->bio, 40) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-light">{{ $trainer->courses }}</span>
                    </td>
                    <td>
                        <span title="{{ $trainer->experience }}">
                            {{ Str::limit($trainer->experience, 30) }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($trainer->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['trainers.destroy', $trainer->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('trainers.show', [$trainer->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('trainers.edit', [$trainer->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $trainers])
        </div>
    </div>
</div>
