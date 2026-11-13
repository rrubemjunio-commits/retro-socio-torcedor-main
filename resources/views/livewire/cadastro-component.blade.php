<section class="cadastro-pagina" aria-labelledby="titulo-cadastro">
    <a class="link-bloco cadastro-voltar" href="{{ route('socios.create') }}">
        <i class="bi bi-arrow-left" aria-hidden="true"></i> Voltar aos planos
    </a>

    <header class="cadastro-cabecalho">
        <span class="etiqueta">A FAMÍLIA RETRÔ CRESCE COM VOCÊ</span>
        <h1 id="titulo-cadastro">Vem ser sócio-torcedor</h1>
        <p>Seu apoio fortalece o clube. Preencha seus dados e escolha como quer viver essa paixão.</p>
        <div class="cadastro-etapas" aria-label="Etapas do cadastro">
            <span class="cadastro-etapa cadastro-etapa-ativa"><b>1</b> Seus dados</span>
            <span class="cadastro-etapa-linha" aria-hidden="true"></span>
            <span class="cadastro-etapa"><b>2</b> Seu plano</span>
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

            <div class="alert alert-danger {{ $errors->isNotEmpty() ? '' : 'd-none' }}" role="alert">
                <strong>Confira os dados informados:</strong>
                <ul class="mb-0 mt-2">@foreach($errors->all() as $erro)<li>{{ $erro }}</li>@endforeach</ul>
            </div>

            <form wire:submit="cadastrar">
                @php
                    $planos = ['Bronze', 'Prata', 'Ouro'];
                    $precosPlano = ['Bronze' => 'R$ 19,90', 'Prata' => 'R$ 39,90', 'Ouro' => 'R$ 69,90'];
                @endphp
                <div class="cadastro-campos">
                    <div class="cadastro-campo cadastro-campo-largo">
                        <label for="nome" class="form-label">Nome completo <span aria-hidden="true">*</span></label>
                        <input id="nome" name="nome" class="form-control" wire:model="nome" required maxlength="120" autocomplete="name" placeholder="Como está no seu documento">
                    </div>
                    <div class="cadastro-campo">
                        <label for="cpf" class="form-label">CPF <span aria-hidden="true">*</span></label>
                        <input id="cpf" name="cpf" class="form-control" wire:model="cpf" required minlength="11" maxlength="11" inputmode="numeric" pattern="[0-9]{11}" autocomplete="off" placeholder="Somente os 11 números" aria-describedby="ajuda-cpf">
                        <small id="ajuda-cpf">Não use pontos ou traço.</small>
                    </div>
                    <div class="cadastro-campo">
                        <label for="telefone" class="form-label">Celular / telefone <span aria-hidden="true">*</span></label>
                        <input id="telefone" type="tel" name="telefone" class="form-control" wire:model="telefone" required maxlength="20" autocomplete="tel" placeholder="(00) 00000-0000">
                    </div>
                    <div class="cadastro-campo">
                        <label for="email" class="form-label">E-mail</label>
                        <input id="email" type="email" name="email" class="form-control" wire:model="email" maxlength="150" autocomplete="email" placeholder="voce@email.com">
                        <small>Opcional, mas ajuda a manter você por dentro.</small>
                    </div>
                    <div class="cadastro-campo">
                        <label for="data_nascimento" class="form-label">Data de nascimento <span aria-hidden="true">*</span></label>
                        <input id="data_nascimento" type="date" name="data_nascimento" class="form-control" wire:model="data_nascimento" required autocomplete="bday">
                    </div>
                    <div class="cadastro-campo cadastro-campo-largo">
                        <label for="plano" class="form-label">Escolha seu plano <span aria-hidden="true">*</span></label>
                        <select id="plano" name="plano" class="form-select" wire:model="plano" required>
                            <option value="">Selecione o plano ideal para você</option>
                            @foreach($planos as $opcao)
                                <option value="{{ $opcao }}" {{ $plano === $opcao ? 'selected' : '' }}>{{ $opcao }} — {{ $precosPlano[$opcao] }} / mês</option>
                            @endforeach
                        </select>
                        <small>Valores e benefícios são sugestões ilustrativas, sem cobrança real.</small>
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
