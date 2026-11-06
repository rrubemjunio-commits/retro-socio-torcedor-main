@extends('layouts.app')
@section('titulo', 'Ingressos | Retrô FC')
@section('conteudo')
<section class="ingressos-pagina">
    <header class="ingressos-cabecalho">
        <span class="etiqueta">VEM TORCER COM A GENTE</span>
        <h1>Ingressos</h1>
        <p>Confira os próximos jogos em destaque e os valores dos ingressos.</p>
    </header>

    <div class="ingressos-lista">
        @foreach($jogos as $jogo)
            <article class="ingresso-jogo">
                <div class="ingresso-confronto">
                    <div class="ingresso-time">
                        <img src="{{ asset('images/retro-futebol-clube-2023-logo-png_seeklogo-466412-removebg-preview.png') }}" alt="" class="ingresso-escudo">
                        <strong>Retrô FC</strong>
                    </div>
                    <span class="ingresso-x">×</span>
                    <div class="ingresso-time">
                        <img src="{{ asset($loop->index === 0 ? 'images/Simbolo-escudo-nautico.png' : 'images/Santa_Cruz_Futebol_Clube_logo.svg.webp') }}" alt="" class="ingresso-escudo">
                        <strong>{{ $jogo['adversario'] }}</strong>
                    </div>
                </div>

                <p class="ingresso-detalhe"><i class="bi bi-calendar-event" aria-hidden="true"></i> {{ $jogo['data'] }} às {{ $jogo['horario'] }}</p>
                <p class="ingresso-detalhe"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> {{ $jogo['estadio'] }}</p>

                <div class="ingresso-precos">
                    <div><span>Inteira</span><strong>R$ {{ number_format($jogo['inteira'], 2, ',', '.') }}</strong></div>
                    <div><span>Meia-entrada</span><strong>R$ {{ number_format($jogo['meia'], 2, ',', '.') }}</strong></div>
                </div>
                <button class="btn btn-warning ingresso-comprar w-100 mt-3" type="button" data-bs-toggle="modal" data-bs-target="#compra-em-breve">
                    <i class="bi bi-ticket-perforated" aria-hidden="true"></i> Comprar ingresso
                </button>
            </article>
        @endforeach
    </div>
    <p class="ingressos-nota">Datas e valores são apenas exemplos.</p>
</section>

<div class="modal fade" id="compra-em-breve" tabindex="-1" aria-labelledby="compra-em-breve-titulo" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="compra-em-breve-titulo">Compra de ingresso</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">A compra de ingressos estará disponível em breve.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection
