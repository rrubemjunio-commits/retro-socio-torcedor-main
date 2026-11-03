@extends('layouts.app')
@section('titulo', 'Retrô FC - Página inicial')
@section('conteudo')
<div id="destaques-retro" class="carousel slide carousel-fade home-carousel" data-bs-ride="carousel" data-bs-interval="6500">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#destaques-retro" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Destaque 1"></button>
        <button type="button" data-bs-target="#destaques-retro" data-bs-slide-to="1" aria-label="Destaque 2"></button>
        <button type="button" data-bs-target="#destaques-retro" data-bs-slide-to="2" aria-label="Destaque 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <section class="hero hero--torcida">
                <div class="hero-texto">
                    <span class="etiqueta">PAIXÃO QUE NOS UNE</span>
                    <h1>Juntos somos<br><strong>mais fortes!</strong></h1>
                    <p>Faça parte da família Retrô FC. Cadastre-se como sócio e fique mais perto do nosso clube.</p>
                    <a class="btn-amarelo" href="{{ route('socios.create') }}">QUERO SER SÓCIO</a>
                </div>
            </section>
        </div>
        <div class="carousel-item">
            <section class="hero hero--beneficios">
                <div class="hero-texto">
                    <span class="etiqueta">VANTAGENS EXCLUSIVAS</span>
                    <h1>Ser Retrô é<br><strong>viver mais!</strong></h1>
                    <p>Descubra produtos e benefícios feitos para quem carrega o clube no coração.</p>
                    <a class="btn-amarelo" href="{{ route('produtos.index') }}">EXPLORAR BENEFÍCIOS</a>
                </div>
            </section>
        </div>
        <div class="carousel-item">
            <section class="hero hero--clube">
                <div class="hero-texto">
                    <span class="etiqueta">NOSSO CLUBE, NOSSA FAMÍLIA</span>
                    <h1>A torcida é<br><strong>o nosso maior time!</strong></h1>
                    <p>Conheça quem já está junto com o Retrô FC e venha fazer parte dessa história.</p>
                    <a class="btn-amarelo" href="{{ route('socios.index') }}">CONHECER A TORCIDA</a>
                </div>
            </section>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#destaques-retro" data-bs-slide="prev" aria-label="Destaque anterior">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#destaques-retro" data-bs-slide="next" aria-label="Próximo destaque">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>
<section class="categorias-destaque" aria-labelledby="titulo-categorias">
    <div class="secao-cabecalho">
        <div>
            <span class="etiqueta">ENCONTRE O QUE É A SUA CARA</span>
            <h2 id="titulo-categorias">Explore por categoria</h2>
            <p>Escolha uma categoria para descobrir os produtos e benefícios do Retrô FC.</p>
        </div>
    </div>
    <div class="row g-3">
        @forelse($categorias as $categoria)
            <div class="col-6 col-lg-3">
                <a class="categoria-destaque h-100" href="{{ route('produtos.index', ['categoria' => $categoria->id]) }}" target="_blank" rel="noopener noreferrer">
                    <span class="categoria-icone" aria-hidden="true"><i class="bi bi-{{ $categoria->iconeBootstrap() }}"></i></span>
                    <span class="categoria-nome">{{ $categoria->nome }}</span>
                    <span class="categoria-acao">Ver opções <i class="bi bi-arrow-up-right" aria-hidden="true"></i></span>
                </a>
            </div>
        @empty
            <div class="col-12">
                <p class="categorias-vazias">Novas categorias e benefícios estarão disponíveis em breve.</p>
            </div>
        @endforelse
    </div>
</section>
<section class="blocos" id="beneficios">
    <article class="bloco-destaque">
        <button class="bloco-gatilho" type="button" data-bs-toggle="collapse" data-bs-target="#opcoes-socio" aria-expanded="false" aria-controls="opcoes-socio">
            <span class="icone"><i class="bi bi-ticket-perforated" aria-hidden="true"></i></span>
            <span class="bloco-titulo">Seja sócio</span>
            <i class="bi bi-chevron-down bloco-seta" aria-hidden="true"></i>
        </button>
        <div class="collapse" id="opcoes-socio">
            <div class="bloco-opcoes">
                <p>Escolha seu plano e faça parte da família Retrô FC.</p>
                <a href="{{ route('socios.create') }}" class="link-bloco">Fazer cadastro</a>
            </div>
        </div>
    </article>
    <article class="bloco-destaque">
        <button class="bloco-gatilho" type="button" data-bs-toggle="collapse" data-bs-target="#opcoes-produtos" aria-expanded="false" aria-controls="opcoes-produtos">
            <span class="icone"><i class="bi bi-bag" aria-hidden="true"></i></span>
            <span class="bloco-titulo">Produtos e benefícios</span>
            <i class="bi bi-chevron-down bloco-seta" aria-hidden="true"></i>
        </button>
        <div class="collapse" id="opcoes-produtos">
            <div class="bloco-opcoes">
                <p>Confira os itens e vantagens disponíveis para a torcida.</p>
                <a href="{{ route('produtos.index') }}" class="link-bloco">Ver catálogo</a>
            </div>
        </div>
    </article>
    <article class="bloco-destaque" id="jogos">
        <button class="bloco-gatilho" type="button" data-bs-toggle="collapse" data-bs-target="#opcoes-socios" aria-expanded="false" aria-controls="opcoes-socios">
            <span class="icone"><i class="bi bi-people" aria-hidden="true"></i></span>
            <span class="bloco-titulo">Sócios cadastrados</span>
            <i class="bi bi-chevron-down bloco-seta" aria-hidden="true"></i>
        </button>
        <div class="collapse" id="opcoes-socios">
            <div class="bloco-opcoes">
                <p>Acesse a relação de torcedores que já fazem parte do clube.</p>
                <a href="{{ route('socios.index') }}" class="link-bloco">Consultar sócios</a>
            </div>
        </div>
    </article>
</section>
@endsection
