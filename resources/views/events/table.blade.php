<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover" id="events-table">
            <thead class="thead-light">
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th class="text-center">Participants</th>
                <th class="text-center">Max</th>
                <th>Price</th>
                <th class="text-center">Status</th>
                <th class="text-center">Featured</th>
                <th class="text-center">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td class="font-weight-medium">
                        <span title="{{ $event->title }}">
                            {{ Str::limit($event->title, 30) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $event->category }}</span>
                    </td>
                    <td>
                        @if($event->date)
                            {{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($event->time)
                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span title="{{ $event->location }}">
                            {{ Str::limit($event->location, 25) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-light">{{ $event->participants }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-secondary">{{ $event->max_participants }}</span>
                    </td>
                    <td>
                        @if($event->price)
                            <span class="text-success font-weight-bold">{{ $event->price }}</span>
                        @else
                            <span class="badge badge-success">Free</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($event->status == 'upcoming')
                            <span class="badge badge-warning">Upcoming</span>
                        @elseif($event->status == 'ongoing')
                            <span class="badge badge-success">Ongoing</span>
                        @elseif($event->status == 'completed')
                            <span class="badge badge-info">Completed</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($event->status) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($event->featured)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-light">No</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {!! Form::open(['route' => ['events.destroy', $event->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('events.show', [$event->id]) }}"
                               class='btn btn-default btn-xs' title="View">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('events.edit', [$event->id]) }}"
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
            @include('adminlte-templates::common.paginate', ['records' => $events])
        </div>
    </div>
</div>
