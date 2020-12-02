<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = "Montevideo";
        $state = new App\Models\State;
        $state->name = $name;
        $state->slug = Str::slug($name);
        $state->code = "-34.90328,-56.18816";
        $state->save();

        $name = "Canelones";
        $state = new App\Models\State;
        $state->name = $name;
        $state->slug = Str::slug($name);
        $state->code = "-34.529101692617054,-56.28554445341188";
        $state->save();
    }
}
