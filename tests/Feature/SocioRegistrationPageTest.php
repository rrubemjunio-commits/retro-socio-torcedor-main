<?php

namespace Tests\Feature;

use Tests\TestCase;

class SocioRegistrationPageTest extends TestCase
{
    public function test_plan_page_links_to_registration_in_a_separate_tab(): void
    {
        $this->get(route('socios.create'))
            ->assertOk()
            ->assertDontSee('name="cpf"', false)
            ->assertSee('target="_blank"', false)
            ->assertSee(route('socios.form', ['plano' => 'Bronze']), false);
    }

    public function test_registration_page_preselects_the_requested_plan(): void
    {
        $this->get(route('socios.form', ['plano' => 'Prata']))
            ->assertOk()
            ->assertSee('name="cpf"', false)
            ->assertSee('value="Prata" selected', false);
    }

    public function test_top_navigation_registration_link_opens_the_registration_form(): void
    {
        $this->get(route('socios.create'))
            ->assertOk()
            ->assertSee('href="' . route('socios.form') . '"', false);
    }

    public function test_homepage_shows_sidebar_links_without_games_and_tickets_top_shortcuts(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="' . route('jogos.index') . '"', false)
            ->assertSee('href="' . route('ingressos.index') . '"', false)
            ->assertDontSee('href="' . route('home') . '#jogos"', false)
            ->assertDontSee('href="' . route('home') . '#ingressos"', false)
            ->assertSee('images/retro-futebol-clube-2023-logo-png_seeklogo-466412-removebg-preview.png', false);
    }

    public function test_games_and_tickets_have_separate_pages_and_sidebar_links(): void
    {
        $this->get(route('jogos.index'))
            ->assertOk()
            ->assertSee('Jogos')
            ->assertSee('href="' . route('jogos.index') . '"', false);

        $this->get(route('ingressos.index'))
            ->assertOk()
            ->assertSee('Ingressos')
            ->assertSee('href="' . route('ingressos.index') . '"', false);
    }

    public function test_tickets_page_shows_two_fictional_matches_and_prices_without_seat_maps(): void
    {
        $this->get(route('ingressos.index'))
            ->assertOk()
            ->assertSee('Náutico')
            ->assertSee('Santa Cruz')
            ->assertSee('Arena de Pernambuco')
            ->assertSee('R$ 40,00')
            ->assertSee('R$ 20,00')
            ->assertSee('R$ 50,00')
            ->assertSee('R$ 25,00')
            ->assertSee('images/Simbolo-escudo-nautico.png', false)
            ->assertSee('images/Santa_Cruz_Futebol_Clube_logo.svg.webp', false)
            ->assertSee('Datas e valores são apenas exemplos.')
            ->assertSee('Comprar ingresso')
            ->assertSee('ingresso-comprar', false)
            ->assertSee('data-bs-toggle="modal"', false)
            ->assertSee('A compra de ingressos estará disponível em breve.')
            ->assertDontSee('JOGO FICTÍCIO')
            ->assertDontSee('Trabalho demonstrativo')
            ->assertDontSee('data-mapa', false)
            ->assertDontSee('data-assento', false);
    }
}
