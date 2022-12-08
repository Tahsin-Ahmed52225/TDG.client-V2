<?php

namespace App\Models;

# Custom Model
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = "log";
    protected $fillable = ['log_details','user_id'];

    public function User(){
        return $this->belongsTo(User::class);
    }
}
