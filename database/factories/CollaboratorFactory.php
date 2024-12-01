<?php

namespace Database\Factories;

use App\Models\Collaborator;
use Illuminate\Database\Eloquent\Factories\Factory;

class CollaboratorFactory extends Factory
{
    protected $model = Collaborator::class;

    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'), // Senha criptografada
            'telephone' => $this->faker->phoneNumber,
            'cpf' => $this->faker->unique()->numerify('###.###.###-##'),
            'rg' => $this->faker->unique()->numerify('##.###.###-#'),
            'status' => 2, // Supondo que o status possa ser 1 ou 2
            'perfil' => 'admin',
        ];
    }
}
