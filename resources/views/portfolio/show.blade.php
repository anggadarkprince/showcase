@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                @include('layouts.profile')
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="row">
                    @foreach($portfolios as $portfolio)

                        <div class="col-sm-6 col-lg-4">
                            <div class="thumbnail portfolio-item">
                                <?php
                                $screenshot = $portfolio->screenshots()->whereIsFeatured(1)->first();
                                $featured = is_null($screenshot) ? 'placeholder.jpg' : $screenshot->source;

                                $portfolioSlug = str_slug($portfolio->title).'-'.$portfolio->id;
                                $categorySlug = str_slug($portfolio->category->category).'-'.$portfolio->category->id;
                                ?>

                                <div class="featured" style="background: url('{{ asset("storage/screenshots/{$featured}") }}') center center / cover;"></div>

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
                                                {{ str_limit($portfolio->category->category, 17) }}
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="center-block">
                    {{ $portfolios->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection