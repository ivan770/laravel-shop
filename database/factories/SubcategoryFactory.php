<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Subcategory;
use Faker\Generator as Faker;

$factory->define(Subcategory::class, function (Faker $faker) {
    return [
        'name' => $faker->text(15)
    ];
});
