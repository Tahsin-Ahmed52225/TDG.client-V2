<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';
    protected $fillable = [
        'title', 'created_by','due_date','status','priority','description','type','order'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
    public function ProjectAssigns(){
        return $this->hasMany(ProjectAssigns::class, 'project_id');
    }
    public function subtasks(){
        return $this->hasMany(ProjectSubtask::class, 'project_id');
    }
    public function files(){
        return $this->hasMany(ProjectFiles::class, 'project_id');
    }
}
