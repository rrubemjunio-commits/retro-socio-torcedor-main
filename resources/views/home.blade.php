@extends('layouts.app')
@section('titulo', 'Retrô FC - Página inicial')
@section('conteudo')
<div class="home-page">
    <section class="home-hero" aria-labelledby="titulo-home">
        <div class="home-hero-copy">
            <span class="home-kicker"><i class="bi bi-stars" aria-hidden="true"></i> AZUL E AMARELO NO CORAÇÃO</span>
            <h1 id="titulo-home">O Retrô é feito<br><strong>por quem vive essa paixão.</strong></h1>
            <p>Da arquibancada ao campo, cada pessoa faz parte da história do clube. Venha viver o Retrô de perto e fortalecer essa família.</p>
            <div class="home-hero-actions">
                <a class="home-button-primary" href="{{ route('socios.create') }}">
                    Faça parte da torcida <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                </a>
                <a class="home-button-secondary" href="{{ route('produtos.index') }}">Ver benefícios</a>
            </div>
        </div>
    </section>

    <section class="home-highlights" aria-label="Retrô FC em números">
        <a class="home-highlight" href="{{ route('socios.index') }}">
            <span class="home-highlight-icon"><i class="bi bi-people-fill" aria-hidden="true"></i></span>
            <span class="home-highlight-text">
                <strong>{{ $sociosCadastrados }}</strong>
                <span>{{ $sociosCadastrados === 1 ? 'sócio na família Retrô' : 'sócios na família Retrô' }}</span>
            </span>
            <i class="bi bi-arrow-up-right home-highlight-arrow" aria-hidden="true"></i>
        </a>
        <a class="home-highlight" href="{{ route('produtos.index') }}">
            <span class="home-highlight-icon"><i class="bi bi-stars" aria-hidden="true"></i></span>
            <span class="home-highlight-text">
                <strong>{{ $beneficiosDisponiveis }}</strong>
                <span>{{ $beneficiosDisponiveis === 1 ? 'benefício disponível' : 'benefícios disponíveis' }}</span>
            </span>
            <i class="bi bi-arrow-up-right home-highlight-arrow" aria-hidden="true"></i>
        </a>
        <a class="home-highlight" href="{{ route('produtos.index') }}">
            <span class="home-highlight-icon"><i class="bi bi-grid-fill" aria-hidden="true"></i></span>
            <span class="home-highlight-text">
                <strong>{{ $categorias->count() }}</strong>
                <span>{{ $categorias->count() === 1 ? 'categoria para explorar' : 'categorias para explorar' }}</span>
            </span>
            <i class="bi bi-arrow-up-right home-highlight-arrow" aria-hidden="true"></i>
        </a>
    </section>

    <section class="home-story" aria-labelledby="titulo-historia">
        <div class="home-section-heading">
            <div>
                <span class="home-section-kicker">DENTRO E FORA DE CAMPO</span>
                <h2 id="titulo-historia">Uma paixão que se vive junto</h2>
                <p>A força do Retrô aparece na torcida e no trabalho de cada dia.</p>
            </div>
        </div>
        <div class="home-story-grid">
            <article class="home-story-card">
                <img src="{{ asset('images/torcida.jpg') }}" alt="Torcedores do Retrô reunidos nas arquibancadas em azul e amarelo" loading="lazy">
                <div class="home-story-copy">
                    <span>NA ARQUIBANCADA</span>
                    <h3>As cores que aproximam a torcida</h3>
                    <p>Camisas, bandeiras e vozes diferentes se encontram para apoiar o Retrô. É essa energia que transforma cada partida em um momento de união.</p>
                    <a href="{{ route('socios.create') }}">Venha fazer parte <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                </div>
            </article>
            <article class="home-story-card">
                <img src="{{ asset('images/estadio.jpg') }}" alt="Campo de futebol e estrutura de treinamento do Retrô" loading="lazy">
                <div class="home-story-copy">
                    <span>NO CAMPO</span>
                    <h3>O trabalho também faz parte da paixão</h3>
                    <p>É no campo, entre preparação e dedicação, que se constrói o caminho para representar o clube com orgulho a cada oportunidade.</p>
                    <a href="{{ route('jogos.index') }}">Acompanhe o Retrô <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                </div>
            </article>
            <article class="home-story-card">
                <img src="{{ asset('images/torcida2.jpg') }}" alt="Torcedores do Retrô segurando uma grande bandeira azul e amarela" loading="lazy">
                <div class="home-story-copy">
                    <span>UMA SÓ TORCIDA</span>
                    <h3>Uma bandeira que representa todos</h3>
                    <p>Na arquibancada, a bandeira azul e amarela reúne quem acredita no clube e acompanha cada novo capítulo da sua trajetória.</p>
                    <a href="{{ route('socios.create') }}">Faça parte dessa história <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
                </div>
            </article>
        </div>
    </section>

    <section class="home-categories" aria-labelledby="titulo-categorias">
        <div class="home-section-heading">
            <div>
                <span class="home-section-kicker">ENCONTRE O QUE É A SUA CARA</span>
                <h2 id="titulo-categorias">Explore o nosso catálogo</h2>
                <p>Um jeito fácil de encontrar seus produtos e benefícios favoritos.</p>
            </div>
            <a href="{{ route('produtos.index') }}">Ver catálogo <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>

        <div class="home-category-grid">
            @forelse($categorias as $categoria)
                <a class="home-category" href="{{ route('produtos.index', ['categoria' => $categoria->id]) }}">
                    <span class="home-category-icon" aria-hidden="true"><i class="bi bi-{{ $categoria->iconeBootstrap() }}"></i></span>
                    <span class="home-category-name">{{ $categoria->nome }}</span>
                    <i class="bi bi-arrow-up-right home-category-arrow" aria-hidden="true"></i>
                </a>
            @empty
                <p class="home-category-empty">Novas categorias e benefícios estarão disponíveis em breve.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
