<?php

namespace Tests\Feature;

use App\Models\ReservaIngresso;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngressoTest extends TestCase
{
    use RefreshDatabase;

    public function test_tela_de_ingressos_exibe_formularios_de_reserva(): void
    {
        $this->get(route('ingressos.index'))
            ->assertOk()
            ->assertSee(route('ingressos.store'), false)
            ->assertSee('Reservar ingresso')
            ->assertSee('Meia-entrada');
    }

    public function test_reserva_registra_valor_calculado_no_servidor(): void
    {
        $usuario = User::factory()->create();

        $this->actingAs($usuario)->post(route('ingressos.store'), [
            'jogo' => 'nautico',
            'tipo' => 'meia',
            'quantidade' => 2,
            'valor_unitario' => 0,
        ])
            ->assertRedirect(route('ingressos.index'))
            ->assertSessionHas('sucesso');

        $reserva = ReservaIngresso::firstOrFail();

        $this->assertSame($usuario->id, $reserva->user_id);
        $this->assertSame('Náutico', $reserva->adversario);
        $this->assertSame('2026-11-28', $reserva->data_jogo->format('Y-m-d'));
        $this->assertSame('meia', $reserva->tipo);
        $this->assertSame(2, $reserva->quantidade);
        $this->assertSame('20.00', $reserva->valor_unitario);
        $this->assertSame('40.00', $reserva->valor_total);
    }

    public function test_reserva_rejeita_jogo_invalido_e_quantidade_acima_do_limite(): void
    {
        $this->actingAs(User::factory()->create())
            ->from(route('ingressos.index'))
            ->post(route('ingressos.store'), [
                'jogo' => 'jogo-inexistente',
                'tipo' => 'inteira',
                'quantidade' => 7,
            ])
            ->assertRedirect(route('ingressos.index'))
            ->assertSessionHasErrors(['jogo', 'quantidade']);

        $this->assertDatabaseCount('reservas_ingressos', 0);
    }

    public function test_visitante_e_redirecionado_ao_cadastro_ao_reservar_ingresso(): void
    {
        $this->post(route('ingressos.store'), [
            'jogo' => 'nautico',
            'tipo' => 'inteira',
            'quantidade' => 1,
        ])->assertRedirect(route('socios.form'));

        $this->assertDatabaseCount('reservas_ingressos', 0);
    }

    public function test_dashboard_lista_todas_as_reservas_e_identifica_compradores(): void
    {
        $usuario = User::factory()->create([
            'name' => 'Torcedor do Retrô',
            'email' => 'torcedor@example.com',
        ]);

        ReservaIngresso::create([
            'user_id' => $usuario->id,
            'adversario' => 'Náutico',
            'data_jogo' => '2026-11-28',
            'horario' => '16h',
            'estadio' => 'Arena de Pernambuco',
            'tipo' => 'inteira',
            'quantidade' => 2,
            'valor_unitario' => 40,
            'valor_total' => 80,
        ]);

        ReservaIngresso::create([
            'adversario' => 'Santa Cruz',
            'data_jogo' => '2026-12-12',
            'horario' => '18h30',
            'estadio' => 'Arena de Pernambuco',
            'tipo' => 'meia',
            'quantidade' => 1,
            'valor_unitario' => 25,
            'valor_total' => 25,
        ]);

        $this->actingAs($usuario)
            ->get(route('socios.index'))
            ->assertOk()
            ->assertSee('Ingressos reservados')
            ->assertSee('Torcedor do Retrô')
            ->assertSee('torcedor@example.com')
            ->assertSee('Visitante')
            ->assertSee('Náutico')
            ->assertSee('Santa Cruz')
            ->assertSee('Meia-entrada')
            ->assertSee('R$ 80,00')
            ->assertSee('R$ 25,00');
    }
}
