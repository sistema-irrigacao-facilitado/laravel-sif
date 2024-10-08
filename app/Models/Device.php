<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    public function collaborators(){
        return $this->belongsTo('App\Models\Collaborator');
    }

    public function plants(){
        return $this->belongsTo('App\Models\Plants');
    }

    public function pumps(){
        return $this->belongsTo('App\Models\Pumps');
    }

    public function users(){
        return $this->belongsTo('App\Models\Users');
    }

    public function dataDevices(){
        return $this->belongsTo('App\Models\DataDevices');
    }

    public function avaregeData(){
        return $this->belongsTo('App\Models\AvaregeData');
    }
}
