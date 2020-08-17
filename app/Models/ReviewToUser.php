<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ReviewToUser
 * @package App\Models
 * @version August 16, 2020, 3:01 pm UTC
 *
 * @property \App\Models\User $user
 * @property \App\Models\User $user1
 * @property string $review
 * @property integer $user_id
 * @property integer $user_referred_id
 * @property integer $rate
 */
class ReviewToUser extends Model
{
    use SoftDeletes;

    public $table = 'review_to_users';
    

    protected $dates = ['deleted_at'];



    public $fillable = [
        'review',
        'user_id',
        'user_referred_id',
        'rate'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'review'=> 'string',
        'user_id' => 'integer',
        'user_referred_id' => 'integer',
        'rate' => 'integer'
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user_referred()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
