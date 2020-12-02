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
        'payment_method_id',
        'status_id',
        'payment_metod_mp',
        'order_id_mp',
        'order_status_mp',
        'status_mp',
        'cancelled_mp',
        'name',
        'last_name',
        'email',
        'phone_one',
        'address_one',
        'n_doc_iden',
        'type_doc_iden',
        'currency_id'


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
        'payment_method_id' => 'integer',
        'status_id' => 'integer',
        'payment_metod_mp' => 'string',
        'order_id_mp' => 'string',
        'order_status_mp'=> 'string',
        'cancelled_mp' => 'string',
        'status_mp' => 'string',
        'name'=> 'string',
        'last_name'=> 'string',
        'email'=> 'string',
        'phone_one'=> 'string',
        'address_one'=> 'string',
        'n_doc_iden'=> 'string',
        'type_doc_iden'=> 'string',
        'currency_id' => 'integer',
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
        return $this->belongsToMany('App\Models\Course')
        ->using(\App\Models\CourseOrderPivot::class)
        ->withPivot('price', 'currency_id', 'course_id', 'quantity','order_id','user_id');
    }
    public function lessons()
    {
        return $this->belongsToMany('App\Models\Lesson');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }



    /////////////////////////////
        ///SCOPES
    /////////////////////////////

    public function scopeFilter($query, $filter)
    {
        if($filter)

            return $query
                ->where('id',$filter)
                ->orWhere('total',$filter)
                ->orWhere('name', "LIKE", '%'.$filter.'%')
                ->orWhere('last_name', "LIKE", '%'.$filter.'%')
                ->orWhere('email', "LIKE", '%'.$filter.'%')
                ->orWhere('n_doc_iden', "LIKE", '%'.$filter.'%')
                ->orWhere('user_id',$filter)
                ->orWhere('order_id_mp',$filter);
    }

    public function scopeUser($query, $user_id)
    {
        if($user_id)

            return $query
                ->where('user_id',$user_id);

    }



}
