<?php

/* @var $factory Factory */

use App\Models\{Like, Reply, User};
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'reply_id' => function () {
            return Reply::inRandomOrder()->first();
        },
        'user_id' => function () {
            return User::inRandomOrder()->first();
        },
    ];
});
