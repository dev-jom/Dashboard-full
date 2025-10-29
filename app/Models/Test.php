<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    protected $fillable = [
        'tipo_teste',
        'numero_ticket',
        'resumo_tarefa',
        'estrutura',
        'atribuido_a',
        'resultado',
        'data_teste',
        'link_tarefa',
        'sprint',
    ];

    protected $casts = [
        'data_teste' => 'date',
    ];
}
