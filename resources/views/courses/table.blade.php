<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="courses-table">
            <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Trainer</th>
                <th class="text-center">Status</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($courses as $course)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $course->name }}">
                            {{ Str::limit($course->name, 30) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $course->description }}">
                            {{ Str::limit($course->description, 50) }}
                        </span>
                    </td>
                    <td>
                        <span title="{{ $course->trainer ?? 'N/A' }}">
                            {{ Str::limit($course->trainer ?? 'N/A', 25) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" 
                                   class="custom-control-input status-toggle" 
                                   id="statusSwitch{{ $course->id }}"
                                   data-id="{{ $course->id }}"
                                   {{ $course->status == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="statusSwitch{{ $course->id }}">
                                <span class="badge badge-{{ $course->status == 1 ? 'success' : 'secondary' }}">
                                    {{ $course->status == 1 ? 'Active' : 'Inactive' }}
                                </span>
                            </label>
                        </div>
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['courses.destroy', $course->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('courses.show', [$course->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('courses.edit', [$course->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $courses])
        </div>
    </div>
</div>

@push('page_scripts')
<script>
$(document).ready(function() {
    $('.status-toggle').change(function() {
        var courseId = $(this).data('id');
        var toggle = $(this);
        var label = toggle.next('label').find('.badge');
        
        $.ajax({
            url: '/courses/' + courseId + '/toggle-status',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if(response.success) {
                    if(response.status == 1) {
                        label.removeClass('badge-secondary').addClass('badge-success').text('Active');
                    } else {
                        label.removeClass('badge-success').addClass('badge-secondary').text('Inactive');
                    }
                    
                    // Optional: Show success message
                    toastr.success(response.message);
                }
            },
            error: function(xhr) {
                // Revert the toggle if there's an error
                toggle.prop('checked', !toggle.prop('checked'));
                toastr.error('Error updating status');
            }
        });
    });
});
</script>
@endpush