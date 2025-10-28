<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id', null, ['class' => 'form-control']) !!}
</div>

<!-- Certificate Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('certificate_id', 'Certificate Id:') !!}
    {!! Form::text('certificate_id', null, ['class' => 'form-control', 'required', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Recipient Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recipient_name', 'Recipient Name:') !!}
    {!! Form::text('recipient_name', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Recipient Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('recipient_email', 'Recipient Email:') !!}
    {!! Form::text('recipient_email', null, ['class' => 'form-control', 'required', 'maxlength' => 255, 'maxlength' => 255, 'maxlength' => 255]) !!}
</div>

<!-- Course Name Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('course_name', 'Course Name:') !!}
    {!! Form::textarea('course_name', null, ['class' => 'form-control', 'required', 'maxlength' => 65535, 'maxlength' => 65535, 'maxlength' => 65535]) !!}
</div>

<!-- Course Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('course_description', 'Course Description:') !!}
    {!! Form::textarea('course_description', null, ['class' => 'form-control', 'maxlength' => 65535, 'maxlength' => 65535, 'maxlength' => 65535]) !!}
</div>

<!-- Issue Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('issue_date', 'Issue Date:') !!}
    {!! Form::text('issue_date', null, ['class' => 'form-control','id'=>'issue_date']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#issue_date').datepicker()
    </script>
@endpush

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control', 'maxlength' => 50, 'maxlength' => 50, 'maxlength' => 50]) !!}
</div>

<!-- Email Sent At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email_sent_at', 'Email Sent At:') !!}
    {!! Form::text('email_sent_at', null, ['class' => 'form-control','id'=>'email_sent_at']) !!}
</div>

@push('page_scripts')
    <script type="text/javascript">
        $('#email_sent_at').datepicker()
    </script>
@endpush