<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
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

    public function test_cadastro_sem_plano_cria_apenas_usuario(): void
    {
        $email = 'cadastro-sem-plano-' . uniqid() . '@example.com';

        $this->post('/cadastro', [
            'plano' => null,
            'nome' => 'Usuario Sem Plano',
            'cpf' => '12345678001',
            'telefone' => '81999990001',
            'email' => $email,
            'data_nascimento' => '1990-01-01',
            'password' => 'Senha123!',
            'password_confirmation' => 'Senha123!',
        ]);

        $this->assertDatabaseHas('users', ['email' => $email]);
        $this->assertDatabaseMissing('socios', ['email' => $email]);
    }

    public function test_cadastro_com_plano_cria_usuario_e_socio(): void
    {
        $email = 'cadastro-com-plano-' . uniqid() . '@example.com';

        $this->post('/cadastro', [
            'plano' => 'Ouro',
            'nome' => 'Usuario Com Plano',
            'cpf' => '12345678002',
            'telefone' => '81999990002',
            'email' => $email,
            'data_nascimento' => '1990-02-02',
            'password' => 'Senha123!',
            'password_confirmation' => 'Senha123!',
        ]);

        $this->assertDatabaseHas('users', ['email' => $email, 'plano' => 'Ouro']);
        $this->assertDatabaseHas('socios', ['email' => $email, 'plano' => 'Ouro']);
    }

    public function test_tela_demonstrativa_de_pagamento_exibe_opcoes_e_cupom(): void
    {
        $response = $this->get('/pagamento/Prata');

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
        $this->get('/pagamento/Platina')->assertNotFound();
    }
}
