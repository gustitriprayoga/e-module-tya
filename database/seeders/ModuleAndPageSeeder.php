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
        // 1. Buat Modul Utama
        $module = Module::firstOrCreate(
            ['slug' => 'reading-ii-speed-reading'],
            [
                'title' => 'Reading II: Speed Reading',
                'description' => 'Master skimming, scanning, and identifying main ideas through a digital Problem-Based Learning environment.',
                'cover_image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?q=80&w=2070&auto=format&fit=crop',
                'is_active' => true,
            ]
        );

        // 2. Buat 14 Sesi (Pages)
        $sessionTitles = [
            'Introduction to Speed Reading & PBL',
            'Skimming for Main Ideas',
            'Scanning for Specific Information',
            'Deducing Meaning from Context',
            'Understanding Sentence Relations',
            'Evaluating Real-world Texts',
            'Transcoding Text to Diagrams',
            'Mid-Term Evaluation',
            'Advanced Skimming Techniques',
            'Critical Analysis of Academic Journals',
            'Information Synthesis',
            'Speed Reading Practice I',
            'Speed Reading Practice II',
            'Final PBL Presentation & Post-Test',
        ];

        foreach ($sessionTitles as $index => $title) {
            $page = Page::firstOrCreate(
                [
                    'module_id' => $module->id,
                    'order_number' => $index + 1,
                ],
                [
                    'title' => 'Session ' . ($index + 1) . ': ' . $title,
                    'is_published' => true,
                ]
            );

            // 3. Tambahkan contoh Block di Sesi 1
            if ($index === 0) {
                // Blok PBL Intro
                Block::firstOrCreate([
                    'page_id' => $page->id,
                    'type' => 'pbl_intro',
                    'sort_order' => 1,
                ], [
                    'content' => ['text' => 'Global warming is accelerating. Can you find the 3 main causes mentioned in the text below within 1 minute?'],
                ]);

                // Blok Teks Bacaan dengan Timer Aktif
                Block::firstOrCreate([
                    'page_id' => $page->id,
                    'type' => 'reading_text',
                    'sort_order' => 2,
                ], [
                    'content' => ['text' => 'Climate change is a long-term shift in global or regional climate patterns. Often climate change refers specifically to the rise in global temperatures from the mid-20th century to present... (Sample 500 words text)'],
                    'settings' => ['has_timer' => true, 'target_wpm' => 250],
                ]);
            }
        }
    }
}
