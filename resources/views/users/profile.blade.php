@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                @include('partials._profile_sidebar')
            </div>
            <div class="col-md-8 col-lg-9">
                <h1 class="page-title m-b-sm">SHOWCASE
                    @include('partials._portfolio_showing')
                </h1>
                <div class="row">
                    @include('partials._portfolio_card', ['columns' => 'col-sm-6 col-lg-4'])
                </div>

                <div class="center-block">
                    {{ $portfolios->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection