@extends('layouts.app')

@section('title', '- Search Result of '.request('q'))

@section('content')
    <div class="container search-container">
        <h1 class="page-title">Result of '{{ request('q') }}'
            @include('partials._stats_showing', ['data' => isset($portfolios) ? $portfolios : $users])
        </h1>
        <div class="search-option">
            <span class="search-label m-r-xs">Search For</span>
            <div class="btn-group option">
                <a href="{{ route('page.search') }}?q={{ urlencode(request('q')) }}&type=showcase"
                   class="btn @if(request('type', 'showcase') == 'showcase') btn-primary active @else btn-default @endif">SHOWCASE</a>
                <a href="{{ route('page.search') }}?q={{ urlencode(request('q')) }}&type=people"
                   class="btn @if(request('type') == 'people') btn-primary active @else btn-default @endif">PEOPLE</a>
            </div>
        </div>
        @include('errors.common')

        <div class="row">
        @if(request('type', 'showcase') == 'showcase')
            @include('partials._portfolio_card', [
                'showUserLink' => true,
                'columns' => 'col-sm-6 col-md-4 col-lg-3'
            ])
        @else
            @include('partials._people_card', [
                'columns' => 'col-sm-6 col-md-4 col-lg-3'
            ])
        @endif
    </div>

    <div class="center-block">
        @if(request('type', 'showcase') == 'showcase')
            {{ $portfolios->appends(request()->all())->links() }}
        @else
            {{ $users->appends(request()->all())->links() }}
        @endif
    </div>
</div>
@endsection