<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('discovery.portfolio', function (\App\User $user) {
    /* manual method
    $portfolios = $user->portfolios;
    $userInterest = [];
    foreach ($portfolios as $portfolio){
        $tags = $portfolio->tags->pluck('tag')->toArray();
        $newTags = array_diff($tags, $userInterest);
        $userInterest = array_merge($userInterest, $newTags);
    }

    // get user interest by their user tags
    $userInterest = Tag::whereHas('portfolios', function($query) use($user) {
        $query->where('user_id', $user->id);
    })->get()->pluck('tag')->toArray();

    $newPortfolio = Portfolio::find($portfolioId);
    $newPortfolioInterest = $newPortfolio->tags->pluck('tag')->toArray();
    $userInterest = array_unique($userInterest);

    return count(array_intersect($userInterest, $newPortfolioInterest));
    */
    return true;
});