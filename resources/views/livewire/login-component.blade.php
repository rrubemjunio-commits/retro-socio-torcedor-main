<section class="login-pagina" aria-labelledby="titulo-login">
    <div class="login-cartao">
        <div class="login-identidade">
            <div class="login-escudo">
                <img src="{{ asset('images/retro-futebol-clube-2023-logo-png_seeklogo-466412-removebg-preview.png') }}" alt="Escudo do Retrô Futebol Clube">
            </div>
            <span class="etiqueta">BEM-VINDO DE VOLTA</span>
            <h1 id="titulo-login">Que bom ter você de volta.</h1>
            <p>Acesse sua conta e continue acompanhando o Retrô FC.</p>
            <div class="login-chamada-torcida">
                <i class="bi bi-people-fill" aria-hidden="true"></i>
                <span>Uma só torcida. Uma só paixão.</span>
            </div>
        </div>

        <div class="login-formulario">
            <div class="login-formulario-topo">
                <h2>Entrar na sua conta</h2>
                <p>Informe seus dados de acesso para continuar.</p>
            </div>

            <form method="POST" action="{{ route('login.store') }}" novalidate>
                @csrf
                <div class="login-campo mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <div class="login-input-icone">
                        <i class="bi bi-envelope" aria-hidden="true"></i>
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="username" autofocus placeholder="voce@email.com" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="erro-email" @enderror>
                    </div>
                    @error('email')<div class="invalid-feedback d-block" id="erro-email" role="alert">{{ $message }}</div>@enderror
                </div>
                <div class="login-campo mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <div class="login-input-icone">
                        <i class="bi bi-lock" aria-hidden="true"></i>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="Sua senha" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" @error('password') aria-describedby="erro-password" @enderror>
                    </div>
                    @error('password')<div class="invalid-feedback d-block" id="erro-password" role="alert">{{ $message }}</div>@enderror
                </div>
                <div class="form-check login-manter mb-4">
                    <input id="remember" type="checkbox" name="remember" value="1" class="form-check-input">
                    <label for="remember" class="form-check-label">Manter conectado</label>
                </div>
                <button class="btn-amarelo login-enviar" type="submit">ENTRAR <i class="bi bi-arrow-right" aria-hidden="true"></i></button>
            </form>

            <p class="login-cadastro-link">Não tem login? <a href="{{ route('socios.form') }}">Faça cadastro de sócio-torcedor</a></p>
        </div>
    </div>
</section>
