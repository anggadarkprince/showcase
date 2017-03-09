@extends('layouts.app')

@section('title', '- Developer')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                @include('partials._profile_sidebar')
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Developer API</div>
                        </div>
                    </div>
                </div>
                <!-- let people make clients -->
                <passport-clients></passport-clients>

                <!-- list of clients people have authorized to access our account -->
                <passport-authorized-clients></passport-authorized-clients>

                <!-- make it simple to generate a token right in the UI to play with -->
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
@endsection