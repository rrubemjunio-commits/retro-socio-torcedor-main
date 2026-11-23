@extends('layouts.app')
@section('titulo', 'Pagamento demonstrativo | Retrô FC')
@section('conteudo')
<section class="checkout-pagina" aria-labelledby="titulo-checkout">
    <a class="checkout-voltar" href="{{ route('socios.create') }}"><i class="bi bi-arrow-left" aria-hidden="true"></i> Voltar aos planos</a>
    <header class="checkout-cabecalho">
        <span class="etiqueta">QUASE LÁ, TORCEDOR</span>
        <h1 id="titulo-checkout">Finalize sua assinatura</h1>
        <p>Escolha uma forma de pagamento para o seu plano Retrô FC.</p>
        <span class="checkout-demo"><i class="bi bi-info-circle" aria-hidden="true"></i> Demonstração visual: nenhum pagamento será processado.</span>
    </header>

    <div class="checkout-grade">
        <section class="checkout-formulario" aria-labelledby="titulo-pagamento">
            <h2 id="titulo-pagamento">Forma de pagamento</h2>
            <div class="checkout-metodos" role="group" aria-label="Selecione a forma de pagamento">
                <label class="checkout-metodo">
                    <input type="radio" name="metodo" value="cartao" checked>
                    <i class="bi bi-credit-card-2-front" aria-hidden="true"></i><span>Cartão</span>
                </label>
                <label class="checkout-metodo">
                    <input type="radio" name="metodo" value="pix">
                    <i class="bi bi-qr-code" aria-hidden="true"></i><span>Pix</span>
                </label>
                <label class="checkout-metodo">
                    <input type="radio" name="metodo" value="boleto">
                    <i class="bi bi-upc" aria-hidden="true"></i><span>Boleto</span>
                </label>
            </div>

            <div class="checkout-detalhes checkout-detalhes-cartao" data-metodo="cartao">
                <div class="checkout-bandeiras" aria-label="Bandeiras ilustrativas">
                    <span>VISA</span><span>mastercard</span><span>ELO</span>
                </div>
                <label for="numero-cartao">Número do cartão</label>
                <input id="numero-cartao" class="form-control" type="text" inputmode="numeric" placeholder="0000 0000 0000 0000" autocomplete="cc-number">
                <div class="checkout-campos-duplos">
                    <div><label for="nome-cartao">Nome impresso no cartão</label><input id="nome-cartao" class="form-control" type="text" placeholder="Como aparece no cartão" autocomplete="cc-name"></div>
                    <div><label for="validade-cartao">Validade</label><input id="validade-cartao" class="form-control" type="text" placeholder="MM/AA" autocomplete="cc-exp"></div>
                </div>
                <div class="checkout-campos-duplos checkout-cvv">
                    <div><label for="cvv-cartao">Código de segurança</label><input id="cvv-cartao" class="form-control" type="text" inputmode="numeric" placeholder="CVV" autocomplete="cc-csc"></div>
                    <p><i class="bi bi-lock-fill" aria-hidden="true"></i> Ambiente demonstrativo e seguro</p>
                </div>
                <p class="checkout-recorrencia"><i class="bi bi-arrow-repeat" aria-hidden="true"></i> Cobrança recorrente mensal. Você poderá cancelar quando quiser.</p>
            </div>

            <div class="checkout-detalhes checkout-alternativo" data-metodo="pix" hidden>
                <div class="checkout-pix-icone"><i class="bi bi-qr-code" aria-hidden="true"></i></div>
                <h3>Pagamento com Pix</h3>
                <p>Ao continuar, um QR Code ilustrativo aparecerá aqui para você escanear com o aplicativo do seu banco.</p>
                <span class="checkout-prazo">Aprovação simulada em poucos segundos</span>
            </div>

            <div class="checkout-detalhes checkout-alternativo" data-metodo="boleto" hidden>
                <div class="checkout-boleto-icone"><i class="bi bi-upc" aria-hidden="true"></i></div>
                <h3>Boleto bancário</h3>
                <p>O boleto demonstrativo seria gerado após confirmar a assinatura.</p>
                <span class="checkout-prazo">Prazo de compensação ilustrativo: até 3 dias úteis</span>
            </div>

            <div class="checkout-cupom">
                <label for="codigo-cupom">Cupom de desconto</label>
                <div><input id="codigo-cupom" class="form-control" type="text" placeholder="Digite seu cupom" autocomplete="off"><button type="button" class="btn-secundario" id="aplicar-cupom">Aplicar</button></div>
                <small id="mensagem-cupom" aria-live="polite">Experimente o cupom demonstrativo RETRO10.</small>
            </div>

            <p class="checkout-aviso" id="mensagem-checkout" role="status" hidden></p>
            <button type="button" class="btn-amarelo checkout-confirmar" id="confirmar-pagamento">Simular assinatura</button>
            <p class="checkout-termos"><i class="bi bi-shield-check" aria-hidden="true"></i> Esta tela é apenas uma prévia. Não informe dados reais de pagamento.</p>
        </section>

        <aside class="checkout-resumo" aria-labelledby="titulo-resumo">
            <span class="checkout-resumo-kicker">SEU PEDIDO</span>
            <h2 id="titulo-resumo">Resumo da assinatura</h2>
            <div class="checkout-plano">
                <span class="checkout-plano-icone"><i class="bi bi-award-fill" aria-hidden="true"></i></span>
                <div><strong>Plano {{ $plano }}</strong><span>Retrô FC Sócio-Torcedor</span></div>
            </div>
            <div class="checkout-resumo-linha"><span>Mensalidade</span><strong id="subtotal" data-valor="{{ number_format($valor, 2, '.', '') }}">R$ {{ number_format($valor, 2, ',', '.') }}</strong></div>
            <div class="checkout-resumo-linha checkout-desconto" id="linha-desconto" hidden><span>Desconto RETRO10</span><strong id="valor-desconto">− R$ 0,00</strong></div>
            <div class="checkout-total"><span>Total mensal</span><strong id="total-mensal">R$ {{ number_format($valor, 2, ',', '.') }}</strong></div>
            <p class="checkout-resumo-nota">O valor é ilustrativo e não será cobrado. A assinatura e os benefícios ainda não serão ativados.</p>
            <div class="checkout-resumo-seguranca"><i class="bi bi-shield-lock" aria-hidden="true"></i><span><strong>Seus dados protegidos</strong><small>Simulação sem integração com instituições financeiras.</small></span></div>
        </aside>
    </div>
