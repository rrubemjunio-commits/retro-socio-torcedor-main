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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('empresa_id')
            ->nullable()->after('id')
            ->constrained('empresas')
            ->cascadeOnDelete();

            $table->string('papel',20)->default('admin')
            ->after('password');
            $table->boolean('ativo')->default(true)
            ->after('papel');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropConstrainedForeignId('empresa_id');
        $table->dropColumn(['papel', 'ativo']);
        });
    }
};
