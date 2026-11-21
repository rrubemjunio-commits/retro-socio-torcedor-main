<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            $table->string('password')->nullable()->after('data_nascimento');
            $table->dropColumn('plano');
        });
    }

    public function down(): void
    {
        Schema::table('socios', function (Blueprint $table) {
            $table->string('plano', 20)->nullable()->after('data_nascimento');
            $table->dropColumn('password');
        });
    }
};