</section>

<script>
(() => {
    const metodos = document.querySelectorAll('input[name="metodo"]');
    const detalhes = document.querySelectorAll('.checkout-detalhes');
    const subtotal = Number(document.getElementById('subtotal').dataset.valor);
    const codigoCupom = document.getElementById('codigo-cupom');
    const mensagemCupom = document.getElementById('mensagem-cupom');
    const linhaDesconto = document.getElementById('linha-desconto');
    const valorDesconto = document.getElementById('valor-desconto');
    const totalMensal = document.getElementById('total-mensal');
    let descontoAplicado = false;

    const moeda = (valor) => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(valor);

    metodos.forEach((metodo) => {
        metodo.addEventListener('change', () => {
            detalhes.forEach((painel) => {
                painel.hidden = painel.dataset.metodo !== metodo.value;
            });
        });
    });

    document.getElementById('aplicar-cupom').addEventListener('click', () => {
        if (codigoCupom.value.trim().toUpperCase() !== 'RETRO10') {
            descontoAplicado = false;
            linhaDesconto.hidden = true;
            totalMensal.textContent = moeda(subtotal);
            mensagemCupom.textContent = 'Cupom não reconhecido. Tente RETRO10.';
            mensagemCupom.classList.add('checkout-erro');
            return;
        }

        descontoAplicado = true;
        const desconto = subtotal * 0.1;
        valorDesconto.textContent = `− ${moeda(desconto)}`;
        totalMensal.textContent = moeda(subtotal - desconto);
        linhaDesconto.hidden = false;
        mensagemCupom.textContent = 'Cupom RETRO10 aplicado: 10% de desconto demonstrativo.';
        mensagemCupom.classList.remove('checkout-erro');
    });

    document.getElementById('confirmar-pagamento').addEventListener('click', () => {
        const metodo = document.querySelector('input[name="metodo"]:checked').value;
        const mensagem = document.getElementById('mensagem-checkout');
        const nomeMetodo = { cartao: 'cartão', pix: 'Pix', boleto: 'boleto' }[metodo];
        mensagem.textContent = `Simulação concluída com ${nomeMetodo}${descontoAplicado ? ' e cupom de 10%' : ''}. Nenhum pagamento foi realizado.`;
        mensagem.hidden = false;
    });
})();
</script>
@endsection
