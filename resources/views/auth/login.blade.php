@extends('layouts.app')

@section('title', '- Sign In')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('page.menu.login')</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form role="form" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}

                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <p>
                                            {{ $message }}
                                        </p>
                                    </div>
                                @endif
                                @if ($message = Session::get('warning'))
                                    <div class="alert alert-warning">
                                        <p>
                                            {{ $message }}
                                        </p>
                                    </div>
                                @endif

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">
                                        @lang('page.field.email')
                                    </label>

                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" placeholder="@lang('page.field.email')" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">
                                        @lang('page.field.password')
                                    </label>

                                    <input id="password" type="password" class="form-control" name="password"
                                           placeholder="@lang('page.field.password')" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember">
                                            @lang('page.field.remember')
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        @lang('page.menu.login')
                                    </button>
                                </div>
                                <div class="center-block text-center">
                                    <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <p class="lead">Login with socials</p>
                            <a href="{{ route('github.provider') }}" class="btn btn-block btn-github m-b-sm">Sign in with Github</a>
                            <a href="{{ route('facebook.provider') }}" class="btn btn-block btn-facebook m-b-sm">Sign in with Facebook</a>
                            <a href="{{ route('twitter.provider') }}" class="btn btn-block btn-twitter m-b-sm">Sign in with Twitter</a>
                            <a href="{{ route('google.provider') }}" class="btn btn-block btn-google">Sign in with Google</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
