@extends('layouts.app')
@section('titulo', 'Novo produto | Retrô FC')
@section('conteudo')
<div class="formulario">
    <span class="etiqueta">CATÁLOGO DA TORCIDA</span>
    <h1>Cadastrar produto ou benefício</h1>
    <p>Adicione itens, vantagens e produtos relacionados ao Retrô FC.</p>

    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('produtos.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome *</label>
                <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" maxlength="100" required>
            </div>
            <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoria</label>
                <select id="categoria_id" name="categoria_id" class="form-select">
                    <option value="">Sem categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>{{ $categoria->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="valor" class="form-label">Valor (R$) *</label>
                <input id="valor" type="number" name="valor" class="form-control" value="{{ old('valor') }}" min="0" step="0.01" required>
            </div>
            <div class="col-md-6">
                <label for="imagem" class="form-label">Caminho da imagem</label>
                <input id="imagem" name="imagem" class="form-control" value="{{ old('imagem') }}" maxlength="255" placeholder="images/produtos/item.jpg">
            </div>
            <div class="col-12">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="3">{{ old('descricao') }}</textarea>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="destaque" id="destaque" value="1" @checked(old('destaque', true))>
                    <label class="form-check-label" for="destaque">Exibir como destaque</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="disponivel" id="disponivel" value="1" @checked(old('disponivel', true))>
                    <label class="form-check-label" for="disponivel">Produto disponível</label>
                </div>
            </div>
        </div>
        <p class="text-muted small mt-3 mb-0">A imagem deve estar dentro da pasta public. Exemplo: images/produtos/item.jpg.</p>
        <div class="d-flex flex-wrap gap-2 mt-4">
            <button class="btn-amarelo" type="submit">SALVAR PRODUTO</button>
            <a class="btn-secundario" href="{{ route('produtos.index') }}">CANCELAR</a>
        </div>
    </form>
</div>
@endsection
