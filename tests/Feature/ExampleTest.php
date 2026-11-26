<?php

namespace Tests\Feature;

use App\Livewire\CadastroComponent;
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

    public function test_cadastro_sem_plano_cria_usuario_e_socio(): void
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

        $response->assertRedirect(route('socios.index'));
        $this->assertDatabaseHas('users', ['email' => $email]);
        $this->assertDatabaseHas('socios', ['email' => $email, 'plano' => null]);
    }

    public function test_formulario_de_cadastro_nao_exibe_selecao_de_plano(): void
    {
        $this->get(route('socios.form'))
            ->assertOk()
            ->assertDontSee('Escolha seu plano')
            ->assertDontSee('wire:model="plano"', false);
    }

    public function test_cadastro_pelo_formulario_livewire_cria_usuario_e_socio_sem_plano(): void
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
            ->assertRedirect(route('socios.index'));

        $this->assertDatabaseHas('users', ['email' => $email, 'plano' => null]);
        $this->assertDatabaseHas('socios', ['email' => $email, 'plano' => null]);
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
            ->assertSee('nenhum pagamento será processado');
    }

    public function test_tela_demonstrativa_nao_aceita_plano_invalido(): void
    {
        $this->actingAs(User::factory()->create())->get('/pagamento/Platina')->assertNotFound();
    }
}
