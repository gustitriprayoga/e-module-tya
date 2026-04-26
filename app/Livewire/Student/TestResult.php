<?php

namespace App\Livewire\Student;

use App\Models\Test;
use App\Models\TestResult as ResultModel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TestResult extends Component
{
    public $currentTest;
    public $isPostTest = false;

    // --- Properti Untuk Fitur Download PDF ---
    public $resultId;

    public $preTestScore  = 0;
    public $postTestScore = 0;

    // --- Data Ujian Saat Ini ---
    public $testQuestionsTotal   = 0;
    public $testQuestionsCorrect = 0;

    // --- Data Analitik Membaca (Speed Reading) ---
    public $readingWpm   = 0;
    public $readingTime  = 0;
    public $readingWords = 0;

    // --- In-Module Quiz ---
    public $moduleQuizCorrect = 0;
    public $moduleQuizTotal   = 0;

    // --- N-Gain ---
    public $nGainScore    = 0;
    public $nGainCategory = '';
    public $gainActual    = 0;
    public $gainMax       = 0;
    public $isDecrease    = false;

    public function mount($test_id)
    {
        // Load questions beserta options agar bisa cek is_correct
        $this->currentTest = Test::with(['module', 'questions.options'])->findOrFail($test_id);
        $this->isPostTest  = $this->currentTest->type === 'posttest';

        // Mengambil hasil tes terbaru dari user yang sedang login
        $currentResult = ResultModel::where('user_id', Auth::id())
            ->where('test_id', $this->currentTest->id)
            ->latest()
            ->firstOrFail();

        // Simpan ID hasil test untuk download PDF
        $this->resultId = $currentResult->id;

        // Hitung total soal
        $this->testQuestionsTotal = $this->currentTest->questions->count();

        /*
         * ================================================================
         * FIX BUG UTAMA — Penyebab "0 of X correct"
         * ================================================================
         * Kolom `answers` dari database bisa berupa:
         *   - Raw JSON string : jika model TIDAK punya $casts ['answers' => 'array']
         *   - Array           : jika model SUDAH punya cast tersebut
         *
         * Sebelumnya kode langsung pakai $currentResult->answers sebagai array.
         * Jika tidak di-cast, nilainya adalah string JSON → semua lookup key
         * mengembalikan null → $correctCount selalu 0.
         *
         * Solusi: decode secara eksplisit agar hasilnya selalu array.
         * ================================================================
         */
        $answersMap = $this->decodeAnswers($currentResult->answers);

        // Hitung jawaban benar
        $correctCount = 0;

        if (!empty($answersMap)) {
            foreach ($this->currentTest->questions as $question) {
                $userOptionId = $answersMap[(string) $question->id]
                    ?? $answersMap[(int) $question->id]
                    ?? null;

                if ($userOptionId !== null) {
                    $selectedOption = $question->options
                        ->where('id', (int) $userOptionId)
                        ->first();

                    if ($selectedOption && (bool) $selectedOption->is_correct) {
                        $correctCount++;
                    }
                }
            }
        }

        $this->testQuestionsCorrect = $correctCount;

        // ===== Siapkan skor berdasarkan tipe test =====
        if ($this->isPostTest) {
            $this->postTestScore = $currentResult->score;

            // Cari nilai Pre-test di modul yang sama
            $preTest = Test::where('module_id', $this->currentTest->module_id)
                ->where('type', 'pretest')
                ->first();

            if ($preTest) {
                $preTestResult = ResultModel::where('user_id', Auth::id())
                    ->where('test_id', $preTest->id)
                    ->latest()
                    ->first();
                $this->preTestScore = $preTestResult ? $preTestResult->score : 0;
            }

            // Ambil data analitik membaca
            if (class_exists(\App\Models\ReadingHistory::class)) {
                $readingHistory = \App\Models\ReadingHistory::where('user_id', Auth::id())
                    ->where('module_id', $this->currentTest->module_id)
                    ->latest()
                    ->first();

                if ($readingHistory) {
                    $this->readingWpm   = $readingHistory->wpm ?? 0;
                    $this->readingTime  = $readingHistory->time_spent ?? 0;
                    $this->readingWords = $readingHistory->total_words ?? 0;
                }
            }

            /*
             * FIX BUG: moduleQuizCorrect & moduleQuizTotal sebelumnya tidak
             * pernah diisi di mount() sehingga selalu tampil 0/0.
             * Sekarang dihitung dari hasil quiz di modul yang sama.
             */
            $quizTest = Test::where('module_id', $this->currentTest->module_id)
                ->where('type', 'quiz')
                ->with('questions.options')
                ->first();

            if ($quizTest) {
                $quizResult = ResultModel::where('user_id', Auth::id())
                    ->where('test_id', $quizTest->id)
                    ->latest()
                    ->first();

                if ($quizResult) {
                    $quizAnswersMap      = $this->decodeAnswers($quizResult->answers);
                    $this->moduleQuizTotal   = $quizTest->questions->count();
                    $quizCorrect         = 0;

                    foreach ($quizTest->questions as $q) {
                        $selectedId = $quizAnswersMap[(string) $q->id]
                            ?? $quizAnswersMap[(int) $q->id]
                            ?? null;

                        if ($selectedId !== null) {
                            $opt = $q->options->where('id', (int) $selectedId)->first();
                            if ($opt && (bool) $opt->is_correct) {
                                $quizCorrect++;
                            }
                        }
                    }

                    $this->moduleQuizCorrect = $quizCorrect;
                }
            }

            $this->calculateNGain();
        } else {
            // Jika Pre-test
            $this->preTestScore = $currentResult->score;
        }
    }

    /**
     * Decode kolom answers secara aman.
     * Menangani dua kemungkinan: raw JSON string (tanpa cast) atau array (dengan cast).
     */
    private function decodeAnswers(mixed $raw): array
    {
        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw) && !empty($raw)) {
            return json_decode($raw, true) ?? [];
        }

        return [];
    }

    private function calculateNGain(): void
    {
        $pre  = $this->preTestScore;
        $post = $this->postTestScore;

        $this->gainActual = $post - $pre;
        $this->gainMax    = 100 - $pre;

        if ($pre == 100) {
            if ($post == 100) {
                $this->nGainScore    = 1;
                $this->nGainCategory = 'Maksimal (Perfect)';
            } else {
                $this->isDecrease    = true;
                $this->nGainScore    = -1;
                $this->nGainCategory = 'Penurunan (Decrease)';
            }
            return;
        }

        // Hindari division by zero
        $this->nGainScore = $this->gainMax > 0
            ? ($this->gainActual / $this->gainMax)
            : 0;

        if ($this->nGainScore >= 0.7) {
            $this->nGainCategory = 'Tinggi (High)';
        } elseif ($this->nGainScore >= 0.3) {
            $this->nGainCategory = 'Sedang (Medium)';
        } elseif ($this->nGainScore > 0) {
            $this->nGainCategory = 'Rendah (Low)';
        } elseif ($this->nGainScore == 0) {
            $this->nGainCategory = 'Tetap (No Change)';
        } else {
            $this->isDecrease    = true;
            $this->nGainCategory = 'Penurunan (Decrease)';
        }
    }

    // --- FUNGSI DOWNLOAD TRIGGERED DARI BLADE ---
    public function download()
    {
        if (!$this->resultId) {
            session()->flash('error', 'Data hasil tes tidak ditemukan.');
            return;
        }

        return redirect()->route('test.download', $this->resultId);
    }

    public function render()
    {
        return view('livewire.student.test-result')->layout('components.layouts.app');
    }
}
