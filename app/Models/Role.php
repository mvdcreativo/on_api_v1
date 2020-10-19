<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role
 * @package App\Models
 * @version August 11, 2020, 4:33 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $permissions
 * @property string $name
 * @property string $description
 */
class Role extends Model
{
    use SoftDeletes;

    public $table = 'roles';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
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
    public function permissions()
    {
        return $this->belongsToMany(\App\Models\Permission::class, 'permission_role_pivot');
    }


    public function accounts()
    {
        return $this->hasMany(\App\Models\Account::class);
    }


}
