<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDevice extends Model
{
    use HasFactory;

    public function devices(){
        return $this->belongsTo('App\Models\Devices');
    }

    public function avaregeData(){
        return $this->belongsTo('App\Models\AvaregeData');
    }
}
