<?php

use Faker\Generator as Faker;

$factory->define(
    App\Models\Banks\Operadora::class, function (Faker $faker) {
        return [
        'name' => $faker->name,
        'status' => 1
        ];
    }
);