<?php

/* @var $factory Factory */

use App\Models\{Question, Reply, User};
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'question_id' => function () {
            return Question::inRandomOrder()->first();
        },
        'user_id' => function () {
            return User::inRandomOrder()->first();
        },
    ];
});
