<?php

namespace App\Http\Controllers\OAuth;

class GithubController extends LoginController
{
    protected $provider = 'github';

    protected function resolveUserData($user)
    {
        parent::resolveUserData($user);

        $this->location = $this->userDetail->get('location');

        $this->about = $this->userDetail->get('bio');
    }
}
