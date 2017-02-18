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

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-sidebar.css') }}" rel="stylesheet">

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
            <li><a href="{{ route('admin.dashboard') }}" {{ Request::segment(2) == 'dashboard' ? 'class=active' : '' }}>Dashboard</a></li>
            <li><a href="{{ route('admin.user') }}" {{ Request::segment(2) == 'user' ? 'class=active' : '' }}>Users</a></li>
            <li><a href="{{ route('admin.portfolio') }}" {{ Request::segment(2) == 'portfolio' ? 'class=active' : '' }}>Portfolio</a></li>
            <li><a href="{{ route('admin.tag') }}" {{ Request::segment(2) == 'tag' ? 'class=active' : '' }}>Tags</a></li>
            <li><a href="{{ route('admin.category') }}" {{ Request::segment(2) == 'category' ? 'class=active' : '' }}>Categories</a></li>
            <li><a href="{{ route('admin.report') }}" {{ Request::segment(2) == 'report' ? 'class=active' : '' }}>Report</a></li>
            <li><a href="{{ url('/'.App::getLocale().'/contact') }}" {{ Request::segment(2) == 'contact' ? 'class=active' : '' }}>Contact</a></li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            @yield('content')
        </div>
    </div>
    <!-- /#page-content-wrapper -->
</div>
<!-- /#wrapper -->

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
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