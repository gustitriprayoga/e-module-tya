<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vocabulary;
use App\Models\Question;
use App\Models\Test;
use App\Models\Module;

class VocabularyAndTestSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. SEEDING VOCABULARY (Kosa Kata Target)
        // ==========================================
        $vocabularies = [
            ['word' => 'comprehension', 'definition' => 'The action or capability of understanding something.', 'context' => 'Reading comprehension is crucial for academic success.'],
            ['word' => 'synthesize', 'definition' => 'Combine a number of things into a coherent whole.', 'context' => 'Students must synthesize information from various sources.'],
            ['word' => 'deconstruct', 'definition' => 'Analyze a text or linguistic or conceptual system.', 'context' => 'We need to deconstruct the author’s argument.'],
            ['word' => 'inference', 'definition' => 'A conclusion reached on the basis of evidence and reasoning.', 'context' => 'Making inferences requires reading between the lines.'],
            ['word' => 'mitigate', 'definition' => 'Make less severe, serious, or painful.', 'context' => 'We must mitigate the risks of climate change.'],
        ];

        foreach ($vocabularies as $vocab) {
            Vocabulary::firstOrCreate(
                ['word' => strtolower($vocab['word'])],
                [
                    'definition' => $vocab['definition'],
                    'context_sentence' => $vocab['context'],
                    'level' => 'B2',
                    'category' => 'Academic'
                ]
            );
        }

        // Ambil Modul Speed Reading dari database
        $module = Module::where('slug', 'reading-ii-speed-reading')->first();
        if (!$module) {
            $this->command->warn('Module not found. Run ModuleAndPageSeeder first!');
            return;
        }

        // ==========================================
        // BLUEPRINT INDIKATOR SOAL (Sesuai Laporan Skripsi)
        // ==========================================
        $blueprintIndicators = [
            'Identifying Main Idea',       // Item: 1, 6, 11, 16, 21, 26
            'Locating Specific Information', // Item: 2, 7, 12, 17, 22, 27
            'Making Inference',            // Item: 3, 8, 13, 18, 23, 28
            'Vocabulary in context',       // Item: 4, 9, 14, 19, 24, 29
            'Reference Identification'     // Item: 5, 10, 15, 20, 25, 30
        ];

        // ==========================================
        // 2. GENERATE PRE-TEST (30 SOAL)
        // ==========================================
        $preTest = Test::firstOrCreate(
            ['type' => 'pre-test', 'module_id' => $module->id],
            [
                'title' => 'Pre-Test: ' . $module->title,
                'duration' => 60,
                'passing_score' => 70,
                'is_active' => true
            ]
        );

        $preTest->questions()->delete(); // Bersihkan soal lama jika di-seed ulang

        // Looping 6 Teks Bacaan (Passages) x 5 Soal = 30 Soal
        for ($passageIndex = 0; $passageIndex < 6; $passageIndex++) {
            $passageNumber = $passageIndex + 1;

            // Dummy Passage Text (Nanti bisa diedit via Admin Panel)
            $passageText = "This is Reading Passage {$passageNumber} for the Pre-Test. The rapid development of technology has changed how students read. According to Dr. Smith in 2023, comprehension rates drop by 15% when reading on screens. Therefore, it is important to mitigate these effects through focused reading strategies. They suggest using the SQ3R method.";

            foreach ($blueprintIndicators as $indicatorIndex => $indicatorName) {
                // Hitung Nomor Soal (1 sampai 30)
                $questionNumber = ($passageIndex * 5) + ($indicatorIndex + 1);

                $question = $preTest->questions()->create([
                    'passage' => $passageText,
                    'question_text' => "Question {$questionNumber}: Which option best demonstrates the '{$indicatorName}' from the passage above?",
                    'indicator' => $indicatorName,
                    'explanation' => "This question evaluates the student's ability in {$indicatorName}."
                ]);

                // Buat 5 Pilihan Jawaban (A-E)
                $options = ['A', 'B', 'C', 'D', 'E'];
                $correctOptionIndex = rand(0, 4); // Acak Kunci Jawaban

                foreach ($options as $idx => $opt) {
                    $question->options()->create([
                        'option_text' => "This is option {$opt} for question {$questionNumber}",
                        'is_correct' => ($idx === $correctOptionIndex)
                    ]);
                }
            }
        }

        // ==========================================
        // 3. GENERATE POST-TEST (30 SOAL BEDA DARI PRE-TEST)
        // ==========================================
        $postTest = Test::firstOrCreate(
            ['type' => 'post-test', 'module_id' => $module->id],
            [
                'title' => 'Post-Test: ' . $module->title,
                'duration' => 60,
                'passing_score' => 80,
                'is_active' => true
            ]
        );

        $postTest->questions()->delete();

        // Looping 6 Teks Bacaan (Passages) x 5 Soal = 30 Soal
        for ($passageIndex = 0; $passageIndex < 6; $passageIndex++) {
            $passageNumber = $passageIndex + 1;

            // Dummy Passage Text untuk Post-Test (Berbeda dengan Pre-Test)
            $passageText = "This is Reading Passage {$passageNumber} for the Post-Test. Global warming impacts ocean currents. Researchers found that in 2025, sea levels rose faster than predicted. To synthesize this data, we must deconstruct the climate models. It shows a grim future if ignored.";

            foreach ($blueprintIndicators as $indicatorIndex => $indicatorName) {
                // Hitung Nomor Soal (1 sampai 30)
                $questionNumber = ($passageIndex * 5) + ($indicatorIndex + 1);

                $question = $postTest->questions()->create([
                    'passage' => $passageText,
                    'question_text' => "Question {$questionNumber}: Based on the Post-Test passage, answer this '{$indicatorName}' question.",
                    'indicator' => $indicatorName,
                    'explanation' => "Explanation for Post-Test question {$questionNumber} covering {$indicatorName}."
                ]);

                // Buat 5 Pilihan Jawaban (A-E)
                $options = ['A', 'B', 'C', 'D', 'E'];
                $correctOptionIndex = rand(0, 4);

                foreach ($options as $idx => $opt) {
                    $question->options()->create([
                        'option_text' => "This is option {$opt} for Post-Test question {$questionNumber}",
                        'is_correct' => ($idx === $correctOptionIndex)
                    ]);
                }
            }
        }

        $this->command->info('✅ Seed Success: Generated exactly 30 Pre-Test and 30 Post-Test questions strictly following the Thesis Blueprint!');
    }
}
