@forelse($portfolios as $portfolio)

    <div class="{{ $columns }}">
        <div class="panel panel-default portfolio-item">
            <?php
            $screenshot = $portfolio->screenshots()->whereIsFeatured(1)->first();
            $featured = is_null($screenshot) ? 'placeholder.jpg' : $screenshot->source;

            $portfolioSlug = str_slug($portfolio->title) . '-' . $portfolio->id;
            $categorySlug = str_slug($portfolio->category->category) . '-' . $portfolio->category->id;
            ?>

            <div class="featured" style="background: url('{{ asset("storage/screenshots/{$featured}") }}') center center / cover;">
                @if(isset($editable) && $editable)
                    <div class="control">
                        <a href="{{ route('account.portfolio.edit', [$user->username, $portfolio->id]) }}" class="btn btn-default" role="button">
                            <i class="glyphicon glyphicon-edit"></i> Edit
                        </a>
                        <a href="#" class="btn btn-default btn-delete" role="button"
                           onclick="return deletePortfolio(event, '{{ route('account.portfolio.destroy', [$user->username, $portfolio->id]) }}')">
                            <i class="glyphicon glyphicon-trash"></i > Delete
                        </a>
                    </div>
                @endif
            </div>

            <div class="caption">
                <div class="title-wrapper">
                    <h3 class="title">
                        <a href="{{ route('profile.portfolio.show', [$portfolio->user->username, $portfolioSlug]) }}">
                            {{ $portfolio->title }}
                        </a>
                    </h3>
                    @if(isset($showUserLink) && $showUserLink)
                        <a href="{{ route('profile.show', [$portfolio->user->username]) }}" class="company">
                            {{ $portfolio->user->name }}
                        </a>
                    @else
                        <a href="{{ route('portfolio.search.company', [urlencode($portfolio->company)]) }}" class="company">
                            {{ $portfolio->company }}
                        </a>
                    @endif
                </div>
                <hr>
                <div class="timestamp clearfix">
                    <time class="pull-left">
                        {{ $portfolio->date->diffForHumans() }}
                    </time>
                    <div class="pull-right">
                        <a href="{{ route('portfolio.search.category', [$categorySlug]) }}">
                            {{ str_limit($portfolio->category->category, 15) }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <p class="text-center">No result of portfolio discovery.</p>
@endforelse