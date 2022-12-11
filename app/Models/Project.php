<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $fillable = [
        'title', 'created_by', 'client_id','manager_id','due_date','status','priority','description','type','budget'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    public function memebers(){
        return $this->hasMany(ProjectAssigns::class, 'project_id');
    }
    public function subtasks(){
        return $this->hasMany(ProjectSubtask::class, 'project_id');
    }
}
