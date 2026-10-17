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
        if (!Schema::hasTable('tb_avaliacao')) {
            return;
        }

        if (!Schema::hasColumn('tb_avaliacao', 'id_proposta')) {
            Schema::table('tb_avaliacao', function (Blueprint $table) {
                $table->integer('id_proposta')->nullable()->after('id_avaliacao')->index();
                $table->integer('id_avaliador')->nullable()->after('id_proposta')->index();
                $table->integer('id_avaliado')->nullable()->after('id_avaliador')->index();

                $table->foreign('id_proposta')
                    ->references('id_proposta')
                    ->on('tb_proposta')
                    ->onDelete('cascade');

                $table->foreign('id_avaliador')
                    ->references('id_usuario')
                    ->on('tb_usuario')
                    ->onDelete('cascade');

                $table->foreign('id_avaliado')
                    ->references('id_usuario')
                    ->on('tb_usuario')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('tb_avaliacao')) {
            return;
        }

        if (Schema::hasColumn('tb_avaliacao', 'id_proposta')) {
            Schema::table('tb_avaliacao', function (Blueprint $table) {
                $table->dropForeign(['id_proposta']);
                $table->dropForeign(['id_avaliador']);
                $table->dropForeign(['id_avaliado']);

                $table->dropColumn(['id_proposta', 'id_avaliador', 'id_avaliado']);
            });
        }
    }
};
