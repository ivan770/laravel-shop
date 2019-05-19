<?php

namespace App\Providers;

use App\Contracts\ChargeBuilder as ChargeBuilderContract;
use App\Services\ChargeBuilder as ChargeBuilderService;
use App\Contracts\PaymentProcessor as PaymentProcessorContract;
use App\Services\PaymentProcessor as PaymentProcessorService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public $bindings = [
        ChargeBuilderContract::class => ChargeBuilderService::class,
        PaymentProcessorContract::class => PaymentProcessorService::class
    ];

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
