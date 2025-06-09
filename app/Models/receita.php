<?php // Início do arquivo PHP

namespace App\Models; // Namespace deste arquivo (organização de código)

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importação de classes/recursos do Laravel
use Illuminate\Database\Eloquent\Model; // Importação de classes/recursos do Laravel

class Receita extends Model // Definição da classe principal do model Receita
{
    use HasFactory; // Importação de classes/recursos do Laravel

    protected $fillable = [ // Define os atributos que podem ser preenchidos em massa (mass assignment)
        'user_id',
        'descricao',
        'valor',
        'data_recebimento'
    ];

    // Relacionamento com usuário
    public function user() // Declaração de método de relacionamento no model
    {
        return $this->belongsTo(User::class);
    }
}
