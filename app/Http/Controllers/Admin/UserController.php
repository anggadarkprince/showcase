<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * The attributes that object of User.
     *
     * @var User
     */
    private $user;

    /**
     * UserController constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->members();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|regex:/[a-zA-Z0-9-_\.]{5,20}/',
            'email' => 'required|email|max:100',
            'gender' => 'required|in:male,female',
            'about' => 'required|max:500',
            'birthday' => 'required|date_format:Y-m-d',
            'location' => 'required|max:255',
            'contact' => 'required|alpha_num|max:255',
            'password' => 'required|confirmed|min:6|max:20',
            'password_confirmation' => 'required|min:6|max:20',
            'status' => 'required|in:pending,activated,suspended',
        ]);

        $request->merge([
            'api_token' => str_random(60),
            'remember_token' => str_random(10)
        ]);

        $user = new User();
        $user->fill($request->except(['password_confirmation', '_token']));

        return DB::transaction(function () use ($user) {
            if ($user->save()) {
                $user->roles()->attach(Role::whereRole('member')->first()->id);
                return redirect(route('admin.user'))->with([
                    'action' => 'success',
                    'message' => 'User was created successfully'
                ]);
            }
            return redirect()->back()->withErrors([
                'error' => 'Create new user failed, Try again!'
            ]);
        }, 5);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|regex:/[a-zA-Z0-9-_\.]{5,20}/',
            'email' => 'required|email|max:100',
            'gender' => 'required|in:male,female',
            'about' => 'required|max:500',
            'birthday' => 'required|date_format:Y-m-d',
            'location' => 'required|max:255',
            'contact' => 'required|alpha_num|max:255',
            'password' => 'confirmed|min:6|max:20',
            'password_confirmation' => 'min:6|max:20',
            'status' => 'required|in:pending,activated,suspended',
        ]);

        $except = ['password_confirmation', '_token'];
        if (empty($request->input('password'))) {
            array_push($except, 'password');
        }
        $user->fill($request->except($except));

        return DB::transaction(function () use ($user) {
            if ($user->save()) {
                $user->roles()->sync([Role::whereRole('member')->first()->id]);
                return redirect(route('admin.user'))->with([
                    'action' => 'success',
                    'message' => 'User was updated successfully'
                ]);
            }
            return redirect()->back()->withErrors([
                'error' => 'Update user failed, Try again!'
            ]);
        }, 5);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect(route('admin.user'))->with([
                'action' => 'success',
                'message' => "User {$user->username} was successfully deleted"
            ]);
        }
        return redirect()->back()->withErrors([
            'action' => 'danger',
            'message' => 'Failed to perform delete user'
        ]);
    }
}
