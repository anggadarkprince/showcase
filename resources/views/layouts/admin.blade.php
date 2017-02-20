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
<body>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
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
            <li><a href="{{ route('admin.dashboard') }}" {{ Request::segment($segment) == 'dashboard' ? 'class=active' : '' }}>Dashboard</a></li>
            <li><a href="{{ route('admin.user') }}" {{ Request::segment($segment) == 'user' ? 'class=active' : '' }}>Users</a></li>
            <li><a href="{{ route('admin.portfolio') }}" {{ Request::segment($segment) == 'portfolio' ? 'class=active' : '' }}>Portfolio</a></li>
            <li><a href="{{ route('admin.tag') }}" {{ Request::segment($segment) == 'tag' ? 'class=active' : '' }}>Tags</a></li>
            <li><a href="{{ route('admin.category') }}" {{ Request::segment($segment) == 'category' ? 'class=active' : '' }}>Categories</a></li>
            <li><a href="{{ route('admin.report') }}" {{ Request::segment($segment) == 'report' ? 'class=active' : '' }}>Report</a></li>
            <li><a href="{{ url('/'.App::getLocale().'/contact') }}" {{ Request::segment($segment) == 'contact' ? 'class=active' : '' }}>Contact</a></li>
            <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
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
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

<script src="{{ elixir('js/functions.js') }}"></script>
<script src="{{ elixir('js/app.js') }}"></script>
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
</script>
</body>
</html>