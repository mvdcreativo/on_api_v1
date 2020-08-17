<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "Introductorio";
        $level = new App\Models\Level;
        $level->name = $name;
        $level->slug = Str::slug($name);
        $level->description = "";
        $level->save();

        $name = "Inicial";
        $level = new App\Models\Level;
        $level->name = $name;
        $level->slug = Str::slug($name);
        $level->description = "";
        $level->save();

        $name = "Medio";
        $level = new App\Models\Level;
        $level->name = $name;
        $level->slug = Str::slug($name);
        $level->description = "";
        $level->save();

        $name = "Avanzado";
        $level = new App\Models\Level;
        $level->name = $name;
        $level->slug = Str::slug($name);
        $level->description = "";
        $level->save();

        $name = "Basico a Avanzado";
        $level = new App\Models\Level;
        $level->name = $name;
        $level->slug = Str::slug($name);
        $level->description = "";
        $level->save();
    }
}
