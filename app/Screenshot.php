<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screenshot extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'portfolio_id', 'caption', 'source', 'is_featured'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}
