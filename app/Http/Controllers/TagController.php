<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function searchTag($query){
        $tags = Tag::where('tag', 'like', "%{$query}%")->limit(10)->get();
        return response()->json($tags);
    }
}
