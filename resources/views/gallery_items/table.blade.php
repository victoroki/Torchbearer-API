<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover table-striped mb-0" id="gallery-items-table">
            <thead class="bg-primary text-white">
            <tr>
                <th>Preview</th>
                <th>Title</th>
                <th>Category</th>
                <th>Type</th>
                <th>Description</th>
                <th>Featured</th>
                <th>Rating</th>
                <th>Views</th>
                <th>Tags</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($galleryItems as $galleryItem)
                <tr>
                    <td>
                        @if($galleryItem->type === 'image')
                            <img src="{{ $galleryItem->file_url }}" 
                                 alt="{{ $galleryItem->title }}" 
                                 class="img-thumbnail" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @elseif($galleryItem->type === 'video')
                            <i class="fas fa-video fa-2x text-danger"></i>
                        @else
                            <i class="fas fa-file fa-2x text-secondary"></i>
                        @endif
                    </td>
                    <td>
                        <strong class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $galleryItem->title }}">
                            {{ $galleryItem->title }}
                        </strong>
                    </td>
                    <td>
                        <span class="badge badge-success">{{ $galleryItem->category }}</span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($galleryItem->type) }}</span>
                    </td>
                    <td>
                        <span class="d-inline-block text-truncate" style="max-width: 200px;" title="{{ $galleryItem->description }}">
                            {{ $galleryItem->description ?: 'No description' }}
                        </span>
                    </td>
                    <td>
                        @if($galleryItem->featured)
                            <span class="badge badge-warning">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @else
                            <span class="badge badge-secondary">Regular</span>
                        @endif
                    </td>
                    <td>
                        <span class="text-warning">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $galleryItem->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-light">
                            <i class="fas fa-eye text-primary"></i> {{ number_format($galleryItem->views) }}
                        </span>
                    </td>
                    <td>
                        <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $galleryItem->tags }}">
                            @if($galleryItem->tags)
                                @foreach(explode(',', $galleryItem->tags) as $tag)
                                    <span class="badge badge-primary badge-sm">{{ trim($tag) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No tags</span>
                            @endif
                        </span>
                    </td>
                    <td style="width: 120px">
                        {!! Form::open(['route' => ['gallery-items.destroy', $galleryItem->id], 'method' => 'delete', 'class' => 'd-inline']) !!}
                        <div class='btn-group' role="group">
                            <a href="{{ route('gallery-items.show', [$galleryItem->id]) }}"
                               class='btn btn-info btn-sm' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('gallery-items.edit', [$galleryItem->id]) }}"
                               class='btn btn-warning btn-sm' title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit', 
                                'class' => 'btn btn-danger btn-sm', 
                                'title' => 'Delete',
                                'onclick' => "return confirm('Are you sure you want to delete this item?')"
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer clearfix bg-light">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $galleryItems])
        </div>
    </div>
</div>

<style>
    /* Optional: Add hover effect for better UX */
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        cursor: pointer;
    }
    
    /* Smooth thumbnail hover */
    .img-thumbnail:hover {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
</style>