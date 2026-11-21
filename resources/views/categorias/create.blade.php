@extends('layouts.app')
@section('titulo', 'Nova categoria | Retrô FC')
@section('conteudo')
<div class="formulario">
    <span class="etiqueta">CATÁLOGO DA TORCIDA</span>
    <h1>Cadastrar categoria</h1>
    <p>Use categorias para separar os produtos e benefícios do Retrô FC.</p>

    <form method="POST" action="{{ route('categorias.store') }}" novalidate>
        @csrf
        <div class="mb-3">
            <label for="nome" class="form-label">Nome da categoria *</label>
            <input id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" maxlength="100" required placeholder="Ex.: Camisas, Acessórios, Benefícios" aria-invalid="{{ $errors->has('nome') ? 'true' : 'false' }}" @error('nome') aria-describedby="erro-nome" @enderror>
            @error('nome')<div class="invalid-feedback d-block" id="erro-nome" role="alert">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label for="icone" class="form-label">Ícone (opcional)</label>
            <select id="icone" name="icone" class="form-select @error('icone') is-invalid @enderror" aria-invalid="{{ $errors->has('icone') ? 'true' : 'false' }}" @error('icone') aria-describedby="erro-icone" @enderror>
                <option value="">Ícone padrão</option>
                @foreach($icones as $icone)
                    <option value="{{ $icone['nome'] }}" {{ $icone['selectedAttribute'] }}>{{ $icone['rotulo'] }}</option>
                @endforeach
            </select>
            @error('icone')<div class="invalid-feedback d-block" id="erro-icone" role="alert">{{ $message }}</div>@enderror
            <small class="text-muted">Escolha um ícone Bootstrap para representar a categoria.</small>
        </div>
        <div class="d-flex flex-wrap gap-2 mt-4">
            <button class="btn-amarelo" type="submit">SALVAR CATEGORIA</button>
            <a class="btn-secundario" href="{{ route('categorias.index') }}">CANCELAR</a>
        </div>
    </form>
</div>
@endsection
