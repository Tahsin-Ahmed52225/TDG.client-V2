<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Role;

class Permisson extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'route_name',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
