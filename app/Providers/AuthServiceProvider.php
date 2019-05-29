<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Cart;
use App\Policies\AddressPolicy;
use App\Policies\CartPolicy;
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
         Address::class => AddressPolicy::class,
         Cart::class => CartPolicy::class,
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
            'cart' => 'Manage your cart (get, add, remove items)',
            'wishlist' => 'Manage your wishlist (get, add, remove items)',
            'address' => 'Manage saved addresses',
            'oauth' => 'Manage connected OAuth providers'
        ]);

        Passport::setDefaultScope([
            'info',
        ]);
    }
}
