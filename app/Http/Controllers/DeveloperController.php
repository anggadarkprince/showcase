<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index(User $user)
    {
        return view('developer.index', compact('user'));
    }
}
