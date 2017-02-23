@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="page-title">{{ $title }}</h1>

        @include('errors.common')

        <div class="row">
            @foreach($portfolios as $portfolio)

                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail portfolio-item">
                        <?php
                        $screenshot = $portfolio->screenshots()->whereIsFeatured(1)->first();
                        $caption = 'placeholder-rect.jpg';
                        if(is_null($screenshot)){
                            $featured = 'placeholder-rect.jpg';
                        }
                        else{
                            $featured = $screenshot->source;
                            $caption = $screenshot->caption;
                        }
                        ?>

                        <div class="featured" style="background: url('{{ asset("storage/screenshots/{$featured}") }}') center center / cover;"></div>

                        <div class="caption">
                            <h3 class="title"><a href="{{ route('profile.portfolio.show', [$portfolio->user->username, str_slug($portfolio->title).'-'.$portfolio->id]) }}">{{ $portfolio->title }}</a></h3>
                            <a href="{{ route('portfolio.search.company', [str_slug($portfolio->company)]) }}" class="company">{{ $portfolio->company }}</a>
                            <div class="timestamp clearfix">
                                <time class="pull-left">{{ $portfolio->date->diffForHumans() }}</time>
                                <span class="pull-right"><a href="{{ route('portfolio.search.category', [str_slug($portfolio->category->category)]) }}">{{ str_limit($portfolio->category->category, 30) }}</a></span>
                            </div>
                            <hr>
                            <?php $count = 0; ?>
                            @foreach($portfolio->tags as $tag)
                                <a href="{{ route('portfolio.search.tag', [str_slug($tag->tag)]) }}"><span class="label label-primary">{{ $tag->tag }}</span></a>
                                @if($count++ == 7)
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="center-block">
            {{ $portfolios->links() }}
        </div>
    </div>
@endsection