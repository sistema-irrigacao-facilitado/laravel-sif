<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
       'common_name',
       'scientific_name',
       'water_need',
       'soil_type',
       'humidity_tolerance',
       'temperature_tolerance',
       'image',
       'status',
       'obs'
    ];
}
