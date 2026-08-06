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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->unique();
            $table->string('slug')->unique();
            $table->integer('durasi');
            $table->decimal('rating', 2, 1);
            $table->text('deskripsi');
            $table->year('tahun_rilis');
            $table->text('poster');
            $table->foreignId('id_genre')->constrained('genres')->cascadeOnDelete();
            $table->string('sutradara');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
