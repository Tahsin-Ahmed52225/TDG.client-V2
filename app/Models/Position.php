<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'position';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title'
    ];

     /**
     * @return BelongsTo
     * @ role beglongs to a user
     */
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
