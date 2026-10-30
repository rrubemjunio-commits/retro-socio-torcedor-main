<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('razao_social');
            $table->string('cnpj',18)->nullable()->unique();
            $table->string('slug')->unique();

            $table->string('descricao')->nullable();

            //contato
            $table->string('whatsapp',20)->nullable();
            $table->string('email')->nullable();

            //endereço
            $table->string('cep',9)->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero',20)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf',2)->nullable();

            //visual do cardapio
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('cor_primaria',7)->nullable()->default('#000000');

            //status
            $table->boolean('ativo')->default(true);

            $table->boolean('aberto')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
