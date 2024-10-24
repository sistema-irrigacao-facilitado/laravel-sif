<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collaborator extends Model
{
    use HasFactory;

    public function collaborators(){
        return $this->hasMany('App\Models\Collaborator');
    }
    public function pump(){
        return $this->hasMany('App\Models\Pump');
    }
    public function plants(){
        return $this->hasMany('App\Models\Plants');
    }
    public function devices(){
        return $this->hasMany('App\Models\Device');
    }
}
