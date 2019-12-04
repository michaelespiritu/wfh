<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'identifier' => $faker->uuid(),
        'conversation_id' => factory('App\Model\Conversation')->create(),
        'from_id' => factory('App\User')->create(['role_id' => 1]),
        'message' => $faker->text(),
    ];
});
