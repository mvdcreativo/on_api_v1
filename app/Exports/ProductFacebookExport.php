<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;



class ProductFacebookExport implements WithMapping, WithHeadings, FromCollection
{



    public function collection()
    {
        $query = Course::query();
        $courses = $query
            ->with('categories')
            ->whereIn('status_id', [1,3])
            ->get();
        return $courses;
    }

 
    public function map($course): array
    {
        if($course->description){
            $description = $course->description;
        }else{
            $description = $course->title;
        }

        if( $course->categories && $course->categories[0]->name){
            $categories = $course->categories[0]->name;
        }else{
            
            $categories = "sin-categoria";
        }

        return [
            $course->id,
            trim(ucwords(strtolower( "\"".$course->title."\""))),
            trim(ucfirst(strtolower(str_replace("\r\n", " ", "\"".$description."\"")))),
            "in stock" ,
            "new",
            $course->price."UYU",
            "https://www.oncapacitaciones.com/cursos/curso/".$course->slug ,
            $course->image,
            trim(ucwords(strtolower("oncapacitaciones"))),
            null,
            null,
            null,
            null,
            null,
            'School Uniforms',
            null,
            trim(ucwords(strtolower($categories))),
            $course->price,
            null ,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
        ];
    }


    // Headers columnas
    public function headings(): array
    {
        return [
            'id',
            'title',
            'description',
            'availability',
            'condition',
            'price',
            'link',
            'image_link',
            'brand',
            'additional_image_link',
            'age_group',
            'color',
            'gender',
            'item_group_id',
            'google_product_category',
            'pattern',
            'product_type',
            'sale_price',
            'sale_price_effective_date',
            'shipping',
            'shipping_weight',
            'size',
            'custom_label_0',
            'custom_label_1',
            'custom_label_2',
            'custom_label_3',
            'custom_label_4',
        ];
    }




    // public function array(): array
    // {
    //     $courses = course::with('brand','category');

    //     if($courses){

    //         $result = Array();
            
    //         foreach ($courses as $course) {
                
    //             $result[]= [
    //                 'id' => $course->id,
    //                 'title' => $course->name ,
    //                 'description' => $course->description ,
    //                 'availability' => "in stock" ,
    //                 'condition' => "new",
    //                 'price' => $course->price,
    //                 'link' => "https://nuevaerauruguay.com/courseo/".$course->slug ,
    //                 'image_link' => "https://api.nuevaerauruguay.com/storage/images/courseos/".$course->slug,
    //                 'brand' => $course->brand->name ,
    //                 'additional_image_link' => null ,
    //                 'color' => null ,
    //                 'gender' => null ,
    //                 'item_group_id' => null ,
    //                 'google_course_category'  => null ,
    //                 'pattern' => null ,
    //                 'course_type' => $course->category->name ,
    //                 'sale_price' => $course->price ,
    //                 'sale_price_effective_date' => null ,
    //                 'shipping' => "Gratis" ,
    //                 'shipping_weight' => null ,
    //                 'size' => null ,
    //                 'custom_label_0' => null ,
    //                 'custom_label_1' => null ,
    //                 'custom_label_2' => null ,
    //                 'custom_label_3' => null ,
    //                 'custom_label_4' => null ,
    //             ];
    //         }
    //         dd(count($result));
    //         if(count($result) >= 1){

    //             return $result;
    //         }
    //     }   
        
    // }
}
