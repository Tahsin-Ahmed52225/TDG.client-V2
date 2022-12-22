<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubtask extends Model
{
    protected $table = 'project_subtask';
    protected $fillable = ['title','description','priority','due_date','project_id'];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function ProjectSubtaskAssigns(){
        return $this->hasMany(ProjectSubtaskAssigns::class);
    }
}
