<?php

namespace Tests\Feature;

use App\Livewire\CadastroComponent;
use App\Models\Socio;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Livewire\Livewire;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_cadastro_sem_plano_cria_usuario_mas_nao_cria_socio(): void
    {
        $email = 'cadastro-sem-plano-'.uniqid().'@example.com';

        $response = $this->post('/cadastro', [
            'nome' => 'Usuario Sem Plano',
            'cpf' => '12345678001',
            'telefone' => '81999990001',
            'email' => $email,
            'data_nascimento' => '1990-01-01',
            'password' => 'Senha123!',
            'password_confirmation' => 'Senha123!',
        ]);

        $response->assertRedirect(route('socios.create'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => $email]);
        $this->assertDatabaseMissing('socios', ['email' => $email]);
    }

    public function test_formulario_de_cadastro_nao_exibe_selecao_de_plano(): void
    {
        $this->get(route('socios.form'))
            ->assertOk()
            ->assertDontSee('Escolha seu plano')
            ->assertDontSee('wire:model="plano"', false);
    }

    public function test_cadastro_pelo_formulario_livewire_cria_usuario_sem_criar_socio(): void
    {
        $email = 'cadastro-livewire-'.uniqid().'@example.com';

        Livewire::test(CadastroComponent::class)
            ->set('nome', 'Usuario Livewire')
            ->set('cpf', '12345678002')
            ->set('telefone', '81999990002')
            ->set('email', $email)
            ->set('data_nascimento', '1990-02-02')
            ->set('password', 'Senha123!')
            ->set('password_confirmation', 'Senha123!')
            ->call('cadastrar')
            ->assertHasNoErrors()
            ->assertRedirect(route('socios.create'));

        $this->assertDatabaseHas('users', ['email' => $email, 'plano' => null]);
        $this->assertDatabaseMissing('socios', ['email' => $email]);
    }

    public function test_tela_demonstrativa_de_pagamento_exibe_opcoes_e_cupom(): void
    {
        $response = $this->actingAs(User::factory()->create())->get('/pagamento/Prata');

        $response->assertOk()
            ->assertSee('Plano Prata')
            ->assertSee('Cartão')
            ->assertSee('Pix')
            ->assertSee('Boleto')
            ->assertSee('RETRO10')
            ->assertSee('nenhuma cobrança real será processada')
            ->assertSee('Aprovar assinatura (simulação)');
    }

    public function test_tela_demonstrativa_nao_aceita_plano_invalido(): void
    {
        $this->actingAs(User::factory()->create())->get('/pagamento/Platina')->assertNotFound();
    }

    public function test_aprovacao_simulada_cria_socio_ativa_plano_e_exibe_selo_vip(): void
    {
        $usuario = User::factory()->create([
            'name' => 'Torcedor VIP',
            'cpf' => '12345678901',
            'telefone' => '81999990000',
            'data_nascimento' => '1990-01-01',
            'plano' => null,
        ]);

        $this->actingAs($usuario)
            ->post(route('pagamento.confirmar', ['plano' => 'Ouro']), ['metodo' => 'pix'])
            ->assertRedirect(route('socios.index'));

        $this->assertDatabaseHas('users', ['id' => $usuario->id, 'plano' => 'Ouro']);
        $this->assertDatabaseHas('socios', ['cpf' => '12345678901', 'plano' => 'Ouro']);
        $this->assertSame(1, Socio::where('cpf', '12345678901')->count());

        $this->get(route('socios.index'))->assertSee('Torcedor VIP')->assertSee('Ouro');
        $this->get(route('home'))->assertSee('Sócio VIP')->assertSee('VIP');
    }

    public function test_socio_sem_plano_nao_aparece_na_lista_do_painel(): void
    {
        Socio::create([
            'nome' => 'Cadastro pendente',
            'cpf' => '12345678903',
            'telefone' => '81999990002',
            'data_nascimento' => '1990-01-01',
            'plano' => null,
        ]);

        $this->actingAs(User::factory()->create())
            ->get(route('socios.index'))
            ->assertDontSee('Cadastro pendente')
            ->assertSee('Nenhuma assinatura cadastrada ainda.');
    }

    public function test_aprovacao_com_metodo_invalido_nao_cria_socio(): void
    {
        $usuario = User::factory()->create([
            'cpf' => '12345678902',
            'telefone' => '81999990001',
            'data_nascimento' => '1990-01-01',
        ]);

        $this->actingAs($usuario)
            ->from(route('pagamento.show', ['plano' => 'Prata']))
            ->post(route('pagamento.confirmar', ['plano' => 'Prata']), ['metodo' => 'desconhecido'])
            ->assertSessionHasErrors('metodo');

        $this->assertDatabaseMissing('socios', ['cpf' => '12345678902']);
        $this->assertDatabaseHas('users', ['id' => $usuario->id, 'plano' => null]);
    }
}
