<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "Total";
        $permission = new App\Models\Permission;
        $permission->name = $name;
        $permission->slug = Str::slug($name);
        $permission->description = "";
        $permission->save();
    }
}
