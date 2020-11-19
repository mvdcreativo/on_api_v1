<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Account extends Model
{
    use SoftDeletes;

    public $table = 'accounts';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'bio',
        'slug',
        'certificated',
        'rating_up',
        'rating_down',
        'n_identification',
        'phone_one',
        'phone_two',
        'address_one',
        'address_two',
        'image',
        'birth',
        'role_id',
        'n_doc_iden',
        'type_doc_iden'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'bio' => 'string',
        'slug' => 'string',
        'certificated' => 'string',
        'rating_up' => 'integer',
        'rating_down' => 'integer',
        'n_identification' => 'string',
        'last_name' => 'string',
        'phone_one' => 'string',
        'phone_two' => 'integer',
        'address_one' => 'string',
        'address_two' => 'string',
        'image' => 'string',
        'role_id' => 'integer',
        'birth' => 'string',
        'type_doc_iden' =>'string',
        'n_doc_iden' =>'string',
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];



    ///RELATIONSHIP

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class, 'course_user_pivot');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class);
        
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function reviews_referred()
    {
        return $this->hasMany(\App\Models\Review::class, 'user_referred_id');
        
    }

    /**
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    **/
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }


    /////////////////////////////
        ///SCOPES
    /////////////////////////////

    public function scopeFilter($query, $filter)
    {
        if($filter)

            return $query;
                // ->with('user')
                // ->orWhere('user.name', "LIKE", '%'.$filter.'%')
                // ->orWhere('user.email', "LIKE", '%'.$filter.'%');


    }

    
}
