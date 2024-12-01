<?php

namespace Database\Factories;

use App\Models\AverageData;
use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class AverageDataFactory extends Factory
{
    protected $model = AverageData::class;

    public function definition()
    {
        return [
            'humidity' => json_encode([
                $this->faker->randomFloat(2, 50, 80),
                $this->faker->randomFloat(2, 50, 80),
                $this->faker->randomFloat(2, 50, 80),
            ]),
            'temperature' => json_encode([
                $this->faker->randomFloat(2, 20, 30),
                $this->faker->randomFloat(2, 20, 30),
                $this->faker->randomFloat(2, 20, 30),
            ]),
            'liters' => json_encode([
                $this->faker->randomFloat(2, 1, 5),
                $this->faker->randomFloat(2, 1, 5),
                $this->faker->randomFloat(2, 1, 5),
            ]),
            'data' => json_encode([
                $this->faker->date(),
                $this->faker->date(),
                $this->faker->date(),
            ]),
            'average_humidity' => $this->faker->randomFloat(2, 50, 80),
            'average_temperature' => $this->faker->randomFloat(2, 20, 30),
            'average_liters' => $this->faker->randomFloat(2, 1, 5),
            'device_id' => Device::factory(), // Cria um dispositivo aleatório vinculado
        ];
    }
}

