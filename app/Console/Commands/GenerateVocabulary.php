<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vocabulary;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class GenerateVocabulary extends Command
{
    protected $signature = 'vocab:generate';
    protected $description = 'Generate definitions and sentences from Free Dictionary API based on JSON dataset';

    public function handle()
    {
        $jsonPath = database_path('data/oxford_words.json');

        if (!File::exists($jsonPath)) {
            $this->error("File dataset tidak ditemukan di: {$jsonPath}");
            $this->info("Pastikan Anda sudah menaruh file JSON dengan struktur [{word, level, category}] di sana.");
            return;
        }

        $words = json_decode(File::get($jsonPath), true);

        $bar = $this->output->createProgressBar(count($words));
        $bar->start();

        foreach ($words as $item) {
            $word = strtolower(trim($item['word'] ?? ''));

            // Skip jika kata kosong atau sudah ada di database
            if (empty($word) || Vocabulary::where('word', $word)->exists()) {
                $bar->advance();
                continue;
            }

            // Panggil API Kamus
            $response = Http::get("https://api.dictionaryapi.dev/api/v2/entries/en/{$word}");

            $definition = 'Definition not found.';
            $contextSentence = null;
            $targetCategory = strtolower(trim($item['category'] ?? '')); // misal: 'adjective'

            if ($response->successful()) {
                $data = $response->json();

                try {
                    $meanings = $data[0]['meanings'];
                    $selectedMeaning = $meanings[0]; // Default ambil arti pertama

                    // SMART FITUR: Cari arti yang sesuai dengan part of speech (category) dari JSON Anda
                    if (!empty($targetCategory)) {
                        foreach ($meanings as $meaning) {
                            if (strtolower($meaning['partOfSpeech']) === $targetCategory) {
                                $selectedMeaning = $meaning;
                                break;
                            }
                        }
                    }

                    // Ambil definisi dan contoh kalimat pertama dari kategori yang cocok
                    $definition = $selectedMeaning['definitions'][0]['definition'] ?? 'Definition not found.';
                    $contextSentence = $selectedMeaning['definitions'][0]['example'] ?? null;
                } catch (\Exception $e) {
                    // Abaikan error struktur API, simpan dengan default 'not found'
                }
            }

            // Simpan ke Database
            Vocabulary::create([
                'word' => $word,
                'level' => $item['level'] ?? 'General',
                'category' => $item['category'] ?? 'Unknown',
                'definition' => $definition,
                'context_sentence' => $contextSentence,
            ]);

            $bar->advance();

            // Delay 1 detik untuk menghindari Rate Limit (IP diblokir oleh API)
            sleep(1);
        }

        $bar->finish();
        $this->newLine();
        $this->info('Luar biasa! Dataset Vocabulary Anda berhasil di-generate beserta definisinya!');
    }
}
