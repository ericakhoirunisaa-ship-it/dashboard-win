<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('data_indikator', function (Blueprint $table) {
            $table->foreignId('kategori_indikator_id')
                ->nullable()
                ->after('indikator_id')
                ->constrained('kategori_indikator')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('data_indikator', function (Blueprint $table) {
            $table->dropForeign([
                'kategori_indikator_id'
            ]);

            $table->dropColumn('kategori_indikator_id');
        });
    }
};