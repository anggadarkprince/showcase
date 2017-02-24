<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Portfolio extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'category_id', 'date', 'company', 'reference', 'vote', 'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function screenshots()
    {
        return $this->hasMany(Screenshot::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'portfolio_tags');
    }

    public function explore()
    {
        $isLoggedIn = Auth::check();

        if($isLoggedIn){
            $user = Auth::user();
            $relatedTags = $user->portfolios()
                ->join('portfolio_tags', 'portfolios.id', '=', 'portfolio_tags.portfolio_id')
                ->distinct()
                ->get(['tag_id'])
                ->pluck('tag_id');

            $relatedCategory = $user->portfolios()
                ->distinct()
                ->get(['category_id'])
                ->pluck('category_id');

            $discover = $this->select()
                ->join('portfolio_tags', 'portfolios.id', '=', 'portfolio_tags.portfolio_id')
                ->whereIn('category_id', $relatedCategory)
                ->orWhereIn('tag_id', $relatedTags)
                ->inRandomOrder()
                ->distinct()
                ->paginate(12);

            return $discover;
        }

        $discover = $this->select()
            ->latest()
            ->paginate(12);

        return $discover;
    }

    public function portfolioByTag($tag)
    {
        $portfolios = $this->select()
            ->join('portfolio_tags', 'portfolios.id', '=', 'portfolio_tags.portfolio_id')
            ->join('tags', 'tags.id', '=', 'portfolio_tags.tag_id')
            ->where('tag', 'like', "%{$tag}%")
            ->orderBy('portfolios.created_at', 'desc')
            ->distinct()
            ->paginate(12);

        return $portfolios;
    }

    public function portfolioRelated(User $user)
    {
        $related = $user->portfolios()
            ->where('portfolios.id', '!=', $this->id)
            ->inRandomOrder()
            ->take(3)
            ->get();
        return $related;
    }
}
