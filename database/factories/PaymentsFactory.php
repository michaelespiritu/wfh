<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Payments;
use Faker\Generator as Faker;

$factory->define(Payments::class, function (Faker $faker) {
    return [
        'identifier' => $faker->uuid(),
        'user_id' => factory('App\User')->create(['role_id' => 1]),
        'purchase_id' => $faker->uuid(),
        'amount' => 10,
    ];
});
