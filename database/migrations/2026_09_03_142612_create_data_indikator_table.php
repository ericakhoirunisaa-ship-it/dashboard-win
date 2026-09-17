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
        Schema::create('data_indikator', function (Blueprint $table) {
            $table->id();

            $table->foreignId('indikator_id')
                ->constrained('indikator')
                ->cascadeOnDelete();

            $table->foreignId('periode_id')
                ->constrained('periode')
                ->cascadeOnDelete();

            $table->foreignId('sumber_data_id')
                ->constrained('sumber_data')
                ->cascadeOnDelete();

            $table->decimal('nilai', 20, 4);
            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->unique(['indikator_id', 'periode_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_indikator');
    }
};