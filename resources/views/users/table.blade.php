<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="users-table">
            <thead class="thead-light">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $user->username }}">
                            {{ Str::limit($user->username, 25) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $user->email }}">
                            {{ Str::limit($user->email, 30) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td class="text-center">
                        @if($user->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('users.show', [$user->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', [$user->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $users])
        </div>
    </div>
</div>
