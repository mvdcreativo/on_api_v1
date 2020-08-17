<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Models\Lesson::class, function (Faker $faker) {
    $name = "Clase prueba".$faker->sentence($nbWords = 4, $variableNbWords = true);
    return [


        'name' => $name,
        'description' => $faker->paragraph($nbSentences = 4, $variableNbSentences = false),
        'course_section_id' => rand(1,8),
        'slug' => Str::slug($name),
        'price' => $faker->randomElement([null, 1500]),
        'video' => null,
        'duration' => "1hs",
        'currency_id' => 2
    ];
});
