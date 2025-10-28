<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $event->id }}</p>
</div>

<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $event->title }}</p>
</div>

<!-- Category Field -->
<div class="col-sm-12">
    {!! Form::label('category', 'Category:') !!}
    <p>{{ $event->category }}</p>
</div>

<!-- Date Field -->
<div class="col-sm-12">
    {!! Form::label('date', 'Date:') !!}
    <p>{{ $event->date }}</p>
</div>

<!-- Time Field -->
<div class="col-sm-12">
    {!! Form::label('time', 'Time:') !!}
    <p>{{ $event->time }}</p>
</div>

<!-- Location Field -->
<div class="col-sm-12">
    {!! Form::label('location', 'Location:') !!}
    <p>{{ $event->location }}</p>
</div>

<!-- Participants Field -->
<div class="col-sm-12">
    {!! Form::label('participants', 'Participants:') !!}
    <p>{{ $event->participants }}</p>
</div>

<!-- Max Participants Field -->
<div class="col-sm-12">
    {!! Form::label('max_participants', 'Max Participants:') !!}
    <p>{{ $event->max_participants }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-12">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $event->price }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $event->description }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    <p>{{ $event->status }}</p>
</div>

<!-- Featured Field -->
<div class="col-sm-12">
    {!! Form::label('featured', 'Featured:') !!}
    <p>{{ $event->featured }}</p>
</div>

<!-- Registration Url Field -->
<div class="col-sm-12">
    {!! Form::label('registration_url', 'Registration Url:') !!}
    <p>{{ $event->registration_url }}</p>
</div>

