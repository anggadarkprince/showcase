<?php

namespace App\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoogleController extends LoginController
{
    protected $provider = 'google';

    protected function resolveUserData($user)
    {
        parent::resolveUserData($user);

        $this->username = str_slug($user->getName()) . '-' . $user->getId();

        $this->avatar = $user->avatar_original;

        $placeLive = $this->userDetail->get('placesLived');
        if(!is_null($placeLive)){
            $this->location = $placeLive[0]['value'];
        }

        $this->about = $this->userDetail->get('aboutMe');
    }
}
