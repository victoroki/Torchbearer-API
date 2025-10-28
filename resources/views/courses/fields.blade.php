<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required', 'maxlength' => 255]) !!}
</div>

<!-- Trainer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('trainer', 'Trainer:') !!}
    {!! Form::text('trainer', null, ['class' => 'form-control', 'maxlength' => 15]) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required', 'rows' => 5]) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    <div class="custom-control custom-switch">
        {!! Form::hidden('status', 0) !!}
        {!! Form::checkbox('status', 1, null, ['class' => 'custom-control-input', 'id' => 'statusCheckbox']) !!}
        <label class="custom-control-label" for="statusCheckbox">Active</label>
    </div>
</div>