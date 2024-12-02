<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'model',
        'numbering',
        'qr',
        'mode',
        'time_on',
        'period',
        'status',
        'update_status',
        'user_id',
    ];

    public function collaborators(){
        return $this->belongsTo('App\Models\Collaborator');
    }

    public function plant(){
        return $this->belongsTo('App\Models\Plant');
    }

    public function pump(){
        return $this->belongsTo('App\Models\Pump');
    }

    public function users(){
        return $this->belongsTo('App\Models\Users');
    }

    public function dataDevice(){
        return $this->hasMany('App\Models\DataDevice');
    }

    public function avaregeData(){
        return $this->hasMany('App\Models\AvaregeData');
    }

    public function updateIoT($device)
{
    $plant = Plant::where('device_id', $device->id)->first();
    $pump = Pump::where('device_id', $device->id)->first();

    $dados = [
        "mode" => $device->mode,
        "time_on" => $device->time_on,
        "period" => $device->period,
        "humidity" => $plant->humidity_tolerance ?? null,
        "temperature" => $plant->temperature_tolerance ?? null,
        "flow" => $pump->flow ?? null,
    ];

    $json = json_encode($dados);
    if ($json === false) {
        return json_last_error_msg();
    }

    return $json;
}
}
