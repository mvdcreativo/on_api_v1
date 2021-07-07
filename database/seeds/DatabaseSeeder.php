<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(NeighborhoodSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(LengthSeeder::class);
        $this->call(CourseSectionSeeder::class);
        $this->call(LessonSeeder::class);
        $this->call(LevelSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(AdquiredSkillSeeder::class);
    }
}
