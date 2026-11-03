<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use SoftDeletes;

    protected $table = 'categorias';

    public static function iconesBootstrap(): array
    {
        return [
            'tag' => 'Etiqueta',
            'bag' => 'Bolsa',
            'gift' => 'Presente',
            'ticket-perforated' => 'Ingresso',
            'star' => 'Destaque',
            'heart' => 'Coração',
            'collection' => 'Coleção',
        ];
    }

    public function iconeBootstrap(): string
    {
        return array_key_exists($this->icone, self::iconesBootstrap()) ? $this->icone : 'tag';
    }

    protected $fillable = [
        'empresa_id',
        'nome',
        'icone',
    ];

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
