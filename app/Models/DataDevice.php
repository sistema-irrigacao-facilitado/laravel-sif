<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'humidity',
        'temperature',
        'liters_pump',
        'device_id',
        'average_data_id',
    ];

    public function device(){
        return $this->belongsTo('App\Models\Device');
    }

    public function avaregeData(){
        return $this->belongsTo('App\Models\AvaregeData');
    }
}
