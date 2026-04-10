<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vocabulary;
use App\Models\Question;
use App\Models\Test;

class VocabularyAndTestSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. SEEDING VOCABULARY (Global)
        // ==========================================
        $vocabularies = [
            ['word' => 'Comprehension', 'definition' => 'The action or capability of understanding something.', 'context' => 'Reading comprehension is crucial for academic success.'],
            ['word' => 'Synthesize', 'definition' => 'Combine a number of things into a coherent whole.', 'context' => 'Students must synthesize information from various sources.'],
            ['word' => 'Deconstruct', 'definition' => 'Analyze a text or linguistic or conceptual system.', 'context' => 'We need to deconstruct the author’s argument.'],
            ['word' => 'Inference', 'definition' => 'A conclusion reached on the basis of evidence and reasoning.', 'context' => 'Making inferences requires reading between the lines.'],
        ];

        foreach ($vocabularies as $vocab) {
            // Disesuaikan: module_id dihapus, ditambahkan level dan category standar
            Vocabulary::firstOrCreate(
                ['word' => strtolower($vocab['word'])],
                [
                    'definition' => $vocab['definition'],
                    'context_sentence' => $vocab['context'],
                    'level' => 'General',
                    'category' => 'noun'
                ]
            );
        }

        // ==========================================
        // 2. MEMBUAT PRE-TEST (Sebagai Wadah)
        // ==========================================
        $preTest = Test::firstOrCreate(
            ['type' => 'pre-test'],
            [
                'title' => 'Pre-Test: Speed Reading Module',
                'duration' => 60,
                'passing_score' => 70,
                'is_active' => true
            ]
        );

        // ==========================================
        // 3. SEEDING BANK SOAL & MENGHUBUNGKANNYA KE TES
        // ==========================================
        $questions = [
            [
                'indicator' => 'Main Idea',
                'question_text' => 'What is the primary message the author intends to convey in paragraph 2?',
                'options' => ['A' => 'Global warming causes', 'B' => 'Economic impacts', 'C' => 'Technological solutions', 'D' => 'Historical weather patterns', 'E' => 'None of the above'],
                'correct_answer' => 'A'
            ],
            [
                'indicator' => 'Supporting Detail',
                'question_text' => 'According to the text, in what year did the industrial revolution significantly impact carbon emissions?',
                'options' => ['A' => '1750', 'B' => '1850', 'C' => '1950', 'D' => '2000', 'E' => '2010'],
                'correct_answer' => 'B'
            ],
            [
                'indicator' => 'Inference',
                'question_text' => 'It can be inferred from the passage that the author believes...',
                'options' => ['A' => 'Immediate action is required', 'B' => 'The situation will resolve itself', 'C' => 'Technology alone cannot help', 'D' => 'Governments are overreacting', 'E' => 'Scientists are manipulating data'],
                'correct_answer' => 'A'
            ],
            [
                'indicator' => 'Vocabulary in Context',
                'question_text' => 'The word "mitigate" in line 15 is closest in meaning to...',
                'options' => ['A' => 'Worsen', 'B' => 'Alleviate', 'C' => 'Ignore', 'D' => 'Complicate', 'E' => 'Produce'],
                'correct_answer' => 'B'
            ],
            [
                'indicator' => 'Reference',
                'question_text' => 'The pronoun "they" in paragraph 4 refers to...',
                'options' => ['A' => 'The researchers', 'B' => 'The emissions', 'C' => 'The solutions', 'D' => 'The climate models', 'E' => 'The political leaders'],
                'correct_answer' => 'A'
            ]
        ];

        foreach ($questions as $q) {
            // A. Simpan teks pertanyaan ke tabel `questions`
            $question = Question::firstOrCreate(
                ['question_text' => $q['question_text']],
                ['indicator' => $q['indicator']]
            );

            // B. Simpan opsi A-E ke tabel `question_options`
            // Bersihkan opsi lama dulu untuk mencegah duplikasi jika seeder dijalankan ulang
            $question->options()->delete();

            foreach ($q['options'] as $key => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => ($key === $q['correct_answer'])
                ]);
            }

            // C. Hubungkan soal ini ke Pre-test (Pivot Tabel)
            if (!$preTest->questions()->where('question_id', $question->id)->exists()) {
                $preTest->questions()->attach($question->id);
            }
        }
    }
}
