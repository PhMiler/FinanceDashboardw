<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    // Permite atribuição em massa para estes campos:
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Relacionamento: Usuário tem muitas Contas.
     */
    public function contas()
    {
        return $this->hasMany(Conta::class);
    }

    /**
     * Relacionamento: Usuário tem muitas Receitas.
     */
    public function receitas()
    {
        return $this->hasMany(Receita::class);
    }
}
