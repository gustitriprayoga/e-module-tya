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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained('modules')->cascadeOnDelete();
            $table->string('title'); // Contoh: Pre-test Reading II
            $table->enum('type', ['pre-test', 'post-test']);
            $table->integer('duration')->default(60); // Durasi dalam menit
            $table->integer('passing_score')->default(70); // KKM
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
