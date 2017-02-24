@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                @include('layouts.profile')
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="showcase">
                    <h3 class="showcase-label">SHOWCASE</h3>

                    <div class="view-wrapper">
                        <small>VIEWS</small>
                        <?php
                            $views = $portfolio->view;
                            if($views >= 10000){
                                $views = number_format($views/1000, 1).'K';
                            }
                        ?>
                        <h3>{{ $views }}</h3>
                    </div>
                    <div class="title-wrapper">
                        <h1 class="title">{{ $portfolio->title }}</h1>
                        <p class="company lead"><a href="{{ route('portfolio.search.company', [urlencode($portfolio->company)]) }}">{{ $portfolio->company }}</a></p>
                    </div>
                    <p class="text-muted m-b-sm">Published At {{ $portfolio->date->format('d F Y') }}</p>

                    <p><strong>DESCRIPTION</strong></p>
                    <p>{{ $portfolio->description }}</p>

                    <div class="showcase-tags">
                        <p><strong>TAGS</strong></p>
                        @foreach($portfolio->tags as $tag)
                            <a href="{{ route('portfolio.search.tag', [str_slug($tag->tag)]) }}" class="label">{{ $tag->tag }}</a>
                        @endforeach
                    </div>

                    <div class="showcase-screenshots">
                        <p><strong>SCREENSHOTS</strong></p>
                        @foreach($portfolio->screenshots as $screenshot)
                            <img src="{{ asset("storage/screenshots/{$screenshot->source}") }}"
                                 alt="{{ $screenshot->caption }}" class="img-responsive">
                        @endforeach
                    </div>

                    <div class="showcase-share">
                        <strong>SHARE</strong>
                        <ul class="list-inline">
                            <li><a href="#"><img src="{{ asset('img/layout/icon-facebook.jpg') }}" alt="Share Facebook"></a></li>
                            <li><a href="#"><img src="{{ asset('img/layout/icon-twitter.jpg') }}" alt="Share Twitter"></a></li>
                            <li><a href="#"><img src="{{ asset('img/layout/icon-google.jpg') }}" alt="Share Google"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection