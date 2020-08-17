<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class AdquiredSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\AdquiredSkill::class, 400)->create();
    }
}
