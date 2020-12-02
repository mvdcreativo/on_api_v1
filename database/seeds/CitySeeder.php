<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "Ciudad de la Costa";
        $city = new App\Models\City;
        $city->name = $name;
        $city->slug = Str::slug($name);
        $city->code = "-34.81563698724985, -55.92946224506635";
        $city->state_id = 2;
        $city->save();

        $name = "Montevideo";
        $city = new App\Models\City;
        $city->name = $name;
        $city->slug = Str::slug($name);
        $city->code = "-34.90328,-56.18816";
        $city->state_id = 1;
        $city->save();

    }
}
