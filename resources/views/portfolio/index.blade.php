@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-title">My Portfolio</h1>

        @include('errors.common')

        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="thumbnail portfolio-item-create">
                    <a href="{{ route('account.portfolio.create', [$user->username]) }}">
                        CREATE PORTFOLIO
                    </a>
                </div>
            </div>
            @foreach($portfolios as $portfolio)

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="thumbnail portfolio-item">
                        <?php
                        $screenshot = $portfolio->screenshots()->whereIsFeatured(1)->first();
                        $featured = is_null($screenshot) ? 'placeholder.jpg' : $screenshot->source;

                        $portfolioSlug = str_slug($portfolio->title).'-'.$portfolio->id;
                        $categorySlug = str_slug($portfolio->category->category).'-'.$portfolio->category->id;
                        ?>

                        <div class="featured" style="background: url('{{ asset("storage/screenshots/{$featured}") }}') center center / cover;">
                            <div class="control">
                                <a href="{{ route('account.portfolio.edit', [$user->username, $portfolio->id]) }}" class="btn btn-default" role="button">
                                    <i class="glyphicon glyphicon-edit"></i> Edit
                                </a>
                                <a href="#" class="btn btn-default btn-delete" role="button"
                                   onclick="return deletePortfolio(event, '{{ route('account.portfolio.destroy', [$user->username, $portfolio->id]) }}')">
                                    <i class="glyphicon glyphicon-trash"></i > Delete
                                </a>
                            </div>
                        </div>

                        <div class="caption">
                            <div class="title-wrapper">
                                <h3 class="title">
                                    <a href="{{ route('profile.portfolio.show', [$portfolio->user->username, $portfolioSlug]) }}">
                                        {{ $portfolio->title }}
                                    </a>
                                </h3>
                                <a href="{{ route('portfolio.search.company', [urlencode($portfolio->company)]) }}" class="company">
                                    {{ $portfolio->company }}
                                </a>
                            </div>
                            <hr>
                            <div class="timestamp clearfix">
                                <time class="pull-left">
                                    {{ $portfolio->date->diffForHumans() }}
                                </time>
                                <span class="pull-right">
                                    <a href="{{ route('portfolio.search.category', [$categorySlug]) }}">
                                        {{ str_limit($portfolio->category->category, 15) }}
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <script>
                function deletePortfolio(event, url){
                    event.preventDefault();
                    var answer = confirm('Are you sure want to delete?');
                    if(answer){
                        var form = document.getElementById('delete-form');
                        form.setAttribute('action', url);
                        form.submit();
                    }
                }
            </script>
            <form id="delete-form" action="#" method="POST" style="display: none;">
                {{ csrf_field() }}
                {{ method_field('delete') }}
            </form>

        </div>

        <div class="center-block">
            {{ $portfolios->links() }}
        </div>
    </div>
@endsection