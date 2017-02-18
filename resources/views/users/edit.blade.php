@extends('layouts.admin')

@section('title', 'Edit user')

@section('content')
    <div class="section-title">
        <h3>Edit user {{ $user->name }}</h3>
        <p>Member user that capable to create portfolio</p>
    </div>

    @include('errors.common')

    <form action="{{ route('admin.user.update', [$user->username]) }}" class="form-horizontal" role="form" method="post">
        {{ method_field('put') }}
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="name"
                       id="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
            <label for="username" class="col-sm-3 control-label">Username</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="username"
                       id="username" placeholder="Username" value="{{ old('username', $user->username) }}">
                {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-8">
                <input type="email" class="form-control" name="email"
                       id="email" placeholder="Email" value="{{ old('email', $user->email) }}">
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
            <label for="male" class="col-sm-3 control-label">Gender</label>
            <div class="col-sm-8">
                <label class="radio-inline">
                    <input type="radio" id="male" name="gender" value="male"
                           @if(old('gender', $user->gender) == 'male') checked @endif> Male
                </label>
                <label class="radio-inline">
                    <input type="radio" id="female" name="gender" value="female"
                           @if(old('gender', $user->gender) == 'female') checked @endif> Female
                </label>
            </div>
            {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('about') ? 'has-error' : '' }}">
            <label for="about" class="col-sm-3 control-label">About</label>
            <div class="col-sm-8">
                <textarea class="form-control" name="about"
                          id="about" placeholder="About">{{ old('about', $user->about) }}</textarea>
                {!! $errors->first('about', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('birthday') ? 'has-error' : '' }}">
            <label for="birthday" class="col-sm-3 control-label">Birthday</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" name="birthday"
                       id="birthday" placeholder="Birthday" value="{{ old('birthday', $user->birthday) }}">
                {!! $errors->first('birthday', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
            <label for="location" class="col-sm-3 control-label">Location</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="location"
                       id="location" placeholder="Location" value="{{ old('location', $user->location) }}">
                {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
            <label for="contact" class="col-sm-3 control-label">Contact</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="contact"
                       id="contact" placeholder="Contact" value="{{ old('contact', $user->contact) }}">
                {!! $errors->first('contact', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" name="password"
                       id="password" placeholder="Password" value="{{ old('password') }}">
                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
            <label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" name="password_confirmation"
                       id="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirm') }}">
                {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
            <label for="activated" class="col-sm-3 control-label">Status</label>
            <div class="col-sm-8">
                <label class="radio-inline">
                    <input type="radio" id="pending" name="status" value="pending"
                           @if(old('status') == 'pending') checked @endif> Pending
                </label>
                <label class="radio-inline">
                    <input type="radio" id="activated" name="status" value="activated"
                           @if(old('status', 'activated') == 'activated') checked @endif> Activated
                </label>
                <label class="radio-inline">
                    <input type="radio" id="suspended" name="status" value="suspended"
                           @if(old('status') == 'suspended') checked @endif> Suspended
                </label>
                {!! $errors->first('status', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-10">
                <button type="submit" class="btn btn-primary">Update User</button>
                <button type="reset" class="btn btn-default">Reset</button>
            </div>
        </div>
    </form>
@endsection