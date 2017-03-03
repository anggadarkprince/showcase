@extends('layouts.app')

@section('title', '- Portfolios')

@section('content')
    <div class="container">
        <h1 class="page-title">{!! $title !!}
            @include('partials._stats_showing', ['data' => $portfolios])
        </h1>
        @include('errors.common')

        <div class="row">
            @include('partials._portfolio_card', [
                'showUserLink' => true,
                'columns' => 'col-sm-6 col-md-4 col-lg-3'
            ])
        </div>

        <div class="center-block">
            {{ $portfolios->links() }}
        </div>
    </div>
@endsection