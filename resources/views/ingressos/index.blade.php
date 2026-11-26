@extends('layouts.app')
@section('titulo', 'Ingressos | Retrô FC')
@section('conteudo')
<section class="ingressos-pagina">
    <header class="ingressos-cabecalho">
        <span class="etiqueta">VEM TORCER COM A GENTE</span>
        <h1>Ingressos</h1>
        <p>Confira os próximos jogos em destaque e os valores dos ingressos.</p>
    </header>

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="ingressos-lista">
        @foreach($jogos as $id => $jogo)
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
                <form method="POST" action="{{ route('ingressos.store') }}" class="mt-3">
                    @csrf
                    <input type="hidden" name="jogo" value="{{ $id }}">
                    <div class="row g-2">
                        <div class="col-7">
                            <label class="form-label" for="tipo-{{ $id }}">Tipo de ingresso</label>
                            <select class="form-select" id="tipo-{{ $id }}" name="tipo" required>
                                <option value="inteira" @selected(old('jogo') === $id && old('tipo') === 'inteira')>Inteira</option>
                                <option value="meia" @selected(old('jogo') === $id && old('tipo') === 'meia')>Meia-entrada</option>
                            </select>
                        </div>
                        <div class="col-5">
                            <label class="form-label" for="quantidade-{{ $id }}">Quantidade</label>
                            <select class="form-select" id="quantidade-{{ $id }}" name="quantidade" required>
                                @for($quantidade = 1; $quantidade <= 6; $quantidade++)
                                    <option value="{{ $quantidade }}" @selected(old('jogo') === $id && (int) old('quantidade', 1) === $quantidade)>{{ $quantidade }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-warning ingresso-comprar w-100 mt-3" type="submit">
                        <i class="bi bi-ticket-perforated" aria-hidden="true"></i> Reservar ingresso
                    </button>
                </form>
            </article>
        @endforeach
    </div>
    <p class="ingressos-nota">Datas e valores são exemplos. As reservas são demonstrativas e não processam pagamentos.</p>
</section>
@endsection
