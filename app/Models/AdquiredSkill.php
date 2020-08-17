<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AdquiredSkill
 * @package App\Models
 * @version August 11, 2020, 6:58 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $courses
 * @property string $title
 * @property string $slug
 */
class AdquiredSkill extends Model
{
    use SoftDeletes;

    public $table = 'adquired_skills';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'slug',
        'course_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'course_id'=> 'integer'
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
    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class);
    }

}
