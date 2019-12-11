<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Conversation;
use Faker\Generator as Faker;

$factory->define(Conversation::class, function (Faker $faker) {
    $user =  factory('App\User')->create(['role_id' => 1]);
    return [
        'identifier' => $faker->uuid(),
        'owner_id' => $user->id,
        'read' => null
    ];
});
