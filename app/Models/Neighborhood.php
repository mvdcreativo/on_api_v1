<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Neighborhood extends Model
{
    use SoftDeletes;

    public $table = 'neighborhoods';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'code',
        'city_id',
        'slug'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'code' => 'string',
        'city_id' => 'integer',
        'slug' => 'string',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'city_id' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class)->with('state');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function accounts()
    {
        return $this->hasMany(\App\Models\Account::class);
        
    }



    /////////////////////////////
        ///SCOPES
    /////////////////////////////

    public function scopeFilter($query, $filter)
    {
        if($filter)
            return $query
                ->orWhere('name', "LIKE", '%'.$filter.'%')
                ->orWhere('code', "LIKE", '%'.$filter.'%')
                ->orWhere('id', "LIKE", '%'.$filter.'%');
    }
}
