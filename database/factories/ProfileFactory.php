<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Profile;
use Faker\Generator as Faker;

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'title' => $faker->title(),
        'profile_image' => 'https://dummyimage.com/600x400/000/fff'
    ];
});
