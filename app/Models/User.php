<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

# Custom models
use App\Models\Role;
use App\Models\Position;
use App\Models\Log;

class User extends Authenticatable
{
    use Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','position_id','role_id','phone','verification_code','stage'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
    public function log()
    {
        return $this->hasMany(Log::class);
    }
    public function created_project(){
        return $this->hasMany(Project::class);
    }
    public function projects(){
        return $this->hasMany(ProjectAssigns::class);
    }
    public function ProjectSubtaskAssigns(){
        return $this->hasMany(ProjectSubtaskAssigns::class);
    }
    public function files(){
        return $this->hasMany(ProjectFiles::class, 'user_id');
    }
}
