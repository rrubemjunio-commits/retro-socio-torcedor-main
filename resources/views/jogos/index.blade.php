@extends('layouts.app')
@section('titulo', 'Jogos | Retrô FC')
@section('conteudo')
<section class="painel-lista">
    <span class="etiqueta">ACOMPANHE O RETRÔ</span>
    <h1>Jogos</h1>
    <p class="mb-4 text-muted">Consulte a agenda das próximas partidas, os adversários e os resultados do Retrô FC.</p>
    <div class="catalogo-vazio text-center">
        <div class="icone"><i class="bi bi-calendar-event" aria-hidden="true"></i></div>
        <h2>Agenda em breve</h2>
        <p class="mb-0">A programação oficial dos jogos será divulgada em breve.</p>
    </div>
</section>
@endsection
