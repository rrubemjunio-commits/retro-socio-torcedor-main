@extends('layouts.app')
@section('titulo', 'Produtos e benefícios | Retrô FC')
@section('conteudo')
<div class="painel-lista">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <span class="etiqueta">MAIS PERTO DO RETRÔ</span>
            <h1>Produtos e benefícios</h1>
            <p class="mb-0 text-muted">Confira os itens e vantagens disponíveis para a torcida.</p>
        </div>
    </div>

    @if($categorias->isNotEmpty())
        <nav class="filtros-categorias mb-4" aria-label="Filtrar produtos por categoria">
            <a class="filtro-categoria {{ $categoriaSelecionada === null ? 'active' : '' }}" href="{{ route('produtos.index') }}">Todos</a>
            @foreach($categorias as $categoria)
                <a class="filtro-categoria {{ (int) $categoriaSelecionada === $categoria->id ? 'active' : '' }}"
                   href="{{ route('produtos.index', ['categoria' => $categoria->id]) }}"
                   target="_blank" rel="noopener noreferrer">{{ $categoria->nome }}</a>
            @endforeach
        </nav>
    @endif

    <div class="row g-4">
        @forelse($produtos as $produto)
            <div class="col-sm-6 col-xl-4">
                <article class="produto-card h-100">
                    <img src="{{ $produto->imagem ? asset($produto->imagem) : asset('images/produtos/item.jpg') }}" alt="{{ $produto->nome }}" class="produto-imagem">
                    <div class="produto-conteudo">
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            @if($produto->categoria)
                                <span class="produto-categoria">{{ $produto->categoria->nome }}</span>
                            @endif
                            @if($produto->destaque)
                                <span class="produto-destaque">Destaque</span>
                            @endif
                        </div>
                        <h2>{{ $produto->nome }}</h2>
                        @if($produto->descricao)
                            <p>{{ $produto->descricao }}</p>
                        @endif
                        <strong class="produto-valor">R$ {{ number_format((float) $produto->valor, 2, ',', '.') }}</strong>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="catalogo-vazio text-center">
                    <div class="icone">⚽</div>
                    <h2>Nenhum produto cadastrado</h2>
                    <p>Novos produtos e benefícios estarão disponíveis em breve.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
