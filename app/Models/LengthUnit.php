<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class LengthUnit
 * @package App\Models
 * @version August 11, 2020, 4:58 pm UTC
 *
 * @property \App\Models\LengthUnit $lengthUnit
 * @property \Illuminate\Database\Eloquent\Collection $lengthUnit1s
 * @property \Illuminate\Database\Eloquent\Collection $courses
 * @property string $name
 * @property number $value
 * @property integer $length_unit_id
 */
class LengthUnit extends Model
{
    use SoftDeletes;

    public $table = 'length_units';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'value',
        'length_unit_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'value' => 'float',
        'length_unit_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function lengthUnit()
    {
        return $this->belongsTo(\App\Models\LengthUnit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function lengthUnit1s()
    {
        return $this->hasMany(\App\Models\LengthUnit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class);
    }
}
