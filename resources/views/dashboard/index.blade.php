@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="clearfix">
                <h3 class="pull-left">@lang('page.welcome'),</h3>
                <select class="pull-right locale" style="margin-top: 10px">
                    @foreach(config('app.locales') as $id => $lang)
                        <option value="{{ $id }}" @if(Request::segment(1) == $id) {{ "selected=true" }} @endif>
                            {{ $lang }}
                        </option>
                    @endforeach
                </select>
            </div>
            <p>@lang('page.welcome_message')</p>

            <p><strong>Request Url Method (with locale prefix)</strong></p>
            Request::url() : {{ Request::url() }}<br>
            Request::segment(2) : {{ Request::segment(2) }}<br>
            url('/') : {{ url('/') }}<br><br>

            <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
        </div>
    </div>
    <script defer>
        window.onload = function () {
            $('.locale').on('change', function () {
                var lang = this.value;
                var pathname = window.location.pathname.replace(/^\//, "").split('/');
                pathname.splice(0, 1, lang);
                var url = pathname.join('/');
                var destUrl = window.location.protocol + "//" + window.location.host + '/' + url;
                window.location.href = destUrl;
            });
        }
    </script>
@endsection