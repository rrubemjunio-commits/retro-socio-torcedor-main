@extends('layouts.app')
@section('titulo', 'Nova categoria | Retrô FC')
@section('conteudo')
<div class="formulario">
    <span class="etiqueta">CATÁLOGO DA TORCIDA</span>
    <h1>Cadastrar categoria</h1>
    <p>Use categorias para separar os produtos e benefícios do Retrô FC.</p>

    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('categorias.store') }}">
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da categoria *</label>
            <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" maxlength="100" required placeholder="Ex.: Camisas, Acessórios, Benefícios">
        </div>
        <div class="mb-3">
            <label for="icone" class="form-label">Ícone (opcional)</label>
            <input id="icone" name="icone" class="form-control" value="{{ old('icone') }}" maxlength="255" placeholder="Ex.: ⚽ ou fa-solid fa-shirt">
            <small class="text-muted">Pode informar um emoji ou o nome de uma classe de ícone.</small>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-4">
            <button class="btn-amarelo" type="submit">SALVAR CATEGORIA</button>
            <a class="btn-secundario" href="{{ route('categorias.index') }}">CANCELAR</a>
        </div>
    </form>
</div>
@endsection
