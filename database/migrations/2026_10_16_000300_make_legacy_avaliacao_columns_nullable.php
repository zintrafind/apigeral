<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_avaliacao', function (Blueprint $table) {
            $table->integer('id_usuario')->nullable()->change();
            $table->integer('id_produto')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tb_avaliacao', function (Blueprint $table) {
            $table->integer('id_usuario')->nullable(false)->change();
            $table->integer('id_produto')->nullable(false)->change();
        });
    }
};