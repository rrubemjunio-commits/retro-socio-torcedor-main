<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ReservaIngresso extends Model
{
    protected $table = 'reservas_ingressos';

    protected $fillable = [
        'user_id',
        'adversario',
        'data_jogo',
        'horario',
        'estadio',
        'tipo',
        'quantidade',
        'valor_unitario',
        'valor_total',
    ];

    protected function casts(): array
    {
        return [
            'data_jogo' => 'date',
            'valor_unitario' => 'decimal:2',
            'valor_total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
