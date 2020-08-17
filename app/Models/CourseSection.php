<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CourseSection
 * @package App\Models
 * @version August 11, 2020, 5:12 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $lessons
 * @property \Illuminate\Database\Eloquent\Collection $courses
 * @property \App\Models\Status $status
 * @property string $title
 * @property string $init_date
 * @property string $description
 * @property string $slug
 */
class CourseSection extends Model
{
    use SoftDeletes;

    public $table = 'course_sections';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'init_date',
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
        'title' => 'string',
        'init_date' => 'string',
        'slug' => 'string',
        'status_id' => 'integer'
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
    public function lessons()
    {
        return $this->hasMany(\App\Models\Lesson::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class, 'course_section_course_pivot');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class);
    }
}
