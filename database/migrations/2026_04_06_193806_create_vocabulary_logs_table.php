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
        Schema::create('vocabulary_logs', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            // Menghubungkan ke tabel vocabularies
            $table->foreignId('vocabulary_id')->constrained()->cascadeOnDelete();
            // Jenis interaksi: 'view' (melihat glosarium) atau 'incorrect_quiz' (salah jawab kuis)
            $table->enum('interaction_type', ['view', 'incorrect_quiz']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vocabulary_logs');
    }
};
