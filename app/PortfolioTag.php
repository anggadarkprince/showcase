<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PortfolioTag extends Model
{
    // make sure Eloquent won't try to set them on his way, because database set default
    private $timestamps = false;
}
