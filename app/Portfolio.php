<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $dates = ['created_at', 'updated_at', 'date'];

    public function owner()
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
        return $this->belongsToMany(Tag::class, 'portfolio_tag');
    }
}
