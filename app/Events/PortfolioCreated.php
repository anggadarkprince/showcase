<?php

namespace App\Events;

use App\Portfolio;
use App\Tag;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Auth;

class PortfolioCreated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $portfolio;

    public $portfolioPushData;

    /**
     * Create a new event instance.
     *
     * @param Portfolio $portfolio
     */
    public function __construct(Portfolio $portfolio)
    {
        $this->portfolio = $portfolio;

        // check if user interest
        $user = Auth::user();
        $userInterest = Tag::whereHas('portfolios', function($query) use($user) {
            $query->where('user_id', $user->id);
        })->get()->pluck('tag')->toArray();

        $newPortfolioInterest = $portfolio->tags->pluck('tag')->toArray();
        $userInterest = array_unique($userInterest);

        // TODO: still not what I want
        if(count(array_intersect($userInterest, $newPortfolioInterest)) > 0){
            $screenshot = $portfolio->screenshots()->whereIsFeatured(1)->first();
            $featured = is_null($screenshot) ? 'placeholder.jpg' : $screenshot->source;

            $portfolioSlug = str_slug($portfolio->title) . '-' . $portfolio->id;
            $categorySlug = str_slug($portfolio->category->category) . '-' . $portfolio->category->id;

            $this->portfolioPushData['interest'] = true;
            $this->portfolioPushData['interest_user'] = $user;
            $this->portfolioPushData['interest_portfolio'] = $newPortfolioInterest;
            $this->portfolioPushData['featured'] = asset("storage/screenshots/{$featured}");
            $this->portfolioPushData['title'] = $portfolio->title;
            $this->portfolioPushData['url'] = route('profile.portfolio.show', [$portfolio->user->username, $portfolioSlug]);
            $this->portfolioPushData['author'] = $portfolio->user->name;
            $this->portfolioPushData['author_url'] = route('profile.show', [$portfolio->user->username]);
            $this->portfolioPushData['published'] = $portfolio->date->diffForHumans();
            $this->portfolioPushData['category'] = str_limit($portfolio->category->category, 15);
            $this->portfolioPushData['category_url'] = route('portfolio.search.category', [$categorySlug]);
        }
        else{
            $this->portfolioPushData['interest'] = false;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('discovery.portfolio');
    }

}
