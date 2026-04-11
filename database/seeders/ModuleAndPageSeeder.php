<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Page;
use App\Models\Block;

class ModuleAndPageSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. INISIALISASI 4 MODUL (1 Aktif, 3 Belum Rilis)
        // ==========================================

        $module1 = Module::updateOrCreate(
            ['slug' => 'reading-ii-speed-reading'],
            [
                'title' => 'Reading II: Speed Reading',
                'description' => 'A comprehensive 25-page interactive module designed to master skimming, scanning, and critical reading techniques.',
                'is_published' => true,
                'order' => 1
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'advanced-skimming-strategies'],
            [
                'title' => 'Advanced Skimming Strategies',
                'description' => 'Learn how to identify key concepts in seconds and navigate through dense academic papers effortlessly.',
                'is_published' => false, // BELUM RILIS
                'order' => 2
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'critical-analysis-academic-texts'],
            [
                'title' => 'Critical Analysis of Texts',
                'description' => 'Deconstruct arguments, evaluate evidence, and spot logical fallacies in complex journals.',
                'is_published' => false, // BELUM RILIS
                'order' => 3
            ]
        );

        Module::updateOrCreate(
            ['slug' => 'synthesis-mastery'],
            [
                'title' => 'Synthesis Mastery',
                'description' => 'Master the art of combining multiple sources and perspectives into a single coherent understanding.',
                'is_published' => false, // BELUM RILIS
                'order' => 4
            ]
        );

        // ==========================================
        // 2. DATA KONTEN (Hanya diisi ke Modul 1 yang aktif)
        // ==========================================
        $pagesContent = [
            ['title' => 'Introduction to Speed Reading', 'content' => 'Speed reading is not just about moving your eyes faster; it is about processing information efficiently. Many students struggle with <b>comprehension</b> when they try to accelerate.'],
            ['title' => 'The Myth of Sub-vocalization', 'content' => 'Sub-vocalization is the habit of pronouncing words in your head. To <b>mitigate</b> this, you must learn to visualize phrases instead of individual letters.'],
            ['title' => 'Understanding Eye Fixations', 'content' => 'Your eyes do not move smoothly across a line. They jump in "saccades". Minimizing these fixations is key to <b>accelerating</b> your pace.'],
            ['title' => 'The Power of Skimming', 'content' => '<b>Skimming</b> allows you to get the "big picture" of a text. Look at headings, first sentences, and bold words to <b>synthesize</b> the main idea quickly.'],
            ['title' => 'Techniques for Scanning', 'content' => 'Unlike skimming, <b>scanning</b> is used when you need a specific date, name, or statistic. It is a targeted search through the <b>climate</b> of the text.'],
            ['title' => 'Meta Guiding with a Pointer', 'content' => 'Using your finger or a pen as a guide helps maintain focus and prevents regression, which often hinders <b>comprehension</b>.'],
            ['title' => 'Peripheral Vision Training', 'content' => 'Expanding your peripheral vision allows you to read blocks of words. This technique is vital for <b>deconstruct</b>-ing complex paragraphs.'],
            ['title' => 'Breaking the Regressive Habit', 'content' => 'Regression is re-reading words you have already passed. This habit is often caused by a lack of confidence in your initial <b>inference</b>.'],
            ['title' => 'Reading Groups of Words', 'content' => 'Instead of reading "The-cat-sat-on-the-mat", try to see the whole phrase as one image. This helps in <b>synthesize</b>-ing information faster.'],
            ['title' => 'The Importance of Focus', 'content' => 'External distractions <b>mitigate</b> your ability to maintain a high WPM (Words Per Minute). Preparation of your environment is key.'],
            ['title' => 'Identifying Signal Words', 'content' => 'Words like "however", "therefore", and "consequently" signal a shift in the author\'s argument.'],
            ['title' => 'The SQ3R Method', 'content' => 'Survey, Question, Read, Recite, and Review. This method ensures deep <b>comprehension</b>.'],
            ['title' => 'Critical Reading Skills', 'content' => 'Do not just read; evaluate. <b>Deconstruct</b> the author\'s bias and evidence.'],
            ['title' => 'Vocabulary Expansion', 'content' => 'A limited vocabulary acts as a speed bump. Use your vault to <b>mitigate</b> language barriers.'],
            ['title' => 'Contextual Clues', 'content' => 'When you meet an unknown word, use <b>inference</b> based on the surrounding sentences.'],
            ['title' => 'Note-taking while Reading', 'content' => 'Brief notes help you <b>synthesize</b> the text later for exams.'],
            ['title' => 'Fact vs Opinion', 'content' => 'Speed reading requires quick <b>inference</b> to distinguish what is proven from what is felt.'],
            ['title' => 'Reading Academic Journals', 'content' => 'Journals require a mix of <b>skimming</b> for the abstract and <b>scanning</b> for the data.'],
            ['title' => 'The Role of Prior Knowledge', 'content' => 'The more you know about a topic, the faster your <b>comprehension</b> will be.'],
            ['title' => 'Summarizing Paragraphs', 'content' => 'Try to summarize each page in one sentence to ensure you aren\'t just "gazing" at words.'],
            ['title' => 'Managing Complex Sentences', 'content' => 'Long sentences can be <b>deconstruct</b>-ed by finding the main subject and verb first.'],
            ['title' => 'Reading on Digital Screens', 'content' => 'Backlit screens can cause fatigue. <b>Mitigate</b> eye strain by adjusting brightness.'],
            ['title' => 'Synthesizing Multiple Sources', 'content' => 'Learn to <b>synthesize</b> information from different authors to form a complete view.'],
            ['title' => 'Final Speed Drills', 'content' => 'Practice with easy material first to build your <b>accelerating</b> rhythm.'],
            ['title' => 'Review and Self-Reflection', 'content' => 'Reflect on your progress. Has your <b>comprehension</b> improved alongside your speed?']
        ];

        foreach ($pagesContent as $index => $data) {
            $pageNum = $index + 1;

            $page = Page::updateOrCreate(
                ['module_id' => $module1->id, 'order_number' => $pageNum],
                ['title' => $data['title'], 'is_published' => true]
            );

            Block::create([
                'page_id' => $page->id,
                'type' => 'reading_text',
                'sort_order' => 1,
                'content' => ['text' => $data['content']],
                'settings' => ['target_wpm' => 200 + ($pageNum * 5), 'has_timer' => ($pageNum % 5 == 0)]
            ]);

            if ($pageNum % 4 == 0) {
                Block::create([
                    'page_id' => $page->id,
                    'type' => 'quiz',
                    'sort_order' => 2,
                    'content' => [
                        'text' => 'Berdasarkan teks di atas, apa langkah terbaik untuk meningkatkan pemahaman Anda?',
                        'options' => [
                            ['answer' => 'Membaca kata demi kata secara perlahan.', 'is_correct' => false],
                            ['answer' => 'Melakukan sintesis ide utama dari setiap paragraf.', 'is_correct' => true],
                            ['answer' => 'Mengabaikan semua tanda baca.', 'is_correct' => false],
                        ]
                    ]
                ]);
            }
        }

        $this->command->info('Seed: 4 Modules created (1 Active, 3 Upcoming). 25 Pages populated for Reading II.');
    }
}
