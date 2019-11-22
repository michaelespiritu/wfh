<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Job;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    return [
        'identifier' => $faker->uuid(),
        'owner_id' => factory('App\User')->create(['role_id' => 1]),
        'expiration' => Carbon::now()->addDays(60),
        'category_id' => 1,
        'title' => $faker->jobTitle(),
        'region_restriction' => 'PH only', 
        'notify_email' => ['test@email.com', 'test2@email.com'], 
        'type' => 'Full Time',
        'skills' => ['Laravel', 'Angular'], 
        'budget' => ['amount' => '500', 'type' => 'Per Hour'], 
        'description' => $faker->text()
    ];
});
