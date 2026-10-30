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
}
