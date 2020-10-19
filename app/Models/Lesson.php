<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Lesson
 * @package App\Models
 * @version August 11, 2020, 5:18 pm UTC
 *
 * @property \App\Models\CourseSection $courseSection
 * @property string $name
 * @property string $description
 * @property integer $course_section_id
 * @property string $slug
 */
class Lesson extends Model
{
    use SoftDeletes;

    public $table = 'lessons';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'course_section_id',
        'slug',
        'price',
        'video',
        'duration',
        'currency_id',
        'position'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'course_section_id' => 'integer',
        'slug' => 'string',
        'position' => 'integer'
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
    public function courseSection()
    {
        return $this->belongsTo(\App\Models\CourseSection::class);
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Orders');
    }
}
