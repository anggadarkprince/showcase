<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return "show {$user->id}";
    }

    public function portfolio(User $user)
    {
        return 'portfolio';
    }

    public function about(User $user)
    {
        return 'about';
    }

    public function contact(User $user)
    {
        return 'contact';
    }
}
