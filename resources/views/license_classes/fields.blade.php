<!-- Id Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id', null, ['class' => 'form-control']) !!}
</div> -->

<!-- License Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('license_type', 'License Type:') !!}
    {!! Form::text('license_type', null, ['class' => 'form-control']) !!}
</div>

<!-- Class Field -->
<div class="form-group col-sm-6">
    {!! Form::label('class', 'Class:') !!}
    {!! Form::text('class', null, ['class' => 'form-control']) !!}
</div>

<!-- Scope Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('scope', 'Scope:') !!}
    {!! Form::textarea('scope', null, ['class' => 'form-control']) !!}
</div>

<!-- Min Qualification Field -->
<div class="form-group col-sm-6">
    {!! Form::label('min_qualification', 'Min Qualification:') !!}
    {!! Form::text('min_qualification', null, ['class' => 'form-control']) !!}
</div>

<!-- Technical Qualification Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('technical_qualification', 'Technical Qualification:') !!}
    {!! Form::textarea('technical_qualification', null, ['class' => 'form-control']) !!}
</div>

<!-- Experience Requirements Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('experience_requirements', 'Experience Requirements:') !!}
    {!! Form::textarea('experience_requirements', null, ['class' => 'form-control']) !!}
</div>

<!-- Starting License Field -->
<div class="form-group col-sm-6">
    {!! Form::label('starting_license', 'Starting License:') !!}
    {!! Form::text('starting_license', null, ['class' => 'form-control']) !!}
</div>

<!-- Highest Achievable Field -->
<div class="form-group col-sm-6">
    {!! Form::label('highest_achievable', 'Highest Achievable:') !!}
    {!! Form::text('highest_achievable', null, ['class' => 'form-control']) !!}
</div>