<?php

namespace App\Providers;

use App\Category;
use App\Policies\PortfolioPolicy;
use App\Policies\UserPolicy;
use App\Policies\CategoryPolicy;
use App\Portfolio;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        User::class => UserPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(Carbon::now()->addDays(15));

        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

        Passport::tokensCan([
            'portfolio' => 'Access Portfolio',
            'account' => 'Account Information',
            'stream' => 'Showcase Today',
        ]);
    }
}
