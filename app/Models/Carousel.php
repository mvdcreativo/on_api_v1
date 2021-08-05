<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    //
    protected $fillable = [
        'name', 'platform','status'
    ];

    public function images()
    {
        return $this->belongsToMany('App\Models\Image');
    }
}
