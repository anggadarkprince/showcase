<?php

namespace App\Http\Controllers;

use App\Portfolio;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('portfolio');
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
            $portfolio = new Portfolio();
            $portfolios = $portfolio->discover();
            $dashboard_active = true;
            return view('users.dashboard', compact('dashboard_active', 'user', 'portfolios'));
        } else {
            return redirect()->route('account.show', [$loggedUser]);
        }
    }

    public function settings(User $user)
    {
        return view('settings.index', compact('user'));
    }

    public function storeSettings(Request $request, User $user)
    {
        $messages = [
            'password.required' => 'The :attribute is needed to update settings.',
        ];

        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|regex:/^[a-zA-Z0-9-_\.]{5,20}$/|unique:users,username,' . $user->id,
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'gender' => 'required|in:male,female',
            'about' => 'required|max:500',
            'birthday' => 'required|date_format:Y-m-d',
            'avatar' => 'image|max:500',
            'location' => 'required|max:255',
            'contact' => 'required|alpha_num|max:255',
            'password' => 'required|authorized_password',
            'password_new' => 'sometimes|confirmed|min:6|max:20',
            'password_new_confirmation' => 'sometimes|min:6|max:20'
        ], $messages);

        $except = ['password', 'password_new', 'password_new_confirmation'];
        $inputs = $request->except($except);

        if (!empty($request->input('password_new'))) {
            $inputs['password'] = Hash::make($request->input('password_new'));
        }

        $avatar = $request->file('avatar');
        if (!empty($avatar)) {
            $name = $avatar->hashName();
            $path = $request->file('avatar')->storeAs('public/avatars', $name);

            if ($path) {
                $inputs['avatar'] = $name;
            } else {
                return redirect()->back()->withErrors([
                    'avatar' => 'Something wrong when upload avatar',
                    'error' => 'Update setting failed, Try again!'
                ]);
            }
        }

        $user->fill($inputs);

        if ($user->save()) {
            return redirect()->route('account.settings', [$user->username])->with([
                'action' => 'success',
                'message' => 'Setting was updated successfully'
            ]);
        }

        return redirect()->back()->withErrors([
            'error' => 'Update setting failed, Try again!'
        ]);
    }

    public function portfolio(User $user)
    {
        $portfolios = $user->portfolios()->latest('date')->paginate(12);
        return view('users.profile', compact('user', 'portfolios'));
    }
}
