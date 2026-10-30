<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    protected $table = 'socios';

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
        'email',
        'data_nascimento',
        'plano',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento' => 'date',
        ];
    }
}
