<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios'; // nome da sua tabela

    protected $fillable = ['nome', 'email', 'senha'];

    public $timestamps = false; // se sua tabela não tiver created_at/updated_at
}