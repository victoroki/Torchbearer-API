<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="license-classes-table">
            <thead class="thead-light">
            <tr>
                <th>License Type</th>
                <th>Class</th>
                <th>Scope</th>
                <th>Min Qualification</th>
                <th>Technical Qualification</th>
                <th>Experience Requirements</th>
                <th>Starting License</th>
                <th>Highest Achievable</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($licenseClasses as $licenseClass)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $licenseClass->license_type }}">
                            {{ Str::limit($licenseClass->license_type, 25) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $licenseClass->class }}">
                            {{ Str::limit($licenseClass->class, 20) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $licenseClass->scope }}">
                            {{ Str::limit($licenseClass->scope, 30) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $licenseClass->min_qualification }}">
                            {{ Str::limit($licenseClass->min_qualification, 25) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $licenseClass->technical_qualification }}">
                            {{ Str::limit($licenseClass->technical_qualification, 25) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $licenseClass->experience_requirements }}">
                            {{ Str::limit($licenseClass->experience_requirements, 30) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $licenseClass->starting_license }}">
                            {{ Str::limit($licenseClass->starting_license, 20) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $licenseClass->highest_achievable }}">
                            {{ Str::limit($licenseClass->highest_achievable, 20) }}
                        </span>
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['license-classes.destroy', $licenseClass->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('license-classes.show', [$licenseClass->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('license-classes.edit', [$licenseClass->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $licenseClasses])
        </div>
    </div>
</div>
