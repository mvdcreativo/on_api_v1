<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Neurony\Duplicate\Options\DuplicateOptions;
use Neurony\Duplicate\Traits\HasDuplicates;


class Course extends Model
{
    use SoftDeletes, HasDuplicates;

    

    public $table = 'courses';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'title',
        'cupos',
        'cupos_confirmed',
        'image',
        'thumbnail',
        'length',
        'length_unit_id',
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
        'status_id',
        'original_id',
        'group'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'original_id' => 'string',
        'cupos' => 'integer',
        'cupos_confirmed' => 'integer',
        'group' => 'integer',
        'image' => 'string',
        'thumbnail'=> 'string',
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
        return $this->belongsToMany(\App\Models\Category::class, 'category_course_pivot')->with('courses');
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
        return $this->belongsToMany(\App\Models\CourseSection::class, 'course_section_course_pivot')->with('lessons')->orderBy('position');
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

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    /////////////////////////////
        ///SCOPES
    /////////////////////////////

    public function scopeFilter($query, $filter)
    {
        if($filter)

            return $query
                ->where('id', $filter)
                ->orWhere('title', "LIKE", '%'.$filter.'%');

    }

    public function scopeStatus($query, $filter)
    {
        if($filter){
            $filters = json_decode($filter);
            $query->whereIn('status_id', $filters);
        }

        return $query;
    }



    public function getDuplicateOptions(): DuplicateOptions
    {
        return DuplicateOptions::instance()->excludeRelations('orders', 'alumnos');
    }
}
