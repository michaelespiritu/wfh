<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\JobBoard;
use Faker\Generator as Faker;

$factory->define(JobBoard::class, function (Faker $faker) {
    return [
        'identifier' => $faker->uuid(),
        'name' => 'Waiting'
    ];
});
