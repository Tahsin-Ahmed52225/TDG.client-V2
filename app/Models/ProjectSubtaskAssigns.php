<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectSubtaskAssigns extends Model
{
    protected $table = 'project_subtask_user_assign';
    protected $fillable =['project_subtask_id','user_id'];

    public function ProjectSubtask(){
        return $this->belongsTo(ProjectSubtask::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
