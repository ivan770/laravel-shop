<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Models\Address;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'region' => $faker->state,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'building' => $faker->buildingNumber
    ];
});
