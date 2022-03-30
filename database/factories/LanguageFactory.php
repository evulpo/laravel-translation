<?php

use Faker\Generator;
use JoeDixon\Translation\Language;

$factory->define(Language::class, function (Generator $faker) {
    return [
        'locale' => $faker->word,
        'name' => $faker->word,
    ];
});
