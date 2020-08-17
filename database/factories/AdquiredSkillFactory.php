<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdquiredSkill;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(AdquiredSkill::class, function (Faker $faker) {
    $title = "Cono prueba ".$faker->sentence($nbWords = 4, $variableNbWords = true);
    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'course_id' => rand(1,50)
    ];
});
