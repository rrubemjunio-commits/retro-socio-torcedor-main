<?php

namespace Tests\Feature;

use App\Models\Socio;
use App\Models\User;
use Database\Seeders\CatalogSeeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProdutoCatalogoTest extends TestCase
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
            $table->string('papel')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::connection('sqlite')->create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('icone')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection('sqlite')->create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('empresa_id')->nullable();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('valor', 8, 2);
            $table->string('imagem')->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('disponivel')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::connection('sqlite')->create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cpf', 11)->unique();
            $table->string('telefone');
            $table->string('email')->nullable();
            $table->date('data_nascimento');
            $table->string('plano');
            $table->timestamps();
        });
    }

    public function test_catalog_displays_consumption_categories_and_products(): void
    {
        $this->seed(CatalogSeeder::class);

        $this->get(route('produtos.index'))
            ->assertOk()
            ->assertSee('Bebidas')
            ->assertSee('Lanches')
            ->assertSee('Acompanhamentos')
            ->assertSee('Hambúrguer Retrô')
            ->assertSee('Água mineral')
            ->assertSee('Batata frita');
    }

    public function test_coupon_codes_are_hidden_from_guests(): void
    {
        $this->get(route('produtos.index', ['aba' => 'cupons']))
            ->assertOk()
            ->assertSee('Tem desconto esperando por você!')
            ->assertDontSee('BEBIDA10')
            ->assertDontSee('COMBO8');
    }

    public function test_coupon_codes_are_visible_to_a_user_registered_as_a_member(): void
    {
        $user = User::create([
            'name' => 'Torcedor',
            'email' => 'torcedor@example.com',
            'password' => 'senha-segura',
            'ativo' => true,
        ]);

        Socio::create([
            'nome' => 'Torcedor',
            'cpf' => '12345678901',
            'telefone' => '81999999999',
            'email' => $user->email,
            'data_nascimento' => '1990-01-01',
            'plano' => 'Ouro',
        ]);

        $this->actingAs($user)
            ->get(route('produtos.index', ['aba' => 'cupons']))
            ->assertOk()
            ->assertSee('BEBIDA10')
            ->assertSee('COMBO8');
    }

    public function test_coupon_codes_are_hidden_from_logged_in_non_members(): void
    {
        $user = User::create([
            'name' => 'Visitante',
            'email' => 'visitante@example.com',
            'password' => 'senha-segura',
            'ativo' => true,
        ]);

        $this->actingAs($user)
            ->get(route('produtos.index', ['aba' => 'cupons']))
            ->assertOk()
            ->assertSee('Tem desconto esperando por você!')
            ->assertDontSee('BEBIDA10')
            ->assertDontSee('COMBO8');
    }
}
