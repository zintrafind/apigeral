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
        if (Schema::hasColumn('tb_usuario', 'st_perfil_disponivel')) {
            return;
        }

        Schema::table('tb_usuario', function (Blueprint $table) {
            $table->char('st_perfil_disponivel', 1)
                ->default('A')
                ->after('st_usuario')
                ->comment('A = disponível para trocas, I = indisponível');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('tb_usuario', 'st_perfil_disponivel')) {
            return;
        }

        Schema::table('tb_usuario', function (Blueprint $table) {
            $table->dropColumn('st_perfil_disponivel');
        });
    }
};
