<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'tag'
    ];

    public function portfolios()
    {
        return $this->belongsToMany(Tag::class, 'portfolio_tags');
    }
}
