@extends('layouts.app')
@section('titulo', 'Novo produto | Retrô FC')
@section('conteudo')
<div class="formulario">
    <span class="etiqueta">CATÁLOGO DA TORCIDA</span>
    <h1>Cadastrar produto ou benefício</h1>
    <p>Adicione itens, vantagens e produtos relacionados ao Retrô FC.</p>

    <form method="POST" action="{{ route('produtos.store') }}" novalidate>
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome *</label>
                <input id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" maxlength="100" required aria-invalid="{{ $errors->has('nome') ? 'true' : 'false' }}" @error('nome') aria-describedby="erro-nome" @enderror>
                @error('nome')<div class="invalid-feedback d-block" id="erro-nome" role="alert">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="categoria_id" class="form-label">Categoria</label>
                <select id="categoria_id" name="categoria_id" class="form-select @error('categoria_id') is-invalid @enderror" aria-invalid="{{ $errors->has('categoria_id') ? 'true' : 'false' }}" @error('categoria_id') aria-describedby="erro-categoria-id" @enderror>
                    <option value="">Sem categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $categoria->selectedAttribute }}>{{ $categoria->nome }}</option>
                    @endforeach
                </select>
                @error('categoria_id')<div class="invalid-feedback d-block" id="erro-categoria-id" role="alert">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="valor" class="form-label">Valor (R$) *</label>
                <input id="valor" type="number" name="valor" class="form-control @error('valor') is-invalid @enderror" value="{{ old('valor') }}" min="0" step="0.01" required aria-invalid="{{ $errors->has('valor') ? 'true' : 'false' }}" @error('valor') aria-describedby="erro-valor" @enderror>
                @error('valor')<div class="invalid-feedback d-block" id="erro-valor" role="alert">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="imagem" class="form-label">Caminho da imagem</label>
                <input id="imagem" name="imagem" class="form-control @error('imagem') is-invalid @enderror" value="{{ old('imagem') }}" maxlength="255" placeholder="images/produtos/item.jpg" aria-invalid="{{ $errors->has('imagem') ? 'true' : 'false' }}" @error('imagem') aria-describedby="erro-imagem" @enderror>
                @error('imagem')<div class="invalid-feedback d-block" id="erro-imagem" role="alert">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control @error('descricao') is-invalid @enderror" rows="3" aria-invalid="{{ $errors->has('descricao') ? 'true' : 'false' }}" @error('descricao') aria-describedby="erro-descricao" @enderror>{{ old('descricao') }}</textarea>
                @error('descricao')<div class="invalid-feedback d-block" id="erro-descricao" role="alert">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="destaque" id="destaque" value="1" {{ $destaqueCheckedAttribute }}>
                    <label class="form-check-label" for="destaque">Exibir como destaque</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="disponivel" id="disponivel" value="1" {{ $disponivelCheckedAttribute }}>
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
