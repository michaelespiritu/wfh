<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\EmployerCredit;
use Faker\Generator as Faker;

$factory->define(EmployerCredit::class, function (Faker $faker) {
    return [
        'credit' => 1
    ];
});
