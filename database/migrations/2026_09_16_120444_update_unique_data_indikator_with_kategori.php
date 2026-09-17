<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_indikator', function (Blueprint $table) {
            // Lepas foreign key terlebih dahulu
            $table->dropForeign('data_indikator_indikator_id_foreign');
            $table->dropForeign('data_indikator_periode_id_foreign');
            $table->dropForeign('data_indikator_sumber_data_id_foreign');
            $table->dropForeign('data_indikator_kategori_indikator_id_foreign');

            // Hapus unique index lama
            $table->dropUnique(
                'data_indikator_indikator_id_periode_id_unique'
            );

            // Buat unique index baru
            $table->unique(
                ['indikator_id', 'kategori_indikator_id', 'periode_id'],
                'data_indikator_indikator_kategori_periode_unique'
            );

            // Pasang kembali foreign key
            $table->foreign('indikator_id')
                ->references('id')
                ->on('indikator')
                ->cascadeOnDelete();

            $table->foreign('periode_id')
                ->references('id')
                ->on('periode')
                ->cascadeOnDelete();

            $table->foreign('sumber_data_id')
                ->references('id')
                ->on('sumber_data')
                ->cascadeOnDelete();

            $table->foreign('kategori_indikator_id')
                ->references('id')
                ->on('kategori_indikator')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('data_indikator', function (Blueprint $table) {
            $table->dropForeign('data_indikator_indikator_id_foreign');
            $table->dropForeign('data_indikator_periode_id_foreign');
            $table->dropForeign('data_indikator_sumber_data_id_foreign');
            $table->dropForeign('data_indikator_kategori_indikator_id_foreign');

            $table->dropUnique(
                'data_indikator_indikator_kategori_periode_unique'
            );

            $table->unique(
                ['indikator_id', 'periode_id'],
                'data_indikator_indikator_id_periode_id_unique'
            );

            $table->foreign('indikator_id')
                ->references('id')
                ->on('indikator')
                ->cascadeOnDelete();

            $table->foreign('periode_id')
                ->references('id')
                ->on('periode')
                ->cascadeOnDelete();

            $table->foreign('sumber_data_id')
                ->references('id')
                ->on('sumber_data')
                ->cascadeOnDelete();

            $table->foreign('kategori_indikator_id')
                ->references('id')
                ->on('kategori_indikator')
                ->nullOnDelete();
        });
    }
};