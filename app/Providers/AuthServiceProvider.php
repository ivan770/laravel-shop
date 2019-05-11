<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes(function ($router) {
            $router->forAuthorization();
            $router->forAccessTokens();
        });

        Passport::tokensCan([
            'info' => 'Get account information (email, username)',
            'payment' => 'Get payment info, charge money',
            'cart' => 'Manage your cart (get, add, remove items)'
        ]);

        Passport::setDefaultScope([
            'info',
        ]);
    }
}
