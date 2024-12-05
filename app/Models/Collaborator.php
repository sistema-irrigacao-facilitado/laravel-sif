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
        'lastname',
        'email',
        'password',
        'telephone',
        'cpf',
        'rg',
        'status',
        'perfil',
        'collaborators_inclusion_id',
        'collaborators_change_id',
        'collaborators_exclusion_id',
    ];

    // Campos ocultos na serialização (por exemplo, JSON retornado em APIs)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relacionamento com o colaborador que incluiu este registro.
     */
    public function inclusionCollaborator()
    {
        return $this->belongsTo(self::class, 'collaborators_inclusion_id');
    }

    /**
     * Relacionamento com o colaborador que alterou este registro.
     */
    public function changeCollaborator()
    {
        return $this->belongsTo(self::class, 'collaborators_change_id');
    }

    /**
     * Relacionamento com o colaborador que excluiu este registro.
     */
    public function exclusionCollaborator()
    {
        return $this->belongsTo(self::class, 'collaborators_exclusion_id');
    }

    /**
     * Verifica se o colaborador é um administrador.
     */
    public function isAdmin()
    {
        return $this->perfil === 'admin';
    }

    public function collaborators()
    {
        return $this->hasMany('App\Models\Collaborator');
    }
    public function pump()
    {
        return $this->hasMany('App\Models\Pump');
    }
    public function plants()
    {
        return $this->hasMany('App\Models\Plants');
    }
    public function devices()
    {
        return $this->hasMany('App\Models\Device');
    }
}
