<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @version August 11, 2020, 7:38 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $courses
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $ico
 */
class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description',
        'image',
        'ico',
        'slug',
        'color'
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
        'image' => 'string',
        'ico' => 'string',
        'slug' => 'string',
        'color' => 'string'
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
    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class, 'category_course_pivot');
    }


    ////SCOPES
    
    public function scopeFilter_status($query)
    {
        return $query->with(['courses' => function($q) {
            $q->whereIn('status_id', [1,3]);
        }]);
    }
}
