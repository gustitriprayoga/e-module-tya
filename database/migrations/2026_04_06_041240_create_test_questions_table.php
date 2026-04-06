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
        Schema::create('test_questions', function (Blueprint $table) {
           $table->id();
            $table->enum('type', ['pre_test', 'post_test']);
            $table->enum('indicator', [
                'Main Idea', 
                'Specific Information', 
                'Inference', 
                'Vocabulary in Context', 
                'Reference Identification'
            ]);
            $table->text('question_text');
            $table->json('options');
            $table->string('correct_answer', 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_questions');
    }
};
