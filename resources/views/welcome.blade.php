<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Lato', sans-serif;
                font-weight: 300;
                height: 100vh;
                margin: 0;
                background: #f5f8fa url("{{ asset('img/layout/workspace.jpg') }}") center center / cover;
            }

            body:before{
                content: '';
                display: block;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                position: absolute;
                top: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 40px;
                color: #fff;
            }

            .title a {
                text-decoration: none;
                color: #fff;
            }

            .title a:hover {
                color: #3097D1;
            }

            .links > a {
                color: #fff;
                padding: 0 5px;
                font-size: 12px;
                font-weight: bold;
                letter-spacing: .05rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            footer {
                color: #fff;
                text-align: center;
                position: absolute;
                bottom: 25px;
                left: 50%;
                transform: translateX(-50%);
                width: 100%;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .btn-create {
                display: none;
            }

            /* Small devices (tablets, 768px and up) */
            @media (min-width: 768px) {
                .title {
                    font-size: 84px;
                }
                .links > a {
                    padding: 0 20px;
                    letter-spacing: .1rem;
                }
                .btn-create {
                    display: inline-block;
                }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="top-left links">
                <a href="{{ route('page.explore') }}">Explore</a>
            </div>
            @if (Route::has('account.login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ route('account.portfolio.create', [Auth::user()->username]) }}" class="btn-create">Create Portfolio</a>
                        <a href="{{ route('account.show', [Auth::user()->username]) }}">My Account</a>
                    @else
                        <a href="{{ route('account.login') }}">Login</a>
                        <a href="{{ route('account.register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    @if(Request::url('/') == route('page.about'))
                        <small>Crafted by
                            <a href="https://twitter.com/anggadarkprince">
                                @anggadarkprince
                            </a>
                        </small>
                    @elseif(Request::url('/') == route('page.help'))
                        <small>Ask question?
                            <a href="tel:+6285655479868">
                                +Contact Me
                            </a>
                        </small>
                    @else
                        Showcase.dev
                    @endif
                </div>

                <div class="links">
                    <a href="{{ route('page.explore') }}">Discover</a>
                    <a href="{{ route('page.about') }}">About</a>
                    <a href="{{ route('page.help') }}">Help</a>
                    <a href="https://github.com/anggadarkprince/showcase">GitHub</a>
                </div>
            </div>

            <footer>&copy {{ date('Y') }} <strong>Showcase.dev</strong> all rights reserved.</footer>
        </div>
    </body>
</html>
