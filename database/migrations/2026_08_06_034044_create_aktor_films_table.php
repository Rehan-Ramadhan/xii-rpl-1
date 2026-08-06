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
        Schema::create('aktor_films', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_film')
                ->constrained('films')
                ->cascadeOnDelete();

            $table->foreignId('id_aktor')
                ->constrained('aktors')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktor_films');
    }
};
