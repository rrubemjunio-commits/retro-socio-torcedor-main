<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProtectedPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitantes_sao_redirecionados_ao_login_nas_telas_protegidas(): void
    {
        foreach ([
            'socios.index',
            'produtos.index',
            'produtos.create',
            'categorias.index',
            'categorias.create',
        ] as $route) {
            $this->get(route($route))->assertRedirect(route('login'));
        }
    }

    public function test_rotas_de_cadastro_de_produtos_e_categorias_exigem_login(): void
    {
        $this->post(route('produtos.store'))->assertRedirect(route('login'));
        $this->post(route('categorias.store'))->assertRedirect(route('login'));
    }

    public function test_visitante_e_redirecionado_ao_cadastro_ao_tentar_assinar_plano(): void
    {
        $this->get(route('pagamento.show', ['plano' => 'Prata']))
            ->assertRedirect(route('socios.form'));
    }

    public function test_usuario_autenticado_pode_acessar_dashboard_catalogo_e_categorias(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('socios.index'))
            ->assertOk();

        $this->get(route('produtos.index'))->assertOk();
        $this->get(route('categorias.index'))->assertOk();
    }

    public function test_menu_de_dashboard_e_catalogo_nao_aparece_para_visitantes(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Painel de controle')
            ->assertDontSee('Produtos e benefícios');
    }
}
