@extends('layouts.app')

@section('title', '- Dashboard')

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
                        <div class="panel-heading">Showcase Today</div>
                    </div>
                </div>
            </div>
            <div class="row showcase-today-wrapper">
                @include('partials._portfolio_card', [
                    'columns' => 'col-sm-6 col-lg-4',
                    'showUserLink' => true
                ])
            </div>
        </div>
    </div>
</div>
@endsection
