<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->char('cpf', 11)->nullable()->unique()->after('email');
            $table->string('telefone', 20)->nullable()->after('cpf');
            $table->date('data_nascimento')->nullable()->after('telefone');
            $table->string('plano', 20)->nullable()->after('data_nascimento');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['cpf']);
            $table->dropColumn(['cpf', 'telefone', 'data_nascimento', 'plano']);
        });
    }
};
