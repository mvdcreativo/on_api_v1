<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Currency
 * @package App\Models
 * @version August 11, 2020, 3:33 pm UTC
 *
 * @property string $name
 * @property string $symbol
 * @property number $value
 */
class Currency extends Model
{
    use SoftDeletes;

    public $table = 'currencies';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'symbol',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'symbol' => 'string',
        'value' => 'float'
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
        return $this->hasMany('App\Models\Couses');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
