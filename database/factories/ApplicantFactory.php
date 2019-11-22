<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Applicant;
use Faker\Generator as Faker;

$factory->define(Applicant::class, function (Faker $faker) {
    return [
        'identifier' => $faker->uuid(),
        'job_id' => factory('App\Model\Job')->create(),
        'user_id' => factory('App\User')->create(['role_id' => 2]),
        'status' => 'Waiting',
        'cover_letter' => $faker->text()
    ];
});
