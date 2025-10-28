<!-- Id Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    {!! Form::number('id', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url', 'Url:') !!}
    {!! Form::text('url', null, ['class' => 'form-control']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category', 'Category:') !!}
    {!! Form::text('category', null, ['class' => 'form-control']) !!}
</div>

<!-- Featured Field -->
<div class="form-group col-sm-6">
    <div class="form-check">
        {!! Form::hidden('featured', 0, ['class' => 'form-check-input']) !!}
        {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input']) !!}
        {!! Form::label('featured', 'Featured', ['class' => 'form-check-label']) !!}
    </div>
</div>

<!-- Rating Field -->
<div class="form-group col-sm-6">
    {!! Form::label('rating', 'Rating:') !!}
    {!! Form::number('rating', null, ['class' => 'form-control']) !!}
</div>

<!-- Visits Field -->
<div class="form-group col-sm-6">
    {!! Form::label('visits', 'Visits:') !!}
    {!! Form::number('visits', null, ['class' => 'form-control']) !!}
</div>