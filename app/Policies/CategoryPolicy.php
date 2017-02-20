<?php

namespace App\Policies;

use App\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\GenericUser;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the category.
     *
     * @param Admin|GenericUser $admin
     * @return mixed
     */
    public function delete(GenericUser $admin)
    {
        return $admin->username == 'admin';
    }
}
