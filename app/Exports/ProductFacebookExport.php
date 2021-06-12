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
        return Course::with('categories')->whereIn('status_id', [1,3])->get();
    }

 
    public function map($product): array
    {
        if($product->description){
            $description = $product->description;
        }else{
            $description = $product->title;
        }
        if($product->brand && $product->brand->name ){
            $brand = "oncapacitaciones";
        }else{
            $product->delete();
            $brand = "sin-marca";
        }

        if( $product->categories && $product->categories[0]->name){
            $categories = $product->categories[0]->name;
        }else{
            $product->delete();
            $categories = "sin-categoria";
        }

        return [
            $product->id,
            trim(ucwords(strtolower( "\"".$product->name."\""))),
            trim(ucfirst(strtolower(str_replace("\r\n", " ", "\"".$description."\"")))),
            "in stock" ,
            "new",
            $product->price."UYU",
            "https://www.oncapacitaciones.com/cursos/curso/".$product->slug ,
            "https://api.oncapacitaciones.com/storage/images/courses/larg/".$product->image,
            trim(ucwords(strtolower("oncapacitaciones"))),
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            trim(ucwords(strtolower($categories))),
            $product->price,
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
    //     $products = Product::with('brand','category');

    //     if($products){

    //         $result = Array();
            
    //         foreach ($products as $product) {
                
    //             $result[]= [
    //                 'id' => $product->id,
    //                 'title' => $product->name ,
    //                 'description' => $product->description ,
    //                 'availability' => "in stock" ,
    //                 'condition' => "new",
    //                 'price' => $product->price,
    //                 'link' => "https://nuevaerauruguay.com/producto/".$product->slug ,
    //                 'image_link' => "https://api.nuevaerauruguay.com/storage/images/productos/".$product->slug,
    //                 'brand' => $product->brand->name ,
    //                 'additional_image_link' => null ,
    //                 'color' => null ,
    //                 'gender' => null ,
    //                 'item_group_id' => null ,
    //                 'google_product_category'  => null ,
    //                 'pattern' => null ,
    //                 'product_type' => $product->category->name ,
    //                 'sale_price' => $product->price ,
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
