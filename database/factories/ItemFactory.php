<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => $faker->text(20),
        'short_description' => $faker->text(100),
        'description' => $faker->text(200),
        'price' => $faker->randomDigitNotNull
    ];
});
