<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Manage showcase.dev data">
    <meta name="author" content="Angga Ari Wijaya">
    <meta name="keywords" content="showcase, portfolio, blog, profile, web, angga, ari, wijaya">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Showcase - @yield('title')</title>

    <link href="{{ elixir('css/support.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/admin.css') }}" rel="stylesheet">

    <script>
        window.Showcase = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body id="app">
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="{{ route('index') }}">
                    Showcase.dev
                </a>
            </li>
            <?php
                $segment = 1;
                $locale = Request::segment(1, '');
                if(array_key_exists($locale, config('app.locales'))){
                    $segment = 2;
                }
            ?>
            <li {{ Request::segment($segment) == 'dashboard' ? 'class=active' : '' }}>
                <a href="{{ route('admin.dashboard') }}">
                    <i class="glyphicon glyphicon-dashboard"></i>@lang('page.menu.dashboard')
                </a>
            </li>
            @can('view', \App\User::class)
            <li {{ Request::segment($segment) == 'users' ? 'class=active' : '' }}>
                <a href="{{ route('admin.user') }}">
                    <i class="glyphicon glyphicon-user"></i>@lang('page.menu.user')
                </a>
            </li>
            @endcan
            <li {{ Request::segment($segment) == 'portfolios' ? 'class=active' : '' }}>
                <a href="{{ route('admin.portfolio') }}">
                    <i class="glyphicon glyphicon-folder-open"></i>@lang('page.menu.portfolio')
                </a>
            </li>
            <li {{ Request::segment($segment) == 'tags' ? 'class=active' : '' }}>
                <a href="{{ route('admin.tag') }}">
                    <i class="glyphicon glyphicon-tags"></i>@lang('page.menu.tag')
                </a>
            </li>
            <li {{ Request::segment($segment) == 'categories' ? 'class=active' : '' }}>
                <a href="{{ route('admin.category') }}">
                    <i class="glyphicon glyphicon-list"></i>@lang('page.menu.category')
                </a>
            </li>
            <li {{ Request::segment($segment) == 'report' ? 'class=active' : '' }}>
                <a href="{{ route('admin.report') }}">
                    <i class="glyphicon glyphicon-stats"></i>@lang('page.menu.report')
                </a>
            </li>
            <li {{ Request::segment($segment) == 'contact' ? 'class=active' : '' }}>
                <a href="{{ url('/'.App::getLocale().'/contact') }}">
                    <i class="glyphicon glyphicon-envelope"></i>@lang('page.menu.contact')
                </a>
            </li>
            <li>
                <a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="glyphicon glyphicon-log-out"></i>@lang('page.menu.logout')
                </a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            @yield('content')
            <footer>
                &copy; {{ date('Y') }} @lang('page.footer')
            </footer>
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

<script src="{{ elixir('js/app.js') }}"></script>
<script src="{{ elixir('js/functions.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

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
@stack('scripts')
</body>
</html>