<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = "Presentación";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->status_id = 1;
        $course_section->position = 1;
        $course_section->save();

        $title = "Introducción";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->position = 2;
        $course_section->save();

        $title = "Tema Cualquiera 1";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->position = 3;
        $course_section->save();

        $title = "Tema Cualquiera 2";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->position = 4;
        $course_section->save();

        $title = "Tema Cualquiera 3";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->position = 5;
        $course_section->save();

        $title = "Tema Cualquiera 4";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->position = 6;
        $course_section->save();

        $title = "Tema Cualquiera 5";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->position = 7;
        $course_section->save();

        $title = "Tema Cualquiera 6";
        $course_section = new App\Models\CourseSection;
        $course_section->title = $title;
        $course_section->slug = Str::slug($title);
        $course_section->init_date = "2020-08-12T00:37:28.000000Z";
        $course_section->status_id = 1;
        $course_section->position = 8;
        $course_section->save();

    }
}
