<div class="card-body p-0">
    <!-- Search and Filter Section -->
    <div class="card-header bg-white border-bottom">
        <div class="row align-items-center">
            <div class="col-md-6 mb-2 mb-md-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                    </div>
                    <input type="text" class="form-control border-left-0" placeholder="Search training programs..." id="searchInput">
                </div>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <select class="form-control custom-select" id="typeFilter">
                    <option value="">All Types</option>
                    <option value="training">Training</option>
                    <option value="webinar">Webinar</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary btn-block" id="resetFilters">
                    <i class="fas fa-redo-alt mr-1"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" id="training-programs-table">
            <thead class="thead-light">
            <tr>
                <th class="border-top-0 font-weight-semibold">Title</th>
                <th class="border-top-0 font-weight-semibold">Description</th>
                <th class="border-top-0 font-weight-semibold">Type</th>
                <th class="border-top-0 font-weight-semibold">Start Date</th>
                <th class="border-top-0 font-weight-semibold">End Date</th>
                <th class="border-top-0 font-weight-semibold">Time</th>
                <th class="border-top-0 font-weight-semibold">Price</th>
                <th class="border-top-0 font-weight-semibold">Speaker</th>
                <th class="border-top-0 font-weight-semibold">Status</th>
                <th class="border-top-0 font-weight-semibold text-center" style="width: 130px">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trainingPrograms as $trainingProgram)
                <tr>
                    <td class="py-3">
                        <strong class="text-dark">{{ Str::limit($trainingProgram->title, 30) }}</strong>
                    </td>
                    <td class="py-3 text-muted small">
                        @if($trainingProgram->description)
                            <span title="{{ $trainingProgram->description }}" style="cursor: help;">
                                {{ Str::limit($trainingProgram->description, 50) }}
                            </span>
                        @else
                            <span class="text-muted font-italic">No description</span>
                        @endif
                    </td>
                    <td class="py-3">
                        <span class="badge badge-pill badge-{{ $trainingProgram->program_type == 'training' ? 'primary' : 'info' }} px-3 py-1">
                            {{ ucfirst($trainingProgram->program_type) }}
                        </span>
                    </td>
                    <td class="py-3">
                        <small class="text-dark">{{ $trainingProgram->start_date->format('M j, Y') }}</small>
                    </td>
                    <td class="py-3">
                        @if($trainingProgram->end_date)
                            <small class="text-dark">{{ $trainingProgram->end_date->format('M j, Y') }}</small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($trainingProgram->start_time && $trainingProgram->end_time)
                            <small class="text-dark d-block">{{ \Carbon\Carbon::parse($trainingProgram->start_time)->format('g:i A') }}</small>
                            <small class="text-muted">to {{ \Carbon\Carbon::parse($trainingProgram->end_time)->format('g:i A') }}</small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($trainingProgram->price)
                            <span class="text-success font-weight-bold">
                                {{ $trainingProgram->price }}
                            </span>
                            @if($trainingProgram->early_bird_price)
                                <br><small class="badge badge-warning mt-1">Early: {{ $trainingProgram->early_bird_price }}</small>
                            @endif
                        @else
                            <span class="badge badge-success badge-pill px-2">Free</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @if($trainingProgram->speaker)
                            <small class="text-dark">{{ Str::limit($trainingProgram->speaker, 20) }}</small>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="py-3">
                        @php
                            $statusColors = [
                                'upcoming' => 'warning',
                                'ongoing' => 'success',
                                'completed' => 'info',
                                'cancelled' => 'danger'
                            ];
                        @endphp
                        <span class="badge badge-pill badge-{{ $statusColors[$trainingProgram->status] ?? 'secondary' }} px-3 py-1">
                            {{ ucfirst($trainingProgram->status) }}
                        </span>
                    </td>
                    <td class="py-3 text-center">
                        {!! Form::open(['route' => ['training-programs.destroy', $trainingProgram->id], 'method' => 'delete', 'class' => 'd-inline']) !!}
                        <div class='btn-group btn-group-sm' role="group">
                            <a href="{{ route('training-programs.show', [$trainingProgram->id]) }}"
                               class='btn btn-outline-info' title="View Details" data-toggle="tooltip">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('training-programs.edit', [$trainingProgram->id]) }}"
                               class='btn btn-outline-warning' title="Edit" data-toggle="tooltip">
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'submit', 
                                'class' => 'btn btn-outline-danger', 
                                'onclick' => "return confirm('Are you sure you want to delete this training program?')",
                                'title' => 'Delete',
                                'data-toggle' => 'tooltip'
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer bg-white border-top clearfix">
        <div class="float-right">
            @include('adminlte-templates::common.paginate', ['records' => $trainingPrograms])
        </div>
    </div>
</div>

@push('page_scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();
    
    // Search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('#training-programs-table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    // Filter by type
    $('#typeFilter').on('change', function() {
        var value = $(this).val().toLowerCase();
        if (value === '') {
            $('#training-programs-table tbody tr').show();
        } else {
            $('#training-programs-table tbody tr').each(function() {
                var type = $(this).find('td:eq(2)').text().toLowerCase();
                $(this).toggle(type.includes(value));
            });
        }
    });

    // Reset filters
    $('#resetFilters').on('click', function() {
        $('#searchInput').val('');
        $('#typeFilter').val('');
        $('#training-programs-table tbody tr').show();
    });
});
</script>
@endpush

<style>
/* Custom styling for improved readability */
#training-programs-table {
    font-size: 0.9rem;
}

#training-programs-table thead th {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
}

#training-programs-table tbody td {
    vertical-align: middle;
    padding: 0.75rem;
    line-height: 1.4;
}

#training-programs-table tbody tr {
    transition: all 0.2s ease;
}

#training-programs-table tbody tr:hover {
    background-color: #f8f9fa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.badge-pill {
    font-weight: 500;
    font-size: 0.8rem;
}

.btn-group-sm > .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.875rem;
}

.align-middle {
    vertical-align: middle !important;
}

.input-group-text {
    background-color: #f8f9fa;
}

.table-hover tbody tr:hover td {
    color: inherit;
}
</style>