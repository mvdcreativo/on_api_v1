<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        factory(App\Models\Course::class, 50)->create()->each(
            function(App\Models\Course $course ) use ($faker){
                $course->courseSections()->attach(
                    [
                        1,
                        2,
                        rand(3,5),
                        rand(6,8)
                    ]
                );

                $course->categories()->attach(
                    $faker->randomElement([
                        [rand(1,3),rand(4,6)],

                        [rand(1,6)]
                    ])
                );
                
            }
        );

    }
}
