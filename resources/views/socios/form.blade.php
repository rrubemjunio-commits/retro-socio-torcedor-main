@extends('layouts.app')
@section('titulo', 'Cadastro de sócio | Retrô FC')
@section('conteudo')
<div class="formulario cadastro-socio">
    <a class="link-bloco" href="{{ route('socios.create') }}">← Voltar aos planos</a>
    <span class="etiqueta d-block mt-3">ESTAMOS FELIZES COM A SUA ESCOLHA</span>
    <h1>Faça seu cadastro</h1>
    <p>Preencha seus dados para fazer parte da torcida Retrô FC.</p>
    <p class="planos-aviso">Os valores e benefícios dos planos são sugestões ilustrativas.</p>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
        </div>
    @endif
    <form method="POST" action="{{ route('socios.store') }}">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome completo *</label>
                <input id="nome" name="nome" class="form-control" value="{{ old('nome') }}" required maxlength="120">
            </div>
            <div class="col-md-6">
                <label for="cpf" class="form-label">CPF (11 números) *</label>
                <input id="cpf" name="cpf" class="form-control" value="{{ old('cpf') }}" required minlength="11" maxlength="11" inputmode="numeric" pattern="[0-9]{11}" placeholder="Somente números">
            </div>
            <div class="col-md-6">
                <label for="telefone" class="form-label">Telefone / número *</label>
                <input id="telefone" name="telefone" class="form-control" value="{{ old('telefone') }}" required maxlength="20" placeholder="(00) 00000-0000">
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" maxlength="150">
            </div>
            <div class="col-md-6">
                <label for="data_nascimento" class="form-label">Data de nascimento *</label>
                <input id="data_nascimento" type="date" name="data_nascimento" class="form-control" value="{{ old('data_nascimento') }}" required>
            </div>
            <div class="col-md-6">
                <label for="plano" class="form-label">Plano mensal *</label>
                <select id="plano" name="plano" class="form-select" required>
                    <option value="">Selecione seu plano</option>
                    @foreach(['Bronze', 'Prata', 'Ouro'] as $plano)
                        <option value="{{ $plano }}" @selected(old('plano', $planoSelecionado) === $plano)>{{ $plano }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="btn-amarelo mt-4" type="submit">CADASTRAR SÓCIO</button>
    </form>
</div>
@endsection
