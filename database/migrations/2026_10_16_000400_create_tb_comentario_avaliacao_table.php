<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tb_comentario_avaliacao')) {
            return;
        }

        Schema::create('tb_comentario_avaliacao', function (Blueprint $table) {
            $table->increments('id_comentario');
            $table->integer('id_avaliacao');
            $table->integer('id_usuario');
            $table->string('ds_comentario', 500);
            $table->timestamps();

            $table->foreign('id_avaliacao')
                ->references('id_avaliacao')
                ->on('tb_avaliacao')
                ->onDelete('cascade');

            $table->foreign('id_usuario')
                ->references('id_usuario')
                ->on('tb_usuario')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_comentario_avaliacao');
    }
};
