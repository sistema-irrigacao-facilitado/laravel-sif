<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AverageData extends Model
{
    use HasFactory;

    protected $casts = [
        'humidity' => 'array',
        'temperature' => 'array',
        'data' => 'array',
    ];

    protected $fillable = [
        'device_id',
        'humidity',
        'temperature',
        'data',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function addHumidityData($humidity)
    {
        $this->humidity = array_merge($this->humidity ?? [], [$humidity]);
    }

    public function addTemperatureData($temperature)
    {
        $this->temperature = array_merge($this->temperature ?? [], [$temperature]);
    }

    public function addDate($date)
    {
        $this->data = array_merge($this->data ?? [], [$date]);
    }

    public function calculateAverageHumidity()
    {
        return (is_array($this->humidity) && count($this->humidity) > 0)
            ? array_sum($this->humidity) / count($this->humidity)
            : 0;
    }

    public function calculateAverageTemperature()
    {
        return (is_array($this->temperature) && count($this->temperature) > 0)
            ? array_sum($this->temperature) / count($this->temperature)
            : 0;
    }

    public function calculateTotalLiters()
    {
        return (is_array($this->liters) && count($this->liters) > 0)
            ? array_sum($this->liters)
            : 0;
    }
}
