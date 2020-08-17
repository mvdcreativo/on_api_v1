<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Schedule;
use Faker\Generator as Faker;

$factory->define(Schedule::class, function (Faker $faker) {
    return [
        
        'day' => $faker->randomElement(['Lunes','Martes','Miércoles','Jueves','Viernes']),
        'h_ini' => '19:30',
        'h_end' => '22:00',
        'course_id' => rand(1,50),
    ];
});
