<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_indikator', function (Blueprint $table) {
            $table->id();

            $table->foreignId('indikator_id')
                ->constrained('indikator')
                ->cascadeOnDelete();

            $table->string('nama_kategori');

            $table->string('slug');

            $table->unsignedInteger('urutan')->default(1);

            $table->timestamps();

            $table->unique([
                'indikator_id',
                'slug'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_indikator');
    }
};