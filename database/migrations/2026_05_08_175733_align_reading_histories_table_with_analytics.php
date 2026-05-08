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
        Schema::table('reading_histories', function (Blueprint $table) {
            // Rename columns to match TestResult component expectations
            // Note: wpm_result and duration_seconds are what currently exist in the table
            $table->renameColumn('wpm_result', 'wpm');
            
            // Checking if duration_seconds or reading_time_seconds exists
            // The first migration used duration_seconds
            $table->renameColumn('duration_seconds', 'time_spent');
            
            // Make block_id nullable for module-level analytics
            $table->foreignId('block_id')->nullable()->change();
            
            // Add missing columns
            $table->integer('total_words')->default(0);
            $table->integer('quiz_correct')->nullable();
            $table->integer('quiz_total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reading_histories', function (Blueprint $table) {
            $table->renameColumn('wpm', 'wpm_result');
            $table->renameColumn('time_spent', 'duration_seconds');
            $table->foreignId('block_id')->nullable(false)->change();
            $table->dropColumn(['total_words', 'quiz_correct', 'quiz_total']);
        });
    }
};
