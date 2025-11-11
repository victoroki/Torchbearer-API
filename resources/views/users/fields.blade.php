@if(isset($user))
    <!-- ID (read-only on edit) -->
    <div class="form-group col-md-6 mb-3">
        {!! Form::label('id', 'ID') !!}
        {!! Form::number('id', $user->id, ['class' => 'form-control', 'readonly' => true]) !!}
    </div>
@endif

<!-- Username -->
<div class="form-group col-md-6 mb-3">
    {!! Form::label('username', 'Username') !!}
    {!! Form::text('username', null, [
        'class' => 'form-control',
        'placeholder' => 'Enter username',
        'autocomplete' => 'username',
        'required' => true
    ]) !!}
    @if($errors->has('username'))
        <small class="text-danger">{{ $errors->first('username') }}</small>
    @endif
    
    @if(!isset($user))
        <small class="form-text text-muted">Unique name for the user account.</small>
    @endif
</div>

<!-- Email -->
<div class="form-group col-md-6 mb-3">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, [
        'class' => 'form-control',
        'placeholder' => 'name@example.com',
        'autocomplete' => 'email',
        'required' => true
    ]) !!}
    @if($errors->has('email'))
        <small class="text-danger">{{ $errors->first('email') }}</small>
    @endif
</div>

<!-- Password -->
<div class="form-group col-md-6 mb-3">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', [
        'class' => 'form-control',
        'placeholder' => 'Enter a secure password',
        'autocomplete' => 'new-password',
        'required' => !isset($user)
    ]) !!}
    @if($errors->has('password'))
        <small class="text-danger">{{ $errors->first('password') }}</small>
    @endif
</div>

<!-- Role -->
<div class="form-group col-md-6 mb-3">
    {!! Form::label('role', 'Role') !!}
    {!! Form::text('role', null, [
        'class' => 'form-control',
        'placeholder' => 'e.g., admin, user'
    ]) !!}
    @if($errors->has('role'))
        <small class="text-danger">{{ $errors->first('role') }}</small>
    @endif
</div>

<!-- Active Status -->
<div class="form-group col-md-6 mb-3">
    <div class="form-check mt-2">
        {!! Form::hidden('is_active', 0) !!}
        {!! Form::checkbox('is_active', 1, isset($user) ? (bool)$user->is_active : true, ['class' => 'form-check-input', 'id' => 'is_active']) !!}
        {!! Form::label('is_active', 'Active', ['class' => 'form-check-label']) !!}
    </div>
    @if($errors->has('is_active'))
        <small class="text-danger">{{ $errors->first('is_active') }}</small>
    @endif
</div>