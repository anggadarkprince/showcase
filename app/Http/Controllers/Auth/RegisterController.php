<?php

namespace App\Http\Controllers\Auth;

use App\Mail\UserRegistered;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:100',
            'username' => 'required|max:50|regex:/[a-zA-Z0-9-_\.]{5,20}/',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token' => str_random(60),
            'token' => str_random(50),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        event(new Registered($user));

        Mail::to($request->input('email'))->queue(new UserRegistered($user));

        return $this->registered($request, $user);
    }

    /**
     * The user has been registered.
     *
     * @param Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect()->to('login')
            ->with('success', "Hi {$user->name}, We sent activation code. Please check your mail.");
    }

    public function userActivation($token)
    {
        $user = User::whereToken($token)->first();
        if (!is_null($user)) {
            if ($user->status == 'activated') {
                return redirect()->to('login')
                    ->with('success', "User is already activated.");
            }
            $user->update(['status' => 'activated']);
            return redirect()->to('login')
                ->with('success', "User active successfully.");
        }
        return redirect()->to('login')
            ->with('warning', "Your token is invalid");
    }
}
