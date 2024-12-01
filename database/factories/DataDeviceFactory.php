<?php

namespace Database\Factories;

use App\Models\DataDevice;
use App\Models\Device;
use App\Models\AverageData;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataDeviceFactory extends Factory
{
    protected $model = DataDevice::class;

    public function definition(): array
    {
        return [
            'humidity' => $this->faker->randomFloat(2, 0, 100), // Valores entre 0 e 100
            'temperature' => $this->faker->randomFloat(2, -10, 50), // Valores entre -10 e 50 graus
            'liters_pump' => $this->faker->randomFloat(2, 0, 10), // Valores entre 0 e 10 litros
            'device_id' => 1, // Cria um Device associado
            'average_data_id' => 1, // Cria um AverageData associado (ou null)
        ];
    }
}
