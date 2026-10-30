<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 120);
            $table->char('cpf', 11)->unique();
            $table->string('telefone', 20);
            $table->string('email', 150)->nullable();
            $table->date('data_nascimento');
            $table->string('plano', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
