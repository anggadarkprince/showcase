@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <h1 class="page-title">Settings</h1>

                @include('errors.common')

                <form action="{{ route('account.settings.store', [$user->username]) }}" method="post" enctype="multipart/form-data">
                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    <div class="row field-group">
                        <div class="col-md-5">
                            <div class="form-title">
                                <h4>Profile</h4>
                                <p>Change user account information</p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ old('name', $user->name) }}" placeholder="Full Name">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                                <label for="username" class="control-label">Username</label>
                                <input type="text" class="form-control" name="username" id="username"
                                       value="{{ old('username', $user->username) }}" placeholder="Username">
                                {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('about') ? 'has-error' : '' }}">
                                <label for="about" class="control-label">About</label>
                                <textarea class="form-control" id="about" name="about" placeholder="About">{{ old('about', $user->about) }}</textarea>
                                {!! $errors->first('about', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('birthday') ? 'has-error' : '' }}">
                                <label for="birthday" class="control-label">Birthday</label>
                                <input type="date" class="form-control" name="birthday" id="birthday"
                                       value="{{ old('birthday', $user->birthday) }}" placeholder="Birthday">
                                {!! $errors->first('birthday', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
                                <label for="avatar" class="control-label">Avatar</label>
                                <div class="row">
                                    <div class="col-sm-2 col-md-3">
                                        <div class="avatar-preview">
                                            <img src="{{ asset("storage/avatars/{$user->avatar}") }}" class="img-responsive" alt="{{ $user->name }} Avatar">
                                        </div>
                                    </div>
                                    <div class="col-sm-10 col-md-9 m-t-sm">
                                        <p class="help-block">Recommend square image for best view.</p>
                                        <input type="file" name="avatar" id="avatar">
                                    </div>
                                </div>
                                {!! $errors->first('birthday', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                                <label for="male" class="control-label">Gender</label>
                                <div>
                                    <label class="radio-inline">
                                        <input type="radio" id="male" name="gender" value="male"
                                               @if(old('gender', 'male') == 'male') checked @endif> Male
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" id="female" name="gender" value="female"
                                               @if(old('gender') == 'female') checked @endif> Female
                                    </label>
                                </div>
                                {!! $errors->first('gender', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row field-group">
                        <div class="col-md-5">
                            <div class="form-title">
                                <h4>Contact</h4>
                                <p>Reach phone and address</p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email" class="control-label">Email address</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="{{ old('email', $user->email) }}" placeholder="Email Address">
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('contact') ? 'has-error' : '' }}">
                                <label for="contact" class="control-label">Contact</label>
                                <input type="text" class="form-control" name="contact" id="contact"
                                       value="{{ old('contact', $user->contact) }}" placeholder="Contact">
                                {!! $errors->first('contact', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('location') ? 'has-error' : '' }}">
                                <label for="location" class="control-label">Location</label>
                                <input type="text" class="form-control" name="location" id="location"
                                       value="{{ old('location', $user->location) }}" placeholder="Location">
                                {!! $errors->first('location', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row field-group">
                        <div class="col-md-5">
                            <div class="form-title">
                                <h4>Password</h4>
                                <p>Organize your security profile</p>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('password_new') ? 'has-error' : '' }}">
                                <label for="password_new" class="control-label">New Password</label>
                                <input type="password" class="form-control" name="password_new" id="password_new" placeholder="New Password">
                                {!! $errors->first('password_new', '<span class="help-block">:message</span>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('password_new_confirmation') ? 'has-error' : '' }}">
                                <label for="password_new_confirmation" class="control-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_new_confirmation" id="password_new_confirmation" placeholder="Confirm Password">
                                {!! $errors->first('password_new_confirmation', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-md-push-5">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection