<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collaborator extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'collaborators';

    // Campos preenchíveis para criação/atualização em massa
    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'status',
    ];

    // Campos ocultos na serialização (por exemplo, JSON retornado em APIs)
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * Verifica se o colaborador é um administrador.
     */
    public function isAdmin()
    {
        return $this->perfil === 'admin';
    }
}
