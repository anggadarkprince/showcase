@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @php
                $title = [
                    trans('page.welcome').', ',
                    $admin
                ];
            @endphp

            @include('partials._admin_title', ['title' => collect($title), 'isBreadcrumb' => false])

            <p class="m-b-md">@lang('page.welcome_message')</p>

            @include('errors.common')

            <div class="row">
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">{{ strtoupper(trans('page.dashboard.contributors')) }}</p>
                            <h3 class="stats">{{ $users }}
                                <small>
                                    @if(App::isLocale('en'))
                                        {{ str_plural(trans('page.dashboard.user'), $users) }}
                                    @else
                                        {{ trans('page.dashboard.user') }}
                                    @endif
                                </small>
                            </h3>
                            <a href="{{ route('admin.user') }}" class="text-primary">
                                {{ number_format($users_activated/$users * 100, 1) }}%
                                @lang('page.dashboard.active')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">{{ strtoupper(trans('page.dashboard.showcases')) }}</p>
                            <?php
                            if($showcases >= 10000){
                                $showcases = number_format($showcases/1000, 1).'K';
                            }
                            else{
                                $showcases = number_format($showcases);
                            }
                            ?>
                            <h3 class="stats">{{ $showcases }}
                                <small>
                                    @if(App::isLocale('en'))
                                        {{ str_plural(trans('page.dashboard.project'), $showcases) }}
                                    @else
                                        {{ trans('page.dashboard.project') }}
                                    @endif
                                </small>
                            </h3>
                            <a href="{{ route('admin.portfolio') }}" class="text-primary">
                                {{ number_format($showcases_view) }}
                                @if(App::isLocale('en'))
                                    {{ str_plural(trans('page.dashboard.view'), $showcases_view) }}
                                @else
                                    x {{ trans('page.dashboard.view') }}
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">{{ strtoupper(trans('page.dashboard.screenshots')) }}</p>
                            <?php
                            if($screenshots >= 10000){
                                $screenshots = number_format($screenshots/1000, 1).'K';
                            }
                            else{
                                $screenshots = number_format($screenshots);
                            }
                            ?>
                            <h3 class="stats">{{ $screenshots }}
                                <small>
                                    @if(App::isLocale('en'))
                                        {{ str_plural(trans('page.dashboard.image'), $screenshots_size) }}
                                    @else
                                        {{ trans('page.dashboard.image') }}
                                    @endif
                                </small>
                            </h3>
                            <p class="text-primary">{{ $screenshots_size }} MB
                                @lang('page.dashboard.storage')
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">{{ strtoupper(trans('page.dashboard.companies')) }}</p>
                            <?php
                            if($companies >= 10000){
                                $companies = number_format($companies/1000, 1).'K';
                            }
                            else{
                                $companies = number_format($companies);
                            }
                            ?>
                            <h3 class="stats">{{ $companies }}
                                <small>
                                    {{ trans('page.dashboard.unique') }}
                                </small>
                            </h3>
                            <p class="text-primary">@lang('page.dashboard.all')</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">{{ strtoupper(trans('page.dashboard.categories')) }}</p>
                            <h3 class="stats">{{ number_format($categories) }}
                                <small>
                                    @if(App::isLocale('en'))
                                        {{ str_plural(trans('page.dashboard.item'), $categories) }}
                                    @else
                                        {{ trans('page.dashboard.item') }}
                                    @endif
                                </small>
                            </h3>
                            <a href="{{ route('admin.category') }}" class="text-primary">
                                @lang('page.dashboard.group')
                            </a>
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
                            <h3 class="stats">{{ $tags }}
                                <small>
                                    @if(App::isLocale('en'))
                                        {{ str_plural(trans('page.dashboard.key'), $tags) }}
                                    @else
                                        {{ trans('page.dashboard.key') }}
                                    @endif
                                </small>
                            </h3>
                            <a href="{{ route('admin.tag') }}" class="text-primary">
                                @lang('page.dashboard.popular', ['tag' => 'Design'])
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">{{ strtoupper(trans('page.dashboard.cleaner')) }}</p>
                            <?php
                            if($portfolios_deleted >= 10000){
                                $portfolios_deleted = number_format($portfolios_deleted/1000, 1).'K';
                            }
                            else{
                                $portfolios_deleted = number_format($portfolios_deleted);
                            }
                            ?>
                            <h3 class="stats">{{ $portfolios_deleted }}
                                <small>
                                    @if(App::isLocale('en'))
                                        @if($portfolios_deleted == 0) <?php $portfolios_deleted = 1 ?> @endif
                                        {{ str_plural(trans('page.dashboard.item'), $portfolios_deleted) }}
                                    @else
                                        {{ trans('page.dashboard.item') }}
                                    @endif
                                </small>
                            </h3>
                            <a href="#" class="text-primary" onclick="return clearTrash(event)">
                                @lang('page.dashboard.clear')
                            </a>
                            <form action="{{ url('trash/empty') }}" method="post" id="empty-form">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="panel panel-default stats-card">
                        <div class="panel-body">
                            <p class="lead">{{ strtoupper(trans('page.dashboard.error')) }}</p>
                            <?php
                            if($log_lines >= 10000){
                                $log_lines = '+'.number_format($log_lines/1000, 1).'K';
                            }
                            else{
                                $log_lines = number_format($log_lines);
                            }
                            ?>
                            <h3 class="stats">{{ $log_lines }}
                                <small>
                                    @if(App::isLocale('en'))
                                        {{ str_plural(trans('page.dashboard.line'), $log_lines) }}
                                    @else
                                        {{ trans('page.dashboard.line') }}
                                    @endif
                                </small>
                            </h3>
                            <a href="{{ url('download/laravel.log') }}" class="text-primary">
                                @lang('page.dashboard.download')
                            </a>
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
    </script>
@endsection