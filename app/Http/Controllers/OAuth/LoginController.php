<?php

namespace App\Http\Controllers\OAuth;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    protected $provider = 'github';

    protected $providerUserId = 'provider_id';

    protected $id = '';

    protected $name = '';

    protected $username = '';

    protected $email = '';

    protected $avatar = '';

    protected $userDetail = [];

    // additional data

    protected $location = '';

    protected $about = '';

    protected $gender = 'male';

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        if ($this->provider == '' || $this->providerUserId == '') {
            throw new InvalidArgumentException("Attribute provider and provider user ID does not exist.");
        }

        return Socialite::driver($this->provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver($this->provider)->user();

        $this->resolveUserData($user);

        $isRegisteredUser = User::where($this->providerUserId, '=', $this->id)->first();

        if (!is_null($isRegisteredUser)) {
            Auth::login($isRegisteredUser);
        } else {
            // try to register, but check if username or email was exist because it must be unique
            $guessUser = User::where('username', '=', $this->username)
                ->orWhere('email', '=', $this->email)->first();

            // suggest to login with old provider
            if (!is_null($guessUser)) {
                return redirect()->to('login')
                    ->with('warning', "Username or email was registered via " . ucfirst($guessUser->provider) . " as {$guessUser->name}");
            } else { // brand new user data, then register
                $avatarName = $this->uploadAvatar();

                $registeredUser = $this->saveUser($avatarName);

                Auth::login($registeredUser);
            }
        }

        return redirect()->route('account.profile');
    }

    protected function resolveUserData($user)
    {
        $token = $user->token;

        $userDetail = Socialite::driver($this->provider)->userFromToken($token);

        $this->userDetail = collect($userDetail->user);

        $this->id = $user->getId();

        $this->name = $user->getName();

        $this->username = $user->getNickname();

        $this->email = $user->getEmail();

        $this->avatar = $user->getAvatar();
    }

    protected function uploadAvatar()
    {
        // get extension of avatar
        $size = getimagesize($this->avatar);
        $extension = image_type_to_extension($size[2]);

        // store into our storage
        $avatar = file_get_contents($this->avatar);
        $avatarName = uniqid($this->provider) . $extension;
        Storage::put('public/avatars/' . $avatarName, $avatar);

        return $avatarName;
    }

    protected function saveUser($avatarName)
    {
        return User::create([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'password' => bcrypt(str_random(20)),
            'location' => $this->location,
            'about' => $this->about,
            'avatar' => $avatarName,
            'status' => 'activated',
            'birthday' => Carbon::now()->format('Y-m-d'),
            'api_token' => str_random(60),
            'token' => str_random(50),
            'provider' => $this->provider,
            'provider_id' => $this->id,
        ]);
    }
}
