<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAssigns extends Model
{
    protected $table = 'project_user_assign';
    protected $fillable =['project_id','user_id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
