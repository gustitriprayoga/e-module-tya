<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Vocabulary;
use App\Models\TestQuestion;

class VocabularyAndTestSeeder extends Seeder
{
    public function run(): void
    {
        $module = Module::where('slug', 'reading-ii-speed-reading')->first();

        if (!$module) return;

        // 1. Sampel Vocabulary (Dari 3.500 Target)
        $vocabularies = [
            ['word' => 'Comprehension', 'definition' => 'The action or capability of understanding something.', 'context' => 'Reading comprehension is crucial for academic success.'],
            ['word' => 'Synthesize', 'definition' => 'Combine a number of things into a coherent whole.', 'context' => 'Students must synthesize information from various sources.'],
            ['word' => 'Deconstruct', 'definition' => 'Analyze a text or linguistic or conceptual system.', 'context' => 'We need to deconstruct the author’s argument.'],
            ['word' => 'Inference', 'definition' => 'A conclusion reached on the basis of evidence and reasoning.', 'context' => 'Making inferences requires reading between the lines.'],
        ];

        foreach ($vocabularies as $vocab) {
            Vocabulary::firstOrCreate(
                ['module_id' => $module->id, 'word' => $vocab['word']],
                ['definition' => $vocab['definition'], 'context_sentence' => $vocab['context']]
            );
        }

        // 2. Sampel Soal Pre-Test (Mewakili 5 Indikator)
        $questions = [
            [
                'indicator' => 'Main Idea',
                'question_text' => 'What is the primary message the author intends to convey in paragraph 2?',
                'options' => ['A' => 'Global warming causes', 'B' => 'Economic impacts', 'C' => 'Technological solutions', 'D' => 'Historical weather patterns'],
                'correct_answer' => 'A'
            ],
            [
                'indicator' => 'Specific Information',
                'question_text' => 'According to the text, in what year did the industrial revolution significantly impact carbon emissions?',
                'options' => ['A' => '1750', 'B' => '1850', 'C' => '1950', 'D' => '2000'],
                'correct_answer' => 'B'
            ],
            [
                'indicator' => 'Inference',
                'question_text' => 'It can be inferred from the passage that the author believes...',
                'options' => ['A' => 'Immediate action is required', 'B' => 'The situation will resolve itself', 'C' => 'Technology alone cannot help', 'D' => 'Governments are overreacting'],
                'correct_answer' => 'A'
            ],
            [
                'indicator' => 'Vocabulary in Context',
                'question_text' => 'The word "mitigate" in line 15 is closest in meaning to...',
                'options' => ['A' => 'Worsen', 'B' => 'Alleviate', 'C' => 'Ignore', 'D' => 'Complicate'],
                'correct_answer' => 'B'
            ],
            [
                'indicator' => 'Reference Identification',
                'question_text' => 'The pronoun "they" in paragraph 4 refers to...',
                'options' => ['A' => 'The researchers', 'B' => 'The emissions', 'C' => 'The solutions', 'D' => 'The climate models'],
                'correct_answer' => 'A'
            ]
        ];

        foreach ($questions as $q) {
            TestQuestion::firstOrCreate([
                'type' => 'pre_test',
                'question_text' => $q['question_text']
            ], [
                'indicator' => $q['indicator'],
                'options' => $q['options'],
                'correct_answer' => $q['correct_answer']
            ]);
        }
    }
}
