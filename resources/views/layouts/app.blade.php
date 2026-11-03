<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Retrô FC - Sócio-Torcedor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/retro.css') }}">
</head>
<body>
<header class="topo">
    <a class="marca" href="{{ route('home') }}">Retrô FC <span> | Sócio-Torcedor</span></a>
</header>
<nav class="barra">
    <button class="hamburguer" type="button" data-bs-toggle="collapse" data-bs-target="#menu-principal" aria-expanded="false" aria-controls="menu-principal" aria-label="Mostrar ou ocultar menu principal"><i class="bi bi-list" aria-hidden="true"></i></button>
    <div class="links-topo">
        <a href="{{ route('socios.form') }}">Cadastro</a>
        @guest
            <a href="{{ route('login') }}">Login</a>
        @else
            <span class="usuario-logado">Olá, {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="link-topo-botao" type="submit">Sair</button>
            </form>
        @endguest
        <a href="{{ route('socios.index') }}">Sócios cadastrados</a>
        <a href="{{ route('produtos.index') }}">Produtos e benefícios</a>
    </div>
</nav>
<div class="estrutura">
    <aside class="menu collapse collapse-horizontal" id="menu-principal">
        <a href="{{ route('home') }}"><i class="bi bi-house-door" aria-hidden="true"></i> Painel Principal</a>
        <a href="{{ route('socios.create') }}"><i class="bi bi-ticket-perforated" aria-hidden="true"></i> Quero ser sócio</a>
        <a href="{{ route('socios.index') }}"><i class="bi bi-people" aria-hidden="true"></i> Sócios cadastrados</a>
        <a href="{{ route('produtos.index') }}"><i class="bi bi-bag" aria-hidden="true"></i> Produtos e benefícios</a>
    </aside>
    <main class="conteudo">
        @if(session('sucesso'))
            <div class="alert alert-success">{{ session('sucesso') }}</div>
        @endif
        @yield('conteudo')
    </main>
</div>
<footer>Retrô FC • Juntos somos mais fortes</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
