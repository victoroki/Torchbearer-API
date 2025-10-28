<!-- Title Field -->
<div class="form-group col-sm-12">
    {!! Form::label('title', 'Event Title:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter event title', 'required' => true]) !!}
    <small class="form-text text-muted">Enter a descriptive title for the event</small>
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category', 'Category:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::select('category', [
        '' => 'Select Category',
        'workshop' => 'Workshop',
        'seminar' => 'Seminar',
        'conference' => 'Conference',
        'training' => 'Training',
        'webinar' => 'Webinar',
        'meetup' => 'Meetup',
        'networking' => 'Networking Event',
        'other' => 'Other'
    ], null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::select('status', [
        '' => 'Select Status',
        'upcoming' => 'Upcoming',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'postponed' => 'Postponed'
    ], null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Event Date:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::date('date', null, ['class' => 'form-control', 'id' => 'date', 'required' => true]) !!}
    <small class="form-text text-muted">Select the date when the event will take place</small>
</div>

<!-- Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time', 'Event Time:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::time('time', null, ['class' => 'form-control', 'required' => true]) !!}
    <small class="form-text text-muted">Select the start time of the event</small>
</div>

<!-- Location Field -->
<div class="form-group col-sm-12">
    {!! Form::label('location', 'Location:', ['class' => 'font-weight-bold']) !!}
    <span class="text-danger">*</span>
    {!! Form::text('location', null, [
        'class' => 'form-control', 
        'placeholder' => 'e.g., Conference Hall A, City Convention Center',
        'required' => true
    ]) !!}
    <small class="form-text text-muted">Enter the physical or virtual location of the event</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:', ['class' => 'font-weight-bold']) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'rows' => 4,
        'placeholder' => 'Provide detailed information about the event...'
    ]) !!}
    <small class="form-text text-muted">Describe what the event is about, agenda, speakers, etc.</small>
</div>

<!-- Participants Field -->
<div class="form-group col-sm-4">
    {!! Form::label('participants', 'Current Participants:', ['class' => 'font-weight-bold']) !!}
    {!! Form::number('participants', isset($event) ? $event->participants : 0, [
        'class' => 'form-control',
        'min' => '0',
        'readonly' => true,
        'placeholder' => '0'
    ]) !!}
    <small class="form-text text-muted">Number of registered participants (auto-tracked)</small>
</div>

<!-- Max Participants Field -->
<div class="form-group col-sm-4">
    {!! Form::label('max_participants', 'Maximum Capacity:', ['class' => 'font-weight-bold']) !!}
    {!! Form::number('max_participants', null, [
        'class' => 'form-control',
        'min' => '1',
        'placeholder' => 'e.g., 100'
    ]) !!}
    <small class="form-text text-muted">Maximum number of participants allowed</small>
</div>

<!-- Price Field -->
<div class="form-group col-sm-4">
    {!! Form::label('price', 'Price (KES):', ['class' => 'font-weight-bold']) !!}
    {!! Form::number('price', null, [
        'class' => 'form-control',
        'min' => '0',
        'step' => '0.01',
        'placeholder' => '0.00'
    ]) !!}
    <small class="form-text text-muted">Event registration fee (0 for free events)</small>
</div>

<!-- Registration URL Field -->
<div class="form-group col-sm-12">
    {!! Form::label('registration_url', 'Registration URL:', ['class' => 'font-weight-bold']) !!}
    {!! Form::url('registration_url', null, [
        'class' => 'form-control',
        'placeholder' => 'https://example.com/register'
    ]) !!}
    <small class="form-text text-muted">External registration link (if applicable)</small>
</div>

<!-- Featured Field -->
<div class="form-group col-sm-12">
    <div class="custom-control custom-switch mt-2">
        {!! Form::hidden('featured', 0) !!}
        {!! Form::checkbox('featured', '1', null, ['class' => 'custom-control-input', 'id' => 'featuredSwitch']) !!}
        <label class="custom-control-label font-weight-bold" for="featuredSwitch">
            <i class="fas fa-star text-warning"></i> Featured Event
        </label>
    </div>
    <small class="form-text text-muted">Mark as featured to highlight on homepage</small>
</div>

@push('page_css')
<style>
    .form-group label.font-weight-bold {
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    
    .custom-switch .custom-control-label::before {
        height: 1.5rem;
        width: 2.75rem;
    }
    
    .custom-switch .custom-control-label::after {
        height: calc(1.5rem - 4px);
        width: calc(1.5rem - 4px);
    }

    .text-danger {
        font-weight: bold;
    }

    .form-text {
        font-size: 0.875rem;
    }
</style>
@endpush

@push('page_scripts')
<script>
$(document).ready(function() {
    // Set minimum date to today
    var today = new Date().toISOString().split('T')[0];
    $('#date').attr('min', today);
    
    // Validate max participants against current participants
    $('input[name="max_participants"]').on('change', function() {
        var currentParticipants = parseInt($('input[name="participants"]').val()) || 0;
        var maxParticipants = parseInt($(this).val()) || 0;
        
        if (maxParticipants > 0 && maxParticipants < currentParticipants) {
            alert('Maximum capacity cannot be less than current participants (' + currentParticipants + ')');
            $(this).val(currentParticipants);
        }
    });
    
    // Format price field
    $('input[name="price"]').on('blur', function() {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2));
        }
    });
    
    // Form validation
    $('form').on('submit', function(e) {
        var date = new Date($('#date').val());
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (date < today) {
            e.preventDefault();
            alert('Event date cannot be in the past.');
            $('#date').focus();
            return false;
        }
        
        // Show loading indicator
        $(this).find('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        return true;
    });
});
</script>
@endpush