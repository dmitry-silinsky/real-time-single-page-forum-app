<?php

/* @var $factory Factory */

use App\Models\{Category, Question, User};
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Question::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'body' => $faker->text,
        'category_id' => function () {
            return Category::inRandomOrder()->first();
        },
        'user_id' => function () {
            return User::inRandomOrder()->first();
        },
    ];
});
