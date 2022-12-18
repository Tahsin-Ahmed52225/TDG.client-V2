<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    protected $table = 'project_file';

    protected $fillable = [
        'description','file_path','project_id','user_id'
    ];

    public function project(){
        return $this->belongsTo(Project::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}


