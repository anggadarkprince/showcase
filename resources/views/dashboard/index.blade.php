@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="clearfix">
                <h1 class="page-title pull-left">
                    <button type="button" class="navbar-toggle" id="menu-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    @lang('page.welcome'), <small class="hidden-xs text-primary">{{ Auth::user()->name }}</small></h1>
                <select class="pull-right locale" style="margin-top: 10px">
                    @foreach(config('app.locales') as $id => $lang)
                        <option value="{{ $id }}" @if(Request::segment(1) == $id) {{ "selected=true" }} @endif>
                            {{ $lang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <p class="m-b-md">@lang('page.welcome_message')</p>

            @include('errors.common')

            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">CONTRIBUTORS</p>
                            <h3 class="stats">{{ $users }} <small>{{ str_plural('USER', $users) }}</small></h3>
                            <a href="{{ route('admin.user') }}" class="text-primary">
                                {{ number_format($users_activated/$users * 100, 1) }}% Active Account
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">SHOWCASES</p>
                            <?php
                            if($showcases >= 10000){
                                $showcases = number_format($showcases/1000, 1).'K';
                            }
                            else{
                                $showcases = number_format($showcases);
                            }
                            ?>
                            <h3 class="stats">{{ $showcases }} <small>{{ str_plural('PROJECT', $showcases) }}</small></h3>
                            <a href="{{ route('admin.portfolio') }}" class="text-primary">{{ number_format($showcases_view) }} Views</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">SCREENSHOTS</p>
                            <?php
                            if($screenshots >= 10000){
                                $screenshots = number_format($screenshots/1000, 1).'K';
                            }
                            else{
                                $screenshots = number_format($screenshots);
                            }
                            ?>
                            <h3 class="stats">{{ $screenshots }} <small>{{ str_plural('IMAGE', $screenshots_size) }}</small></h3>
                            <p class="text-primary">{{ $screenshots_size }} MB Storage</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">COMPANIES</p>
                            <?php
                            if($companies >= 10000){
                                $companies = number_format($companies/1000, 1).'K';
                            }
                            else{
                                $companies = number_format($companies);
                            }
                            ?>
                            <h3 class="stats">{{ $companies }} <small>UNIQUE</small></h3>
                            <p class="text-primary">Of all portfolios</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">CATEGORIES</p>
                            <h3 class="stats">{{ number_format($categories) }} <small>{{ str_plural('ITEM', $categories) }}</small></h3>
                            <a href="{{ route('admin.category') }}" class="text-primary">Group of fields</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">TAGS</p>
                            <?php
                            if($tags >= 10000){
                                $tags = number_format($tags/1000, 1).'K';
                            }
                            else{
                                $tags = number_format($tags);
                            }
                            ?>
                            <h3 class="stats">{{ $tags }} <small>{{ str_plural('KEY', $tags) }}</small></h3>
                            <a href="{{ route('admin.tag') }}" class="text-primary">Design is the most popular</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">CLEANER</p>
                            <?php
                            if($portfolios_deleted >= 10000){
                                $portfolios_deleted = number_format($portfolios_deleted/1000, 1).'K';
                            }
                            else{
                                $portfolios_deleted = number_format($portfolios_deleted);
                            }
                            ?>
                            <h3 class="stats">{{ $portfolios_deleted }} <small>{{ str_plural('ITEM', $portfolios_deleted) }}</small></h3>
                            <a href="#" class="text-primary" onclick="return clearTrash(event)">Clear trash</a>
                            <form action="{{ url('trash/empty') }}" method="post" id="empty-form">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">ERROR</p>
                            <?php
                            if($log_lines >= 10000){
                                $log_lines = '+'.number_format($log_lines/1000, 1).'K';
                            }
                            else{
                                $log_lines = number_format($log_lines);
                            }
                            ?>
                            <h3 class="stats">{{ $log_lines }} <small>{{ str_plural('LINE', $log_lines) }}</small></h3>
                            <a href="{{ url('download/laravel.log') }}" class="text-primary">Download log file</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden">
                <p><strong>Request Url Method (with locale prefix)</strong></p>
                Request::url() : {{ Request::url() }}<br>
                Request::segment(2) : {{ Request::segment(2) }}<br>
                url('/') : {{ url('/') }}<br><br>
            </div>

        </div>
    </div>
    <script defer>
        function clearTrash(event){
            event.preventDefault();
            var answer = confirm('Are you sure want to empty trash?');
            if(answer){
                var form = document.getElementById('empty-form');
                form.submit();
            }
        }

        window.onload = function () {
            $('.locale').on('change', function () {
                var locales = <?php echo json_encode(config('app.locales')) ?>;
                var lang = this.value;
                var pathname = window.location.pathname.replace(/^\//, "").split('/');
                if(pathname.length > 0){
                    if(locales[pathname[0]] != undefined){
                        pathname.splice(0, 1, lang);
                    }
                    else{
                        pathname.unshift(lang);
                    }
                }
                var url = pathname.join('/');
                var destUrl = window.location.protocol + "//" + window.location.host + '/' + url;
                window.location.href = destUrl;
            });
        }
    </script>
@endsection