<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Order extends Model
{
    use SoftDeletes;

    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'id',
        'user_id',
        'total',
        'talon_cobro',
        'url_pdf',
        'payment_method_id',
        'status_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'talon_cobro'=> 'string',
        'url_pdf' => 'string',
        'payment_method_id' => 'integer',
        'status_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];



    public function courses()
    {
        return $this->belongsToMany('App\Models\Course');
    }
    public function lessons()
    {
        return $this->belongsToMany('App\Models\Lesson');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
