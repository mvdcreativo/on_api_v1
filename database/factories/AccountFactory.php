<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'user_id' => "",
        'bio' => $faker->paragraph($nbSentences = 4, $variableNbSentences = false),
        'certificated' => $faker->randomElement(['Diseñador Gráfico','Contador', 'Matemtico', 'Arquitecto', 'Ingeniero' ]),
        'rating_up' => rand(100,800),
        'rating_down' => rand(1,100),
        'n_doc_iden' => rand(10000000, 40000000),
        'type_doc_iden' => "CI",
        'n_identification' => rand(10000000, 40000000),
        'phone_one' => 123456,
        'phone_two' => '099123456',
        'address_one' => $faker->address,
        'address_two' => null,
        'image' => asset("storage/images/users")."/".rand(1,30).".jpeg",
        'role_id' => 1,
        'birth' => $faker->dateTime($max = 'now'),
        'neighborhood_id' => rand(1,8)
    ];
});
