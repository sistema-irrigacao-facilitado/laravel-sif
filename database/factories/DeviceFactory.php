<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use App\Models\Collaborator;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition()
    {
        return [
            'model' => $this->faker->word,
            'numbering' => $this->faker->unique()->numerify('######'),
            'mode' => $this->faker->randomElement([1, 2]), // 1 ou 2
            'time_on' => json_encode([
                $this->faker->time,
                $this->faker->time,
                $this->faker->time,
            ]), // Array JSON com tempos
            'period' => $this->faker->numberBetween(0, 59) . ':' . $this->faker->numberBetween(0, 59),
            'status' => 2,
            'user_id' => User::factory(), // Vincula a um usuário
            'collaborators_inclusion_id' => Collaborator::factory(),
        ];
    }
}
