<?php

namespace App\Http\Controllers\OAuth;

class FacebookController extends LoginController
{
    protected $provider = 'facebook';

    protected function resolveUserData($user)
    {
        parent::resolveUserData($user);

        $this->username = str_slug($user->getName()) . '-' . $user->getId();

        $this->avatar = $user->avatar_original;

        $this->gender = $this->userDetail->get('gender');

        $allowedGender = ['male', 'female'];

        $this->gender = in_array($this->gender, $allowedGender) ?: 'male';
    }
}
