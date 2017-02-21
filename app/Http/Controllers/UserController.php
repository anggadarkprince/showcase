<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return redirect()->route('account.show', ['user' => $user->username]);
    }

    public function show(User $user)
    {
        $loggedUser = Auth::user()->username;
        if ($user->username == $loggedUser) {
            return view('home.home');
        } else {
            return redirect()->route('account.show', [$loggedUser]);
        }
    }

    public function settings(User $user)
    {
        return 'settings';
    }
}
