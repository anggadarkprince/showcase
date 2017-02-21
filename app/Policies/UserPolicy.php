<?php

namespace App\Policies;

use App\Admin;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\GenericUser;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the user.
     *
     * @param Admin|GenericUser $admin
     * @return mixed
     */
    public function view(GenericUser $admin)
    {
        return $admin->username === 'admin';
    }

    /**
     * Determine whether the user can create users.
     *
     * @param Admin|GenericUser $admin
     * @return mixed
     */
    public function create(GenericUser $admin)
    {
        return $admin->username === 'admin';
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param Admin|GenericUser $admin
     * @param  \App\User $user
     * @return mixed
     */
    public function update(GenericUser $admin, User $user)
    {
        return $admin->username === 'admin';
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param Admin|GenericUser $admin
     * @param  \App\User $user
     * @return mixed
     */
    public function delete(GenericUser $admin, User $user)
    {
        return $admin->username === 'admin';
    }
}
