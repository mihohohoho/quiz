<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Quiz;
use Faker\Generator as Faker;

$factory->define(Quiz::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'choice1' => $faker->word,
        'choice2' => $faker->word,
        'choice3' => $faker->word,
        'explanation' => $faker->word,
        'user_id' => $faker->randomNumber(1),
        'level_id' => $faker->numberBetween(1,3),
        'category_id' => $faker->numberBetween(1,3),
    ];
});
