<?php

use Faker\Generator;
use JoeDixon\Translation\Language;
use JoeDixon\Translation\Translation;

$factory->define(Translation::class, function (Generator $faker) {
    return [
        'group' => $faker->word,
        'key' => $faker->word,
        'value' => $faker->sentence,
    ];
});

$factory->state(Translation::class, 'group', function (Generator $faker) {
    return [
        'group' => $faker->word,
        'key' => $faker->word,
        'value' => $faker->sentence,
    ];
});

$factory->state(Translation::class, 'single', function (Generator $faker) {
    return [
        'group' => 'single',
        'key' => $faker->word,
        'value' => $faker->sentence,
    ];
});
