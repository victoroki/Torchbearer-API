<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="useful-links-table">
            <thead class="thead-light">
            <tr>
                <th>Title</th>
                <th>URL</th>
                <th>Description</th>
                <th>Category</th>
                <th class="text-center">Featured</th>
                <th class="text-center">Rating</th>
                <th class="text-center">Visits</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($usefulLinks as $usefulLink)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $usefulLink->title }}">
                            {{ Str::limit($usefulLink->title, 30) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ $usefulLink->url }}" target="_blank" class="text-primary" title="{{ $usefulLink->url }}">
                            {{ Str::limit($usefulLink->url, 25) }}
                            <i class="fas fa-external-link-alt ml-1"></i>
                        </a>
                    </td>
                    <td>
                        <span title="{{ $usefulLink->description }}">
                            {{ Str::limit($usefulLink->description, 40) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $usefulLink->category }}</span>
                    </td>
                    <td class="text-center">
                        @if($usefulLink->featured)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-light">No</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($usefulLink->rating)
                            <span class="badge badge-warning">{{ $usefulLink->rating }}/5</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge badge-light">{{ $usefulLink->visits }}</span>
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['useful-links.destroy', $usefulLink->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('useful-links.show', [$usefulLink->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('useful-links.edit', [$usefulLink->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $usefulLinks])
        </div>
    </div>
</div>
