@extends('layouts.app')
@section('titulo', 'Categorias | Retrô FC')
@section('conteudo')
<div class="painel-lista">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="etiqueta">MAIS PERTO DO RETRÔ</span>
            <h1>Categorias</h1>
            <p class="mb-0 text-muted">Explore os produtos e benefícios oferecidos à torcida.</p>
        </div>
        <div>
            <a class="btn-secundario" href="{{ route('produtos.index') }}">VER CATÁLOGO</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr><th>Ícone</th><th>Nome</th><th>Produtos vinculados</th></tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->icone ?: '—' }}</td>
                        <td>{{ $categoria->nome }}</td>
                        <td>{{ $categoria->produtos_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center py-4">Nenhuma categoria cadastrada ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
