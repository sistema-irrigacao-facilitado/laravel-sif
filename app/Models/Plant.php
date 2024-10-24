<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'ip',
        // 'model',
        // 'numbering',
        // 'qr',
        // 'mode',
        // 'time_on',
        // 'status',
        // 'user_id',
    ];

    public function collaborators(){
        return $this->belongsTo('App\Models\Collaborator');
    }

    public function device(){
        return $this->belongsTo('App\Models\Device');
    }
}
