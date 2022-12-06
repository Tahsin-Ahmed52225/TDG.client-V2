<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

# Custom Models
use App\Models\User;

class Role extends Model
{
    protected $table = 'role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug'
    ];

     /**
     * @return BelongsTo
     * @ role beglongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
