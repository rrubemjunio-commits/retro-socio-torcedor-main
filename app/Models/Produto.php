<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produto extends Model
{
    use SoftDeletes;

    protected $table = 'produtos';

    protected $fillable = [
        'categoria_id',
        'empresa_id',
        'nome',
        'descricao',
        'valor',
        'imagem',
        'destaque',
        'disponivel',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'destaque' => 'boolean',
            'disponivel' => 'boolean',
        ];
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}
