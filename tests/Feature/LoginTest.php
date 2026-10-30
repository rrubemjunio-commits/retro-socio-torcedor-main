<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LoginTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');

        Schema::connection('sqlite')->create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('ativo')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function test_login_page_is_available_from_navigation(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Entrar na sua conta')
            ->assertSee(route('login.store'), false);
    }

    public function test_active_user_can_log_in_and_log_out(): void
    {
        $user = User::create([
            'name' => 'Torcedor',
            'email' => 'torcedor@example.com',
            'password' => 'senha-segura',
            'ativo' => true,
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'senha-segura',
        ])->assertRedirect(route('home'))
            ->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($user);

        $this->post(route('logout'))
            ->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        User::create([
            'name' => 'Conta inativa',
            'email' => 'inativo@example.com',
            'password' => 'senha-segura',
            'ativo' => false,
        ]);

        $this->post(route('login.store'), [
            'email' => 'inativo@example.com',
            'password' => 'senha-segura',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
