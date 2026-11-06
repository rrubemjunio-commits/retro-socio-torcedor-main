@extends('layouts.app')
@section('titulo', 'Produtos e benefícios | Retrô FC')
@section('conteudo')
<div class="painel-lista">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 catalogo-cabecalho">
        <div>
            <span class="etiqueta"><i class="bi bi-emoji-heart-eyes" aria-hidden="true"></i> FOME DE GOL?</span>
            <h1>Comida boa,<br>torcida melhor!</h1>
            <p class="mb-0">Escolhe o seu e bora apoiar o Retrô!</p>
        </div>
    </div>

    <nav class="catalogo-abas" aria-label="Seções do catálogo">
        <a class="catalogo-aba {{ $abaSelecionada === 'consumo' ? 'active' : '' }}"
           href="{{ route('produtos.index', ['aba' => 'consumo']) }}"
           @if($abaSelecionada === 'consumo') aria-current="page" @endif>
            <i class="bi bi-cup-straw" aria-hidden="true"></i> Pra comer
        </a>
        <a class="catalogo-aba {{ $abaSelecionada === 'cupons' ? 'active' : '' }}"
           href="{{ route('produtos.index', ['aba' => 'cupons']) }}"
           @if($abaSelecionada === 'cupons') aria-current="page" @endif>
            <i class="bi bi-ticket-perforated" aria-hidden="true"></i> Mimos de sócio
            <span class="selo-exclusivo">Sócio</span>
        </a>
    </nav>

    @if($abaSelecionada === 'consumo')
        @if($categorias->isNotEmpty())
            <nav class="catalogo-categorias" aria-label="Filtrar itens por categoria">
                <a class="filtro-categoria {{ $categoriaSelecionada === null ? 'active' : '' }}"
                   href="{{ route('produtos.index', ['aba' => 'consumo']) }}">Todos</a>
                @foreach($categorias as $categoria)
                    <a class="filtro-categoria {{ (int) $categoriaSelecionada === $categoria->id ? 'active' : '' }}"
                       href="{{ route('produtos.index', ['aba' => 'consumo', 'categoria' => $categoria->id]) }}"
                       @if((int) $categoriaSelecionada === $categoria->id) aria-current="page" @endif>{{ $categoria->nome }}</a>
                @endforeach
            </nav>
        @endif

        <div class="row g-4">
            @forelse($produtos as $produto)
                <div class="col-sm-6 col-xl-4">
                    <article class="produto-card h-100">
                        @if($produto->imagem)
                            <img src="{{ asset($produto->imagem) }}" alt="{{ $produto->nome }}" class="produto-imagem">
                        @else
                            <div class="produto-imagem produto-imagem--icone produto-imagem--{{ $produto->categoria?->iconeBootstrap() ?? 'bag' }}" aria-hidden="true">
                                <i class="bi bi-{{ $produto->categoria?->iconeBootstrap() ?? 'bag' }}"></i>
                                <span>{{ $produto->categoria?->nome ?? 'Produto' }}</span>
                            </div>
                        @endif
                        <div class="produto-conteudo">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                @if($produto->categoria)
                                    <span class="produto-categoria">{{ $produto->categoria->nome }}</span>
                                @endif
                                @if($produto->destaque)
                                    <span class="produto-destaque"><i class="bi bi-heart-fill" aria-hidden="true"></i> Queridinho</span>
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
                        <div class="icone"><i class="bi bi-cup-hot" aria-hidden="true"></i></div>
                        <h2>Nenhum item encontrado</h2>
                        <p>Novos sabores para acompanhar a torcida chegam em breve.</p>
                    </div>
                </div>
            @endforelse
        </div>
    @else
        @if($socioAutenticado)
            <p class="cupons-nota">Cupons de teste — resgate ainda não disponível.</p>
            <div class="row g-4">
                @foreach($cupons as $cupom)
                    <div class="col-sm-6 col-xl-4">
                        <article class="cupom-card h-100">
                            <div class="cupom-selo"><i class="bi bi-stars" aria-hidden="true"></i> MIMO DE SÓCIO</div>
                            <strong class="cupom-desconto">{{ $cupom['desconto'] }}</strong>
                            <h2>{{ $cupom['titulo'] }}</h2>
                            <p>{{ $cupom['descricao'] }}</p>
                            <div class="cupom-codigo">
                                <span>CÓDIGO</span>
                                <code>{{ $cupom['codigo'] }}</code>
                            </div>
                            <small>{{ $cupom['validade'] }}</small>
                        </article>
                    </div>
                @endforeach
            </div>
        @else
            <section class="cupons-bloqueados" aria-labelledby="cupons-bloqueados-titulo">
                <span class="cupons-icone"><i class="bi bi-lock-fill" aria-hidden="true"></i></span>
                <span class="etiqueta">UM MIMO PRA TORCIDA</span>
                <h2 id="cupons-bloqueados-titulo">Tem desconto esperando por você!</h2>
                <p>Faça login com o e-mail do seu cadastro de sócio pra ver seus cupons.</p>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @guest
                        <a class="btn-amarelo" href="{{ route('login') }}">ENTRAR NA MINHA CONTA</a>
                    @endguest
                    <a class="btn-outline-claro" href="{{ route('socios.form') }}">QUERO SER SÓCIO</a>
                </div>
            </section>
        @endif
    @endif
</div>
@endsection
