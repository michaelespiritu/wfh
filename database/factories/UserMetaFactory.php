<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\UserMeta;
use Faker\Generator as Faker;

$factory->define(UserMeta::class, function (Faker $faker) {
    return [
        'name' => 'company_name',
        'value' => $faker->company()
    ];
});
