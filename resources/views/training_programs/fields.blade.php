<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'required' => true]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) !!}
</div>

<!-- Program Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('program_type', 'Program Type:') !!}
    {!! Form::select('program_type', [
        'workshop' => 'Workshop',
        'webinar' => 'Webinar',
        'seminar' => 'Seminar',
        'training' => 'Training',
        'conference' => 'Conference'
    ], null, ['class' => 'form-control', 'placeholder' => 'Select Program Type']) !!}
</div>

<!-- Start Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_date', 'Start Date:') !!}
    <div class="input-group date" id="start_date_picker" data-target-input="nearest">
        {!! Form::text('start_date', null, ['class' => 'form-control datetimepicker-input', 'data-target' => '#start_date_picker', 'autocomplete' => 'off']) !!}
        <div class="input-group-append" data-target="#start_date_picker" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
        </div>
    </div>
</div>

<!-- End Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_date', 'End Date:') !!}
    <div class="input-group date" id="end_date_picker" data-target-input="nearest">
        {!! Form::text('end_date', null, ['class' => 'form-control datetimepicker-input', 'data-target' => '#end_date_picker', 'autocomplete' => 'off']) !!}
        <div class="input-group-append" data-target="#end_date_picker" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
        </div>
    </div>
</div>

<!-- Start Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('start_time', 'Start Time:') !!}
    <div class="input-group">
        {!! Form::text('start_time', null, ['class' => 'form-control timepicker', 'id' => 'start_time', 'autocomplete' => 'off']) !!}
        <div class="input-group-append">
            <div class="input-group-text"><i class="far fa-clock"></i></div>
        </div>
    </div>
</div>

<!-- End Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('end_time', 'End Time:') !!}
    <div class="input-group">
        {!! Form::text('end_time', null, ['class' => 'form-control timepicker', 'id' => 'end_time', 'autocomplete' => 'off']) !!}
        <div class="input-group-append">
            <div class="input-group-text"><i class="far fa-clock"></i></div>
        </div>
    </div>
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::number('price', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
</div>

<!-- Early Bird Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('early_bird_price', 'Early Bird Price:') !!}
    {!! Form::number('early_bird_price', null, ['class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
</div>

<!-- Features Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('features', 'Features:') !!}
    {!! Form::textarea('features', null, ['class' => 'form-control', 'rows' => 4]) !!}
</div>

<!-- Registration Link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('registration_link', 'Registration Link:') !!}
    {!! Form::url('registration_link', null, ['class' => 'form-control', 'placeholder' => 'https://']) !!}
</div>

<!-- Speaker Field -->
<div class="form-group col-sm-6">
    {!! Form::label('speaker', 'Speaker:') !!}
    {!! Form::text('speaker', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status', [
        'upcoming' => 'Upcoming',
        'ongoing' => 'Ongoing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled'
    ], null, ['class' => 'form-control', 'placeholder' => 'Select Status']) !!}
</div>

<!-- Recording Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recording_url', 'Recording URL:') !!}
    {!! Form::url('recording_url', null, ['class' => 'form-control', 'placeholder' => 'https://']) !!}
</div>

<!-- Slides Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slides_url', 'Slides URL:') !!}
    {!! Form::url('slides_url', null, ['class' => 'form-control', 'placeholder' => 'https://']) !!}
</div>

<!-- Trainer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trainer_id', 'Trainer:') !!}
    {!! Form::select('trainer_id', $trainers ?? [], null, ['class' => 'form-control', 'placeholder' => 'Select Trainer']) !!}
</div>

@push('styles')
<style>
    .datepicker {
        z-index: 1050 !important;
    }
    
    .bootstrap-timepicker-widget {
        z-index: 1051 !important;
    }
    
    .datepicker table tr td.active,
    .datepicker table tr td.active:hover,
    .datepicker table tr td.active.disabled,
    .datepicker table tr td.active.disabled:hover {
        background-color: #B8860B !important;
        background-image: none !important;
        border-color: #996515 !important;
    }
    
    .datepicker table tr td.today,
    .datepicker table tr td.today:hover,
    .datepicker table tr td.today.disabled,
    .datepicker table tr td.today.disabled:hover {
        background-color: #F5F0E8 !important;
        border-color: #B8860B !important;
    }
    
    .input-group-text {
        cursor: pointer;
        background-color: #F5F0E8;
    }
</style>
@endpush

@push('page_scripts')
<script type="text/javascript">
$(document).ready(function() {
    console.log('jQuery version:', $.fn.jquery);
    console.log('Datepicker available:', typeof $.fn.datepicker);
    console.log('Timepicker available:', typeof $.fn.timepicker);
    
    // Initialize Start Date Picker
    $('#start_date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom auto',
        todayBtn: 'linked'
    }).on('changeDate', function(e) {
        console.log('Start date changed:', e.date);
        // Set minimum date for end date picker
        $('#end_date_picker').datepicker('setStartDate', e.date);
    });
    
    // Initialize End Date Picker
    $('#end_date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom auto',
        todayBtn: 'linked'
    });
    
    // Initialize Time Pickers
    $('.timepicker').timepicker({
        showInputs: false,
        showMeridian: false,
        minuteStep: 15,
        defaultTime: false
    });
    
    // Make icon clickable for datepicker
    $('[data-toggle="datetimepicker"]').on('click', function() {
        var target = $(this).data('target');
        $(target).datepicker('show');
    });
    
    console.log('Date and time pickers initialized successfully!');
});
</script>
@endpush