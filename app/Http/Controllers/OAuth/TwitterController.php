<?php

namespace App\Http\Controllers\OAuth;

class TwitterController extends LoginController
{
    protected $provider = 'twitter';

    protected function resolveUserData($user)
    {
        $this->userDetail = collect($user->user);

        $this->id = $user->getId();

        $this->name = $user->getName();

        $this->username = $user->getNickname();

        $this->email = $user->getEmail();

        $this->avatar = $user->avatar_original;

        $this->location = $this->userDetail->get('location');

        $this->about = $this->userDetail->get('description');
    }
}
