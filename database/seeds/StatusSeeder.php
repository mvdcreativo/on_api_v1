<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "Activo";
        $status = new App\Models\Status;
        $status->name = $name;
        $status->slug = Str::slug($name);
        $status->for = "CURSOS";
        $status->save();

        $name = "Inactivo";
        $status = new App\Models\Status;
        $status->name = $name;
        $status->slug = Str::slug($name);
        $status->for = "CURSOS";
        $status->save();

        $name = "Destacado";
        $status = new App\Models\Status;
        $status->name = $name;
        $status->slug = Str::slug($name);
        $status->for = "CURSOS";
        $status->save();
    }
}
