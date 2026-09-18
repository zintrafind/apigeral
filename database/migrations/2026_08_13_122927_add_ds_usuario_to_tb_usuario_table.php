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
        Schema::table('tb_usuario', function (Blueprint $table) {
            // Cria a coluna ds_usuario na tabela tb_usuario
            $table->text('ds_usuario')->nullable()->after('nm_usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_usuario', function (Blueprint $table) {
            // Remove a coluna caso você precise fazer rollback
            $table->dropColumn('ds_usuario');
        });
    }
};
