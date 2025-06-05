<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => 'teste123@gmail.com',
            'password' => bcrypt('teste123'),
            'telephone' => $this->faker->phoneNumber,
            'status' => 2, 
            'perfil' => 'premium',
        ];
    }
}
