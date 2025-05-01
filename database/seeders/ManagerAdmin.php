<?php

namespace Database\Seeders;

use App\Models\Collaborator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Collaborator::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'), 
            'telephone' => '11999999999',
            'cpf' => '00000000000',
            'rg' => '000000000',
            'status' => '1',
            'perfil' => 'admin',
            'collaborators_inclusion_id' => null,
            'collaborators_change_id' => null,
            'collaborators_exclusion_id' => null,
        ]);
    }
}
