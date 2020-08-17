<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Level
 * @package App\Models
 * @version August 11, 2020, 4:59 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $courses
 * @property string $name
 * @property string $description
 */
class Level extends Model
{
    use SoftDeletes;

    public $table = 'levels';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
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
        'description' => 'string',
        'slug'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function courses()
    {
        return $this->hasMany(\App\Models\Course::class);
    }
}
