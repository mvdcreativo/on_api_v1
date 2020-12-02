<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class NeighborhoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "Solymar";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 1;
        $neighborhood->save();

        $name = "Lagomar";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 1;
        $neighborhood->save();

        $name = "Medanos de Solymar";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 1;
        $neighborhood->save();

        $name = "Cordón";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 2;
        $neighborhood->save();

        $name = "Buceo";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 2;
        $neighborhood->save();

        $name = "Carrasco";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 2;
        $neighborhood->save();

        $name = "Malvín";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 2;
        $neighborhood->save();
        
        $name = "Malvín Norte";
        $neighborhood = new App\Models\Neighborhood;
        $neighborhood->name = $name;
        $neighborhood->slug = Str::slug($name);
        $neighborhood->code = "";
        $neighborhood->city_id = 2;
        $neighborhood->save();
    }
}
