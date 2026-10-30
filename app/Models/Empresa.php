<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'razao_social',
        'cnpj',
        'slug',
        'descricao',
        'whatsapp',
        'email',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'logo',
        'banner',
        'cor_primaria',
        'ativo',
        'aberto',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
            'aberto' => 'boolean',
        ];
    }

    // Gera um slug exclusivo para identificar a empresa.
    protected static function booted(): void
    {
        static::creating(function (Empresa $empresa) {
            if (empty($empresa->slug)) {
                $base = Str::slug($empresa->nome);
                $slug = $base;
                $i = 2;

                while (static::withTrashed()->where('slug', $slug)->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }

                $empresa->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function categorias(): HasMany
    {
        return $this->hasMany(Categoria::class);
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class);
    }
}
