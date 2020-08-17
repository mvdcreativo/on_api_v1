<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new App\Models\Role;
        $role->name = "Docente";
        $role->description = "";
        $role->save();

        $role = new App\Models\Role;
        $role->name = "Alumno";
        $role->description = "";
        $role->save();

        $role = new App\Models\Role;
        $role->name = "Admin";
        $role->description = "";
        $role->save();
    }
}
