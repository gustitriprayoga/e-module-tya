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

    public $preTestScore = 0;
    public $postTestScore = 0;

    // --- Data Ujian Saat Ini ---
    public $testQuestionsTotal = 0;
    public $testQuestionsCorrect = 0;

    // --- Data Analitik Membaca (Speed Reading) ---
    public $readingWpm = 0;
    public $readingTime = 0;
    public $readingWords = 0;
    public $moduleQuizCorrect = 0;
    public $moduleQuizTotal = 0;

    // --- N-Gain ---
    public $nGainScore = 0;
    public $nGainCategory = '';
    public $gainActual = 0;
    public $gainMax = 0;
    public $isDecrease = false;

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
         * FIX: Hitung jawaban benar dengan membandingkan option yang dipilih user
         * terhadap is_correct pada tabel options — konsisten dengan blade PDF.
         *
         * Kunci di JSON answers bisa berupa string (hasil json_decode default),
         * sehingga kita cast $question->id ke string saat lookup.
         */
        $correctCount = 0;
        $answersMap   = $currentResult->answers ?? [];

        if (!empty($answersMap)) {
            foreach ($this->currentTest->questions as $question) {
                $questionKey  = (string) $question->id;
                // Coba kedua bentuk key: string dan integer
                $userOptionId = $answersMap[$questionKey] ?? ($answersMap[$question->id] ?? null);

                if ($userOptionId !== null) {
                    $selectedOption = $question->options->where('id', (int) $userOptionId)->first();
                    if ($selectedOption && (bool) $selectedOption->is_correct) {
                        $correctCount++;
                    }
                }
            }
        }

        $this->testQuestionsCorrect = $correctCount;

        // Siapkan skor berdasarkan tipe test
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

            $this->calculateNGain();
        } else {
            $this->preTestScore = $currentResult->score;
        }
    }

    private function calculateNGain()
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

        $this->nGainScore = $this->gainActual / $this->gainMax;

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
