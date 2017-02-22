@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-title">My Portfolio</h1>

        @include('errors.common')

        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail portfolio-item-create">
                    <a href="{{ route('account.portfolio.create', [$user->username]) }}">
                        CREATE PORTFOLIO
                    </a>
                </div>
            </div>
            @foreach($portfolios as $portfolio)
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail portfolio-item">
                    <img src="{{ asset('storage/featured/placeholder-rect.jpg') }}" alt="{{ $portfolio->title }} Featured">
                    <div class="caption">
                        <h3 class="title"><a href="{{ route('account.portfolio.show', [$user->username, str_slug($portfolio->title).'-'.$portfolio->id]) }}">{{ $portfolio->title }}</a></h3>
                        <a href="{{ route('search.company', [str_slug($portfolio->company)]) }}" class="company">{{ $portfolio->company }}</a>
                        <p class="description">
                            {{ Str::words($portfolio->description, 18) }} <a href="{{ route('account.portfolio.show', [Auth::user()->username, str_slug($portfolio->title).'-'.$portfolio->id]) }}"> More</a>
                        </p>
                        <div class="timestamp clearfix">
                            <time class="pull-left">{{ $portfolio->date->diffForHumans() }}</time>
                            <span class="pull-right"><a href="{{ route('search.category', [str_slug($portfolio->category->category)]) }}">{{ $portfolio->category->category }}</a></span>
                        </div>
                        <hr>
                        <div class="control">
                            <a href="#" class="btn btn-default" role="button">Edit</a>
                            <a href="#" class="btn btn-default" role="button">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection