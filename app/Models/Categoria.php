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

    protected $fillable = [
        'empresa_id',
        'nome',
        'icone',
    ];

    public function getIconeBootstrapAttribute(): string
    {
        return preg_match('/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/', (string) $this->icone) === 1
            ? $this->icone
            : 'tag-fill';
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
