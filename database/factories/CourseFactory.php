<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Course;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Course::class, function (Faker $faker) {
    $title = "Curso prueba ".$faker->sentence($nbWords = 4, $variableNbWords = true);
    return [
        'title' => $title,
        'cupos' => rand(10,30),
        'image' => asset("storage/images/courses")."/".rand(01,37).".jpg",
        'length' => rand(7,10),
        'length_unit_id' => rand(3,7),
        'date_ini' => $faker->dateTime($min = 'now'),
        'effort' => " xx hs. semanales",
        'level_id' => rand(1,5),
        'user_instructor_id' => rand(3,10),
        'certificate' => "Si",
        'title_certificate' => 'Sert. del '.$title,
        'discount_uno'=> 0,
        'discount_dos'=> 0,
        'discount_tres'=> 0,
        'description' => $faker->paragraph($nbSentences = 4, $variableNbSentences = false),
        
        'requirements' => 'Requisito muestra '. $faker->paragraph($nbSentences = 2, $variableNbSentences = false),
        'slug' => Str::slug($title),
        'price' => rand(12000, 26500),
        'currency_id' => 2,
        'status_id' => $faker->randomElement([1,3])
    ];
});
