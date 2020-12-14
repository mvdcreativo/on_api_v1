<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    // use SoftDeletes;

    use HasApiTokens,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','slug','last_name','social_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    ///RELATIONSHIP


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function account()
    {
        return $this->hasOne(\App\Models\Account::class)->with("neighborhood","neighborhood.city");
    }


    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }


    public function courses()
    {
        return $this->belongsToMany('App\Models\Course', 'course_order')
        ->using(\App\Models\CourseOrderPivot::class)
        ->withPivot('price', 'currency_id', 'course_id', 'quantity','order_id','user_id');
    }

    public function courses_instructor()
    {
        return $this->hasMany(\App\Models\Course::class, 'user_instructor_id')->with('categories');

    }

    /////////////////////////////
        ///SCOPES
    /////////////////////////////

    public function scopeFilter($query, $filter)
    {
        if($filter)

            return $query
                ->whereHas('account', function(Builder $q) use ($filter){
                    $q->where('n_doc_iden', $filter)
                    ->orWhere('phone_one', "LIKE", '%'.$filter.'%')
                    ->orWhere('phone_two', "LIKE", '%'.$filter.'%');
                })
                ->orWhere('name', "LIKE", '%'.$filter.'%')
                ->orWhere('email', "LIKE", '%'.$filter.'%');


    }

    
}
