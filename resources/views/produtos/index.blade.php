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
        <a class="catalogo-aba {{ $classeAbaConsumo }}"
           href="{{ route('produtos.index', ['aba' => 'consumo']) }}"
           aria-current="{{ $ariaAbaConsumo }}">
            <i class="bi bi-cup-straw" aria-hidden="true"></i> Pra comer
        </a>
        <a class="catalogo-aba {{ $classeAbaCupons }}"
           href="{{ route('produtos.index', ['aba' => 'cupons']) }}"
           aria-current="{{ $ariaAbaCupons }}">
            <i class="bi bi-ticket-perforated" aria-hidden="true"></i> Mimos de sócio
            <span class="selo-exclusivo">Sócio</span>
        </a>
    </nav>

    <section class="{{ $consumoVisibilidade }}">
        <nav class="catalogo-categorias {{ $filtrosCategoriasClass }}" aria-label="Filtrar itens por categoria">
            <a class="filtro-categoria {{ $categoriaTodosActiveClass }}"
               href="{{ route('produtos.index', ['aba' => 'consumo']) }}">Todos</a>
            @foreach($categorias as $categoria)
                <a class="filtro-categoria {{ $categoria->activeClass }}"
                   href="{{ route('produtos.index', ['aba' => 'consumo', 'categoria' => $categoria->id]) }}"
                   aria-current="{{ $categoria->ariaCurrent }}">{{ $categoria->nome }}</a>
            @endforeach
        </nav>

        <div class="row g-4">
            @foreach($produtos as $produto)
                <div class="col-sm-6 col-xl-4">
                    <article class="produto-card h-100">
                        <img src="{{ $produto->imagemUrl }}" alt="{{ $produto->nome }}" class="produto-imagem {{ $produto->imagemVisibilidade }}">
                        <div class="produto-imagem produto-imagem--icone produto-imagem--{{ $produto->iconeCategoria }} {{ $produto->placeholderVisibilidade }}" aria-hidden="true">
                            <i class="bi bi-{{ $produto->iconeCategoria }}"></i>
                            <span>{{ $produto->categoriaNome ?: 'Produto' }}</span>
                        </div>
                        <div class="produto-conteudo">
                            <div class="d-flex flex-wrap gap-2 mb-2">
                                <span class="produto-categoria {{ $produto->categoriaVisibilidade }}">{{ $produto->categoriaNome }}</span>
                                <span class="produto-destaque {{ $produto->destaqueVisibilidade }}"><i class="bi bi-heart-fill" aria-hidden="true"></i> Queridinho</span>
                            </div>
                            <h2>{{ $produto->nome }}</h2>
                            <p class="{{ $produto->descricaoVisibilidade }}">{{ $produto->descricao }}</p>
                            <strong class="produto-valor">R$ {{ number_format((float) $produto->valor, 2, ',', '.') }}</strong>
                        </div>
                    </article>
                </div>
            @endforeach
            <div class="col-12 {{ $produtosVaziosVisibilidade }}">
                <div class="catalogo-vazio text-center">
                    <div class="icone"><i class="bi bi-cup-hot" aria-hidden="true"></i></div>
                    <h2>Nenhum item encontrado</h2>
                    <p>Novos sabores para acompanhar a torcida chegam em breve.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="{{ $cuponsVisibilidade }}">
        <div class="{{ $cuponsSocioVisibilidade }}">
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
        </div>
        <section class="cupons-bloqueados {{ $cuponsVisitanteVisibilidade }}" aria-labelledby="cupons-bloqueados-titulo">
            <span class="cupons-icone"><i class="bi bi-lock-fill" aria-hidden="true"></i></span>
            <span class="etiqueta">UM MIMO PRA TORCIDA</span>
            <h2 id="cupons-bloqueados-titulo">Tem desconto esperando por você!</h2>
            <p>Faça login com o e-mail do seu cadastro de sócio pra ver seus cupons.</p>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <a class="btn-amarelo {{ $loginLinkVisibilidade }}" href="{{ route('login') }}">ENTRAR NA MINHA CONTA</a>
                <a class="btn-outline-claro" href="{{ route('socios.form') }}">QUERO SER SÓCIO</a>
            </div>
        </section>
    </section>
</div>
@endsection
