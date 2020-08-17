<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $name = "Construcción";
        $category = new App\Models\Category;
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->description = "Cursos de construcción y afines";
        $category->image = "https://images.pexels.com/photos/3760529/pexels-photo-3760529.jpeg?auto=compress&cs=tinysrgb&h=350";
        $category->ico = "bx bx-layer";
        $category->color = "#0D47A1";
        $category->save();

        $name = "Audiovisual";
        $category = new App\Models\Category;
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->description = "Cursos de Audiovisuales y afines";
        $category->image = "https://images.pexels.com/photos/3760613/pexels-photo-3760613.jpeg?auto=compress&cs=tinysrgb&h=350";
        $category->ico = "bx bx-camera";
        $category->color = "#E65100";
        $category->save();

        $name = "Electricidad";
        $category = new App\Models\Category;
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->description = "Cursos de Electricidad y afines";
        $category->image = "https://images.pexels.com/photos/3761508/pexels-photo-3761508.jpeg?auto=compress&cs=tinysrgb&h=350";
        $category->ico = "bx bx-git-merge";
        $category->color = "#009688";
        $category->save();

        $name = "Estética";
        $category = new App\Models\Category;
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->description = "Cursos de Estética y afines";
        $category->image = "https://images.pexels.com/photos/3975656/pexels-photo-3975656.jpeg?auto=compress&cs=tinysrgb&h=350";
        $category->ico = "bx bx-group";
        $category->color = "#EC407A";
        $category->save();

        $name = "Salud";
        $category = new App\Models\Category;
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->description = "Cursos de Salud y afines";
        $category->image = "https://images.pexels.com/photos/3760532/pexels-photo-3760532.jpeg?auto=compress&cs=tinysrgb&h=350";
        $category->ico = "bx bx-health";
        $category->color = "#E53935";
        $category->save();

        $name = "Administración";
        $category = new App\Models\Category;
        $category->name = $name;
        $category->slug = Str::slug($name);
        $category->description = "Cursos de Administración y afines";
        $category->image = "https://images.pexels.com/photos/3769135/pexels-photo-3769135.jpeg?auto=compress&cs=tinysrgb&h=350";
        $category->ico = "bx bx-line-chart";
        $category->color = "#00E676";
        $category->save();
    }
}
