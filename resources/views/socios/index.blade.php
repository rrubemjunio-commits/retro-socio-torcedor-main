@extends('layouts.app')
@section('titulo', 'Sócios cadastrados')
@section('conteudo')
<div class="painel-lista">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div><span class="etiqueta">ÁREA ADMINISTRATIVA</span><h1>Sócios cadastrados</h1></div>
        <a class="btn-amarelo" href="{{ route('socios.create') }}">NOVO CADASTRO</a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead><tr><th>Nome</th><th>CPF</th><th>Telefone</th><th>E-mail</th><th>Nascimento</th><th>Plano</th></tr></thead>
            <tbody>
            @forelse($socios as $socio)
                <tr>
                    <td>{{ $socio->nome }}</td><td>{{ $socio->cpf }}</td><td>{{ $socio->telefone }}</td>
                    <td>{{ $socio->email ?: '—' }}</td><td>{{ $socio->data_nascimento->format('d/m/Y') }}</td><td><span class="plano">{{ $socio->plano }}</span></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center py-4">Nenhum sócio cadastrado ainda.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
