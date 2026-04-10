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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            // Menghubungkan hasil ke user (mahasiswa)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Menghubungkan hasil ke test tertentu (Pre-test / Post-test)
            $table->foreignId('test_id')->constrained()->onDelete('cascade');

            // Menyimpan nilai
            $table->decimal('score', 5, 2);

            // Waktu penyelesaian
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
