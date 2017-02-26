@extends('layouts.admin')

@section('title', trans('page.title.portfolio'))

@section('content')
    @php
        $title = [
            trans('page.menu.dashboard'),
            trans('page.menu.portfolio')
        ];
    @endphp

    @include('partials._admin_title', ['title' => collect($title), 'isBreadcrumb' => true])

    <div class="section-title">
        <h3>
            @lang('page.title.portfolio')
            <button class="btn btn-default pull-right"
                    onclick="window.location.href='{{ route('page.explore') }}'">
                <i class="glyphicon glyphicon-globe"></i>
                EXPLORE
            </button>
        </h3>
        <p class="text-muted">@lang('page.subtitle.portfolio')</p>
    </div>

    <div class="row">
        @include('partials._portfolio_card', ['columns' => 'col-sm-6 col-md-4', 'showUserLink' => true])
    </div>

    <div class="center-block">
        {{ $portfolios->links() }}
    </div>

@endsection