@extends('layouts.app')
@section('titulo', 'Painel de controle')
@section('conteudo')
<div class="painel-lista dashboard-socios">
    <div class="dashboard-cabecalho">
        <div><span class="etiqueta">ÁREA ADMINISTRATIVA</span><h1>Painel de controle</h1></div>
    </div>

    <section class="dashboard-metricas" aria-label="Resumo geral">
        <article><i class="bi bi-person-circle"></i><div><strong>{{ $metricas['usuarios'] }}</strong><span>Usuários cadastrados</span></div></article>
        <article><i class="bi bi-award-fill"></i><div><strong>{{ $metricas['socios'] }}</strong><span>Assinaturas ativas</span></div></article>
        <article><i class="bi bi-shield-fill-check"></i><div><strong>{{ $metricas['ouro'] }}</strong><span>Plano Ouro</span></div></article>
        <article><i class="bi bi-grid-fill"></i><div><strong>{{ $metricas['categorias'] }}</strong><span>Categorias</span></div></article>
    </section>

    <div class="dashboard-colunas">
        <section class="dashboard-lista" aria-labelledby="titulo-usuarios">
            <div class="dashboard-secao-titulo">
                <div><span>CONTAS DA PLATAFORMA</span><h2 id="titulo-usuarios">Usuários cadastrados</h2></div>
                <span class="dashboard-contador">{{ $metricas['usuarios'] }}</span>
            </div>
            <div class="table-responsive">
                <table class="table table-striped align-middle dashboard-tabela">
                    <thead><tr><th>Nome</th><th>E-mail</th><th>Plano</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td><strong>{{ $usuario->name }}</strong></td>
                            <td>{{ $usuario->email }}</td>
                            <td><span class="dashboard-plano plano-{{ strtolower($usuario->plano ?: 'nenhum') }}">{{ $usuario->plano ?: 'Sem assinatura' }}</span></td>
                            <td>{{ $usuario->ativo ? 'Ativo' : 'Inativo' }}</td>
                        </tr>
                    @endforeach
                    <tr class="{{ $usuariosVaziosVisibilidade }}"><td colspan="4" class="text-center py-4">Nenhum usuário cadastrado ainda.</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="dashboard-planos" aria-labelledby="titulo-planos">
            <span>ASSINATURAS</span>
            <h2 id="titulo-planos">Distribuição por plano</h2>
            <div class="dashboard-plano-item"><span><b class="plano-badge plano-bronze">Bronze</b></span><strong>{{ $metricas['bronze'] }}</strong></div>
            <div class="dashboard-plano-item"><span><b class="plano-badge plano-prata">Prata</b></span><strong>{{ $metricas['prata'] }}</strong></div>
            <div class="dashboard-plano-item"><span><b class="plano-badge plano-ouro">Ouro</b></span><strong>{{ $metricas['ouro'] }}</strong></div>
        </aside>
    </div>

    <section class="dashboard-lista" aria-labelledby="titulo-ingressos">
        <div class="dashboard-secao-titulo">
            <div><span>INGRESSOS</span><h2 id="titulo-ingressos">Ingressos reservados</h2></div>
            <span class="dashboard-contador">{{ $ingressos->sum('quantidade') }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped align-middle dashboard-tabela">
                <thead>
                    <tr>
                        <th>Comprador</th>
                        <th>Partida</th>
                        <th>Data do jogo</th>
                        <th>Local</th>
                        <th>Tipo</th>
                        <th>Quantidade</th>
                        <th>Valor unitário</th>
                        <th>Total</th>
                        <th>Reservado em</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ingressos as $ingresso)
                        <tr>
                            <td>
                                <strong>{{ $ingresso->user?->name ?? 'Visitante' }}</strong>
                                <small class="d-block text-white-50">{{ $ingresso->user?->email ?? 'Sem conta vinculada' }}</small>
                            </td>
                            <td><strong>Retrô FC × {{ $ingresso->adversario }}</strong></td>
                            <td>{{ $ingresso->data_jogo->format('d/m/Y') }} às {{ $ingresso->horario }}</td>
                            <td>{{ $ingresso->estadio }}</td>
                            <td>{{ $ingresso->tipo === 'meia' ? 'Meia-entrada' : 'Inteira' }}</td>
                            <td>{{ $ingresso->quantidade }}</td>
                            <td>R$ {{ number_format((float) $ingresso->valor_unitario, 2, ',', '.') }}</td>
                            <td><strong>R$ {{ number_format((float) $ingresso->valor_total, 2, ',', '.') }}</strong></td>
                            <td>{{ $ingresso->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                    @if($ingressos->isEmpty())
                        <tr><td colspan="9" class="text-center py-4">Nenhum ingresso reservado ainda.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>

    <section class="dashboard-lista" aria-labelledby="titulo-socios">
        <div class="dashboard-secao-titulo">
            <div><span>SÓCIOS TORCEDORES</span><h2 id="titulo-socios">Sócios cadastrados</h2></div>
            <span class="dashboard-contador">{{ $metricas['socios'] }}</span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped align-middle dashboard-tabela">
                <thead><tr><th>Nome</th><th>CPF</th><th>Telefone</th><th>E-mail</th><th>Nascimento</th><th>Plano</th></tr></thead>
                <tbody>
                @foreach($socios as $socio)
                    <tr>
                        <td><strong>{{ $socio->nome }}</strong></td>
                        <td>{{ $socio->cpf }}</td>
                        <td>{{ $socio->telefone }}</td>
                        <td>{{ $socio->email ?: '—' }}</td>
                        <td>{{ $socio->data_nascimento->format('d/m/Y') }}</td>
                        <td><span class="dashboard-plano plano-{{ strtolower($socio->plano ?: 'nenhum') }}">{{ $socio->plano ?: '—' }}</span></td>
                    </tr>
                @endforeach
                <tr class="{{ $sociosVaziosVisibilidade }}"><td colspan="6" class="text-center py-4">Nenhuma assinatura cadastrada ainda.</td></tr>
                </tbody>
            </table>
        </div>
    </section>

    <section class="dashboard-categorias" aria-labelledby="titulo-categorias">
        <div class="dashboard-secao-titulo">
            <div><span>CATÁLOGO DO CLUBE</span><h2 id="titulo-categorias">Categorias disponíveis</h2></div>
            <a class="btn-secundario" href="{{ route('categorias.create') }}">NOVA CATEGORIA</a>
        </div>
        <div class="dashboard-categoria-grade">
            @foreach($categorias as $categoria)
                <article>
                    <i class="bi bi-{{ $categoria->iconeBootstrap() }}" aria-hidden="true"></i>
                    <div><strong>{{ $categoria->nome }}</strong><span>{{ $categoria->produtos_count }} {{ $categoria->produtos_count === 1 ? 'item' : 'itens' }}</span></div>
                </article>
            @endforeach
        </div>
    </section>
</div>
@endsection
