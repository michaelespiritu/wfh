<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Conversation;
use Faker\Generator as Faker;

$factory->define(Conversation::class, function (Faker $faker) {
    return [
        'identifier' => $faker->uuid(),
        'owner_id' => factory('App\User')->create(['role_id' => 1]),
        'read' => null
    ];
});
