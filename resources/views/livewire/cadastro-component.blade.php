<section class="cadastro-pagina" aria-labelledby="titulo-cadastro">
    <a class="link-bloco cadastro-voltar" href="{{ route('home') }}">
    <i class="bi bi-arrow-left" aria-hidden="true"></i> Voltar ao início
    </a>

    <header class="cadastro-cabecalho">
        <span class="etiqueta">A FAMÍLIA RETRÔ CRESCE COM VOCÊ</span>
        <h1 id="titulo-cadastro">Vem ser sócio-torcedor</h1>
        <p>Seu apoio fortalece o clube. Preencha seus dados e escolha como quer viver essa paixão.</p>
        <div class="cadastro-etapas" aria-label="Etapas do cadastro">
            <span class="cadastro-etapa cadastro-etapa-ativa"><b>1</b> Seus dados</span>
        </div>
    </header>

    <div class="cadastro-layout">
        <section class="formulario cadastro-formulario" aria-labelledby="titulo-formulario-cadastro">
            <div class="cadastro-formulario-topo">
                <span class="cadastro-icone-secao" aria-hidden="true"><i class="bi bi-person-vcard"></i></span>
                <div>
                    <h2 id="titulo-formulario-cadastro">Seus dados</h2>
                    <p>Os campos com <span aria-hidden="true">*</span> são obrigatórios.</p>
                </div>
            </div>

            <form wire:submit="cadastrar" novalidate>
                <div class="cadastro-campos">
                    @if($plano)
                        <div class="cadastro-campo cadastro-campo-largo">
                            <label class="form-label">Plano escolhido</label>
                            <div class="plano">{{ $plano }}</div>
                        </div>
                    @else
                        <div class="cadastro-campo cadastro-campo-largo">
                            <label for="plano" class="form-label">Escolha seu plano <span aria-hidden="true">*</span></label>
                            <select id="plano" class="form-select @error('plano') is-invalid @enderror" wire:model="plano" required>
                                <option value="">Selecione</option>
                                <option value="Bronze">Bronze</option>
                                <option value="Prata">Prata</option>
                                <option value="Ouro">Ouro</option>
                            </select>
                            @error('plano')<div class="invalid-feedback d-block" role="alert">{{ $message }}</div>@enderror
                        </div>
                    @endif
                    <div class="cadastro-campo cadastro-campo-largo">
                        <label for="nome" class="form-label">Nome completo <span aria-hidden="true">*</span></label>
                        <input id="nome" name="nome" class="form-control @error('nome') is-invalid @enderror" wire:model="nome" required maxlength="120" autocomplete="name" placeholder="Como está no seu documento" aria-invalid="{{ $errors->has('nome') ? 'true' : 'false' }}" @error('nome') aria-describedby="erro-nome" @enderror>
                        @error('nome')<div class="invalid-feedback d-block" id="erro-nome" role="alert">{{ $message }}</div>@enderror
                    </div>
                    <div class="cadastro-campo">
                        <label for="cpf" class="form-label">CPF <span aria-hidden="true">*</span></label>
                        <input id="cpf" name="cpf" class="form-control @error('cpf') is-invalid @enderror" wire:model="cpf" required minlength="11" maxlength="11" inputmode="numeric" pattern="[0-9]{11}" autocomplete="off" placeholder="Somente os 11 números" aria-describedby="ajuda-cpf @error('cpf') erro-cpf @enderror" aria-invalid="{{ $errors->has('cpf') ? 'true' : 'false' }}">
                        <small id="ajuda-cpf">Não use pontos ou traço.</small>
                        @error('cpf')<div class="invalid-feedback d-block" id="erro-cpf" role="alert">{{ $message }}</div>@enderror
                    </div>
                    <div class="cadastro-campo">
                        <label for="telefone" class="form-label">Celular / telefone <span aria-hidden="true">*</span></label>
                        <input id="telefone" type="tel" name="telefone" class="form-control @error('telefone') is-invalid @enderror" wire:model="telefone" required maxlength="20" autocomplete="tel" placeholder="(00) 00000-0000" aria-invalid="{{ $errors->has('telefone') ? 'true' : 'false' }}" @error('telefone') aria-describedby="erro-telefone" @enderror>
                        @error('telefone')<div class="invalid-feedback d-block" id="erro-telefone" role="alert">{{ $message }}</div>@enderror
                    </div>
                    <div class="cadastro-campo">
                        <label for="email" class="form-label">E-mail <span aria-hidden="true">*</span></label>
                        <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" required maxlength="150" autocomplete="email" placeholder="voce@email.com" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" @error('email') aria-describedby="erro-email" @enderror>
                        @error('email')<div class="invalid-feedback d-block" id="erro-email" role="alert">{{ $message }}</div>@enderror
                        <small>Usado para acessar sua conta.</small>
                    </div>
                    <div class="cadastro-campo">
                        <label for="data_nascimento" class="form-label">Data de nascimento <span aria-hidden="true">*</span></label>
                        <input id="data_nascimento" type="date" name="data_nascimento" class="form-control @error('data_nascimento') is-invalid @enderror" wire:model="data_nascimento" required autocomplete="bday" aria-invalid="{{ $errors->has('data_nascimento') ? 'true' : 'false' }}" @error('data_nascimento') aria-describedby="erro-data-nascimento" @enderror>
                        @error('data_nascimento')<div class="invalid-feedback d-block" id="erro-data-nascimento" role="alert">{{ $message }}</div>@enderror
                    </div>
                    <div class="cadastro-campo">
                        <label for="password" class="form-label">Senha <span aria-hidden="true">*</span></label>
                        <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" required minlength="8" autocomplete="new-password" placeholder="Crie uma senha" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" @error('password') aria-describedby="erro-password" @enderror>
                        @error('password')<div class="invalid-feedback d-block" id="erro-password" role="alert">{{ $message }}</div>@enderror
                        <small>Use pelo menos 8 caracteres.</small>
                    </div>
                    <div class="cadastro-campo">
                        <label for="password_confirmation" class="form-label">Confirmar senha <span aria-hidden="true">*</span></label>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" wire:model="password_confirmation" required minlength="8" autocomplete="new-password" placeholder="Digite a senha novamente" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}">
                    </div>
                </div>

                <div class="cadastro-rodape-form">
                    <p><i class="bi bi-shield-check" aria-hidden="true"></i> Seus dados são usados para este cadastro de sócio.</p>
                    <button class="btn-amarelo cadastro-enviar" type="submit" wire:loading.attr="disabled" wire:target="cadastrar">
                        <span wire:loading.remove wire:target="cadastrar">FINALIZAR CADASTRO <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                        <span wire:loading wire:target="cadastrar">ENVIANDO...</span>
                    </button>
                </div>
            </form>
            <p class="cadastro-login-link">Já é cadastrado? <a href="{{ route('login') }}">Faça o login aqui</a></p>
        </section>
    </div>
</section>
