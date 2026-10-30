@extends('layouts.app')
@section('titulo', 'Planos de sócio | Retrô FC')
@section('conteudo')
<section class="planos-pagina" aria-labelledby="titulo-planos">
    <header class="planos-intro">
        <span class="etiqueta">FAÇA PARTE DA NOSSA HISTÓRIA</span>
        <h1 id="titulo-planos">Escolha como viver o Retrô FC</h1>
        <p>Planos mensais para apoiar o clube e aproveitar benefícios feitos para a torcida.</p>
        <span class="aviso-planos">Valores e benefícios são sugestões ilustrativas, não representam uma cobrança real.</span>
    </header>

    <div class="row g-4 planos-grade">
        <div class="col-12 col-lg-4">
            <article class="plano-card plano-bronze h-100">
                <div class="plano-card-topo">
                    <span class="plano-selo">Para começar</span>
                    <h2>Bronze</h2>
                    <p>Uma forma especial de estar sempre perto do clube.</p>
                    <div class="plano-preco"><strong>R$ 19,90</strong><span>/ mês</span></div>
                </div>
                <div class="plano-card-conteudo">
                    <h3>O que está incluído</h3>
                    <ul class="plano-beneficios">
                        <li>Carteirinha digital de sócio</li>
                        <li>Notícias e novidades do Retrô FC</li>
                        <li>Conteúdos especiais sobre o clube</li>
                        <li>Participação na comunidade de torcedores</li>
                    </ul>
                    <p class="plano-resumo">O primeiro passo para demonstrar sua paixão e acompanhar de perto cada novidade.</p>
                    <a class="btn-amarelo plano-escolher" href="{{ route('socios.form', ['plano' => 'Bronze']) }}" target="_blank" rel="noopener noreferrer">Escolher Bronze</a>
                </div>
            </article>
        </div>

        <div class="col-12 col-lg-4">
            <article class="plano-card plano-prata h-100">
                <div class="plano-card-topo">
                    <span class="plano-selo">Mais vantagens</span>
                    <h2>Prata</h2>
                    <p>Mais benefícios para acompanhar e apoiar o Retrô.</p>
                    <div class="plano-preco"><strong>R$ 39,90</strong><span>/ mês</span></div>
                </div>
                <div class="plano-card-conteudo">
                    <h3>Tudo do Bronze, mais</h3>
                    <ul class="plano-beneficios">
                        <li>Descontos sugeridos na loja oficial</li>
                        <li>Prioridade em promoções do clube</li>
                        <li>Acesso antecipado a novidades e campanhas</li>
                        <li>Mais conteúdos para acompanhar os bastidores</li>
                    </ul>
                    <p class="plano-resumo">Uma experiência mais completa para quem quer estar ainda mais conectado ao time.</p>
                    <a class="btn-amarelo plano-escolher" href="{{ route('socios.form', ['plano' => 'Prata']) }}" target="_blank" rel="noopener noreferrer">Escolher Prata</a>
                </div>
            </article>
        </div>

        <div class="col-12 col-lg-4">
            <article class="plano-card plano-ouro h-100">
                <div class="plano-card-topo">
                    <span class="plano-selo">Experiência completa</span>
                    <h2>Ouro</h2>
                    <p>Uma conexão ainda mais próxima com a família Retrô FC.</p>
                    <div class="plano-preco"><strong>R$ 69,90</strong><span>/ mês</span></div>
                </div>
                <div class="plano-card-conteudo">
                    <h3>Tudo do Prata, mais</h3>
                    <ul class="plano-beneficios">
                        <li>Prioridade em ações e experiências do clube</li>
                        <li>Convites para eventos exclusivos sugeridos</li>
                        <li>Conteúdos especiais para membros Ouro</li>
                        <li>Maior prioridade nas campanhas para torcedores</li>
                    </ul>
                    <p class="plano-resumo">Para quem quer apoiar com ainda mais intensidade e viver momentos especiais com o clube.</p>
                    <a class="btn-amarelo plano-escolher" href="{{ route('socios.form', ['plano' => 'Ouro']) }}" target="_blank" rel="noopener noreferrer">Escolher Ouro</a>
                </div>
            </article>
        </div>
    </div>

</section>
@endsection
