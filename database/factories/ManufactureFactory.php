<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Manufacture;
use Faker\Generator as Faker;

$factory->define(Manufacture::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'country' => $faker->country,
        'address' => $faker->address,
    ];
});
