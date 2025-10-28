<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $certificate->id }}</p>
</div>

<!-- Certificate Id Field -->
<div class="col-sm-12">
    {!! Form::label('certificate_id', 'Certificate Id:') !!}
    <p>{{ $certificate->certificate_id }}</p>
</div>

<!-- Recipient Name Field -->
<div class="col-sm-12">
    {!! Form::label('recipient_name', 'Recipient Name:') !!}
    <p>{{ $certificate->recipient_name }}</p>
</div>

<!-- Recipient Email Field -->
<div class="col-sm-12">
    {!! Form::label('recipient_email', 'Recipient Email:') !!}
    <p>{{ $certificate->recipient_email }}</p>
</div>

<!-- Course Name Field -->
<div class="col-sm-12">
    {!! Form::label('course_name', 'Course Name:') !!}
    <p>{{ $certificate->course_name }}</p>
</div>

<!-- Course Description Field -->
<div class="col-sm-12">
    {!! Form::label('course_description', 'Course Description:') !!}
    <p>{{ $certificate->course_description }}</p>
</div>

<!-- Issue Date Field -->
<div class="col-sm-12">
    {!! Form::label('issue_date', 'Issue Date:') !!}
    <p>{{ $certificate->issue_date }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $certificate->status }}</p>
</div>

<!-- Email Sent At Field -->
<div class="col-sm-12">
    {!! Form::label('email_sent_at', 'Email Sent At:') !!}
    <p>{{ $certificate->email_sent_at }}</p>
</div>

