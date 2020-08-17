<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course
 * @package App\Models
 * @version August 11, 2020, 9:26 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $categories
 * @property \App\Models\LengthUnit $lengthUnit
 * @property \App\Models\Level $level
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $adquiredSkills
 * @property \Illuminate\Database\Eloquent\Collection $courseSections
 * @property string $title
 * @property integer $cupos
 * @property string $image
 * @property string $schedule
 * @property integer $length
 * @property string $effort
 * @property integer $level_id
 * @property integer $user_instructor_id
 * @property string $certificate
 * @property string $discount_uno
 * @property string $discount_dos
 * @property string $discount_tres
 * @property string $title_certificate
 * @property string $description
 * @property integer $requirements
 */
class Course extends Model
{
    use SoftDeletes;

    public $table = 'courses';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'cupos',
        'image',
        'length',
        'effort',
        'level_id',
        'user_instructor_id',
        'certificate',
        'discount_uno',
        'discount_dos',
        'discount_tres',
        'title_certificate',
        'description',
        'requirements',
        'slug',
        'price',
        'currency_id',
        'date_ini',
        'status_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'cupos' => 'integer',
        'image' => 'string',
        'length' => 'integer',
        'length_unit_id' => 'integer',
        'effort' => 'string',
        'level_id' => 'integer',
        'user_instructor_id' => 'integer',
        'certificate' => 'string',
        'discount_uno' => 'string',
        'discount_dos' => 'string',
        'discount_tres' => 'string',
        'title_certificate' => 'string',
        'description' => 'string',
        'requirements' => 'string',
        'slug' => 'string',
        'currency_id' =>'integer',
        'date_ini' => 'string',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class, 'category_course_pivot');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function lengthUnit()
    {
        return $this->belongsTo(\App\Models\LengthUnit::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function level()
    {
        return $this->belongsTo(\App\Models\Level::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user_instructor()
    {
        return $this->belongsTo(\App\User::class)->with('account');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function adquiredSkills()
    {
        return $this->hasMany(\App\Models\AdquiredSkill::class);
    }

        /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function schedules()
    {
        return $this->hasMany(\App\Models\Schedule::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function courseSections()
    {
        return $this->belongsToMany(\App\Models\CourseSection::class, 'course_section_course_pivot')->with('lessons');
    }


    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }

    public function alumnos()
    {
        return $this->belongsToMany('App\User', 'course_user_pivot');
    }


}
