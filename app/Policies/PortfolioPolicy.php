<?php

namespace App\Policies;

use App\Portfolio;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the category.
     *
     * @param User $user
     * @param Portfolio $portfolio
     * @return mixed
     */
    public function delete(User $user, Portfolio $portfolio)
    {
        return $user->id == $portfolio->user_id;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param User $user
     * @param Portfolio $portfolio
     * @return mixed
     */
    public function view(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User $user
     * @param Portfolio $portfolio
     * @return mixed
     */
    public function update(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }
}
