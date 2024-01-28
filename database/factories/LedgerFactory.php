<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ledger;
use App\Models\Station;
use Faker\Generator as Faker;

$factory->define(Ledger::class, function (Faker $faker) {
    return [
        'station_id' => function () {
            return Station::all()->random();
        },
        'address' => $faker->address
    ];
});
