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
        return $this->belongsToMany(Portfolio::class, 'portfolio_tags');
    }
}
