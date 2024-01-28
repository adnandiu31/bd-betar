<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Station;
use Faker\Generator as Faker;

$factory->define(Station::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address' => $faker->address,
    ];
});
