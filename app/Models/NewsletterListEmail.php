<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterListEmail extends Model
{
    //
    public $fillable = [
        'email',

    ];
    public static $rules = [
        'email' => 'required',
    ];
}
