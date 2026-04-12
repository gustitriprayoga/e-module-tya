<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vocabulary;
use App\Models\Module;
use App\Models\Page;
use App\Models\Block;
use App\Models\Test;
use App\Models\Question;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Memulai injeksi data dummy LitFlow...');

        // ==========================================
        // 1. SEEDING VOCABULARY VAULT
        // ==========================================
        $vocabularies = [
            ['word' => 'skimming', 'definition' => 'Reading rapidly in order to get a general overview of the material.', 'context' => 'Skimming is useful when you have a lot of text to review.', 'level' => 'Intermediate', 'category' => 'verb'],
            ['word' => 'scanning', 'definition' => 'Reading rapidly in order to find specific facts.', 'context' => 'Scanning helps you find dates and names quickly.', 'level' => 'Intermediate', 'category' => 'verb'],
            ['word' => 'comprehension', 'definition' => 'The ability to understand what you are reading.', 'context' => 'Speed means nothing without comprehension.', 'level' => 'Advanced', 'category' => 'noun'],
            ['word' => 'mitigate', 'definition' => 'Make less severe, serious, or painful.', 'context' => 'We must mitigate the risks of misunderstanding.', 'level' => 'Academic', 'category' => 'verb'],
        ];

        foreach ($vocabularies as $vocab) {
            Vocabulary::firstOrCreate(
                ['word' => strtolower($vocab['word'])],
                [
                    'definition' => $vocab['definition'],
                    'context_sentence' => $vocab['context'],
                    'level' => $vocab['level'],
                    'category' => $vocab['category']
                ]
            );
        }
        $this->command->info('- Vocabulary berhasil dibuat.');


        // ==========================================
        // 2. SEEDING MODULE (Mata Kuliah)
        // ==========================================
        $module = Module::firstOrCreate(
            ['slug' => 'reading-ii-speed-reading'],
            [
                'title' => 'Reading II: Speed Reading',
                'description' => 'Master the art of reading faster while maintaining high comprehension. This module is designed as an interactive book.',
                'is_published' => true,
                'order' => 1
            ]
        );


        // ==========================================
        // 3. SEEDING PAGES (Halaman / Pertemuan)
        // ==========================================
        // Halaman 1
        $page1 = Page::firstOrCreate(
            ['module_id' => $module->id, 'order_number' => 1],
            ['title' => 'Page 1: Introduction to Speed Reading', 'is_published' => true]
        );

        // Halaman 2
        $page2 = Page::firstOrCreate(
            ['module_id' => $module->id, 'order_number' => 2],
            ['title' => 'Page 2: The Core Techniques', 'is_published' => true]
        );
        $this->command->info('- Module & Pages berhasil dibuat.');


        // ==========================================
        // 4. SEEDING CONTENT BLOCKS (Materi)
        // ==========================================
        // Isi Halaman 1
        $textPage1 = "<p>Welcome to Reading II! In this module, we will explore techniques that will dramatically increase your reading speed.</p><br><p>One of the most important concepts is <b>skimming</b>. When you are skimming a text, your brain is looking for the main idea, not every single detail.</p>";

        Block::firstOrCreate(
            ['page_id' => $page1->id, 'sort_order' => 1],
            [
                'type' => 'reading_text',
                'content' => ['text' => $textPage1],
                'settings' => ['target_wpm' => 250, 'has_timer' => false]
            ]
        );

        // Isi Halaman 2
        $textPage2 = "<p>Now that you understand the basics, let's talk about finding specific information.</p><br><p><b>Scanning</b> is the process you use when looking up a word in a dictionary or a name in a directory. It is crucial to master this to mitigate time loss during exams.</p><br><p>However, always remember that speed is useless if your comprehension drops significantly.</p>";

        Block::firstOrCreate(
            ['page_id' => $page2->id, 'sort_order' => 1],
            [
                'type' => 'reading_text',
                'content' => ['text' => $textPage2],
                'settings' => ['target_wpm' => 300, 'has_timer' => false]
            ]
        );
        $this->command->info('- Content Blocks berhasil dibuat.');

        Block::create([
            'page_id' => $page2->id,
            'type' => 'quiz',
            'sort_order' => 2,
            'content' => [
                'text' => 'Based on the passage, why is scanning important for students?',
                'options' => [
                    ['answer' => 'To translate the whole text.', 'is_correct' => false],
                    ['answer' => 'To find specific information and save time.', 'is_correct' => true],
                    ['answer' => 'To read as slowly as possible.', 'is_correct' => false],
                ]
            ]
        ]);


        // ==========================================
        // 5. SEEDING PRE-TEST & PERTANYAAN
        // ==========================================
        $preTest = Test::firstOrCreate(
            ['type' => 'pre-test'],
            [
                'title' => 'Pre-Test: Speed Reading Baseline',
                'duration' => 45,
                'passing_score' => 70,
                'is_active' => true
            ]
        );

        $questionsData = [
            [
                'indicator' => 'Main Idea',
                'text' => 'What is the primary goal of Speed Reading?',
                'options' => [
                    'A' => 'To read without understanding.',
                    'B' => 'To balance fast reading with high comprehension.',
                    'C' => 'To memorize every single word.',
                    'D' => 'To read aloud faster.',
                    'E' => 'None of the above.'
                ],
                'correct' => 'B'
            ],
            [
                'indicator' => 'Vocabulary in Context',
                'text' => 'Based on common reading strategies, what does "skimming" refer to?',
                'options' => [
                    'A' => 'Looking for specific numbers.',
                    'B' => 'Reading word-by-word slowly.',
                    'C' => 'Getting the general overview of a text.',
                    'D' => 'Translating text to another language.',
                    'E' => 'Ignoring punctuation.'
                ],
                'correct' => 'C'
            ]
        ];

        foreach ($questionsData as $index => $qData) {
            $question = Question::firstOrCreate(
                ['question_text' => $qData['text']],
                ['indicator' => $qData['indicator']]
            );

            // Bersihkan opsi lama (jika ada) lalu buat baru A-E
            $question->options()->delete();
            foreach ($qData['options'] as $key => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => ($key === $qData['correct'])
                ]);
            }

            // Masukkan ke Pre-test jika belum ada
            if (!$preTest->questions()->where('question_id', $question->id)->exists()) {
                $preTest->questions()->attach($question->id, ['sort_order' => $index + 1]);
            }
        }
        $this->command->info('- Pre-Test & Bank Soal berhasil dibuat.');
        $this->command->info('✅ SEMUA DATA DUMMY BERHASIL DI-GENERATE!');
    }
}
