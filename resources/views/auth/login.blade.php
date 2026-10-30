@extends('layouts.app')
@section('titulo', 'Login | Retrô FC')
@section('conteudo')
<section class="formulario login-formulario" aria-labelledby="titulo-login">
    <span class="etiqueta">BEM-VINDO DE VOLTA</span>
    <h1 id="titulo-login">Entrar na sua conta</h1>
    <p>Acesse sua conta para continuar.</p>

    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autocomplete="username" autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
        </div>
        <div class="form-check mb-3">
            <input id="remember" type="checkbox" name="remember" value="1" class="form-check-input">
            <label for="remember" class="form-check-label">Manter conectado</label>
        </div>
        <button class="btn-amarelo" type="submit">ENTRAR</button>
    </form>
</section>
@endsection
