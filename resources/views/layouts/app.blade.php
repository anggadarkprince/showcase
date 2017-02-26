<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ elixir('css/support.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Showcase = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            'rootUrl' => route('index')
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('index') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::check())

                            <li @if(isset($dashboard_active)) class='active' @endif>
                                <a href="{{ route('account.show', [Auth::user()->username]) }}">
                                    @lang('page.menu.dashboard')
                                </a>
                            </li>

                            @php
                                $url = parse_url(url('/'));

                                $domain = $url['scheme'].'://'.$url['host'];
                                if(isset($url['port'])){
                                    $domain .= ':'.$url['port'];
                                }
                            @endphp

                            @if(url('/') == $domain)
                                <li @if(isset($portfolio_active)) class='active' @endif>
                                    <a href="{{ route('account.portfolio', [Auth::user()->username]) }}">
                                        @lang('page.menu.my_portfolio')
                                    </a>
                                </li>
                            @endif

                        @endif
                        <li @if(isset($explore_active)) class='active' @endif>
                            <a href="{{ route('page.explore') }}">@lang('page.menu.explore')</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                @lang('page.menu.category') <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                @foreach($categoryMenu as $category)
                                    <li @if(isset($categoryActive) && $categoryActive->category == $category->category) class='active' @endif>
                                        <a href="{{ route('portfolio.search.category', [str_slug($category->category).'-'.$category->id]) }}">
                                            {{ $category->category }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <form action="{{ route('page.search') }}" method="get">
                                <div class="form-search-wrapper">
                                    <input type="search" name="q" value="{{ request('q') }}" placeholder="@lang('page.menu.search')">
                                    <i class="glyphicon glyphicon-search"></i>
                                    <button type="submit" style="display: none">@lang('page.menu.search')</button>
                                </div>
                            </form>
                            <a href="#" class="btn-icon-search"><i class="glyphicon glyphicon-search"></i>
                                <span class="hidden-lg hidden-md hidden-sm">&nbsp;@lang('page.menu.search')</span>
                            </a>
                        </li>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('account.login') }}">@lang('page.menu.login')</a></li>
                            <li><a href="{{ route('account.register') }}">@lang('page.menu.register')</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('account.show', [Auth::user()->username]) }}">@lang('page.menu.dashboard')</a>
                                        <a href="{{ route('account.portfolio', [Auth::user()->username]) }}">@lang('page.menu.portfolio')</a>
                                        <a href="{{ route('account.settings', [Auth::user()->username]) }}">@lang('page.menu.setting')</a>
                                        <a href="{{ route('account.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            @lang('page.menu.logout')
                                        </a>

                                        <form id="logout-form" action="{{ route('account.logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="navbar navbar-default">
            &copy; {{ date('Y') }} Showcase.dev all rights reserved
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ elixir('js/app.js') }}"></script>
    <script src="{{ elixir('js/functions.js') }}"></script>
</body>
</html>
