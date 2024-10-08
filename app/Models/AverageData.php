<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageData extends Model
{
    use HasFactory;

    public function devices(){
        return $this->belongsTo('App\Models\Devices');
    }
}
