<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="resources-table">
            <thead class="thead-light">
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Type</th>
                <th>Size</th>
                <th class="text-center">Downloads</th>
                <th class="text-center">Rating</th>
                <th>Description</th>
                <th>Author</th>
                <th>Date</th>
                <th class="text-center">Featured</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($resources as $resource)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $resource->title }}">
                            {{ Str::limit($resource->title, 30) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $resource->category }}</span>
                    </td>
                    <td>
                        <span class="badge badge-secondary">{{ $resource->type }}</span>
                    </td>
                    <td>
                        <span title="{{ $resource->size }}">
                            {{ Str::limit($resource->size, 15) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-light">{{ $resource->downloads }}</span>
                    </td>
                    <td class="text-center">
                        @if($resource->rating)
                            <span class="badge badge-warning">{{ $resource->rating }}/5</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span title="{{ $resource->description }}">
                            {{ Str::limit($resource->description, 40) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $resource->author }}">
                            {{ Str::limit($resource->author, 20) }}
                        </span>
                    </td>
                    <td>
                        @if($resource->date)
                            {{ \Carbon\Carbon::parse($resource->date)->format('M d, Y') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($resource->featured)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-light">No</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['resources.destroy', $resource->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('resources.show', [$resource->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('resources.edit', [$resource->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $resources])
        </div>
    </div>
</div>
