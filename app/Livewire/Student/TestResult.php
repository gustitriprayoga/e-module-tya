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

    // --- ID Hasil Tes Untuk Fitur Download PDF ---
    public $resultId;
    public $preTestResultId = null;
    public $postTestResultId = null;
    public $quizResultId = null;

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
        $this->currentTest = Test::with([
            'module',
            'questions' => function ($query) {
                $query->with(['options', 'testPassage'])
                    ->orderBy('test_passage_id')
                    ->orderBy('id');
            }
        ])->findOrFail($test_id);

        // Pengecekan Case-Insensitive (misal pretest, Pre-Test, PRETEST akan tetap terbaca)
        $currentType = strtolower($this->currentTest->type);
        $this->isPostTest  = str_contains($currentType, 'post');

        // 1. Ambil Hasil Tes Saat Ini
        $currentResult = ResultModel::where('user_id', Auth::id())
            ->where('test_id', $this->currentTest->id)
            ->latest()
            ->firstOrFail();

        $this->resultId = $currentResult->id;
        $this->testQuestionsTotal = $this->currentTest->questions->count();

        // 2. Set Nilai Saat Ini
        if (str_contains($currentType, 'pre')) {
            $this->preTestScore = $currentResult->score;
            $this->preTestResultId = $currentResult->id;
        } elseif (str_contains($currentType, 'post')) {
            $this->postTestScore = $currentResult->score;
            $this->postTestResultId = $currentResult->id;
        }

        // 3. Kalkulasi Jawaban Benar Ujian Saat Ini
        $answersMap = $this->decodeAnswers($currentResult->answers);
        $correctCount = 0;

        if (!empty($answersMap)) {
            foreach ($this->currentTest->questions as $question) {
                $userOptionId = $answersMap[(string) $question->id] ?? $answersMap[(int) $question->id] ?? null;
                if ($userOptionId !== null) {
                    $selectedOption = $question->options->where('id', (int) $userOptionId)->first();
                    if ($selectedOption && (bool) $selectedOption->is_correct) {
                        $correctCount++;
                    }
                }
            }
        }
        $this->testQuestionsCorrect = $correctCount;

        // 4. AMBIL SEMUA RIWAYAT UNTUK MODUL INI (Tahan banting terhadap format string "type")
        $moduleId = $this->currentTest->module_id ?? optional($this->currentTest->module)->id;

        if ($moduleId) {
            $moduleTests = Test::where('module_id', $moduleId)->with('questions.options')->get();

            // --- Cek Quiz (In-Module Quiz) ---
            // Prioritas 1: Ambil dari ReadingHistory (Database)
            // Prioritas 2: Ambil dari Session (Fallback jika belum tersimpan di DB)
            $readingHistory = \App\Models\ReadingHistory::where('user_id', Auth::id())
                ->where('module_id', $moduleId)
                ->whereNull('block_id')
                ->latest()
                ->first();

            if ($readingHistory) {
                $this->readingWpm         = $readingHistory->wpm ?? 0;
                $this->readingTime        = $readingHistory->time_spent ?? 0;
                $this->readingWords       = $readingHistory->total_words ?? 0;
                $this->moduleQuizCorrect  = $readingHistory->quiz_correct ?? 0;
                $this->moduleQuizTotal    = $readingHistory->quiz_total ?? 0;
            } else {
                // Fallback ke session jika data di DB belum ada
                $this->readingWpm         = session()->get('module_' . $moduleId . '_wpm', 0);
                $this->readingTime        = session()->get('module_' . $moduleId . '_time', 0);
                $this->readingWords       = session()->get('module_' . $moduleId . '_words', 0);
                $this->moduleQuizCorrect  = session()->get('module_' . $moduleId . '_quiz_correct', 0);
                $this->moduleQuizTotal    = session()->get('module_' . $moduleId . '_quiz_total', 0);
            }

            // --- Cek Pre-Test ---
            $preTest = $moduleTests->first(fn($t) => str_contains(strtolower($t->type), 'pre'));
            if ($preTest) {
                $preTestResult = ResultModel::where('user_id', Auth::id())->where('test_id', $preTest->id)->latest()->first();
                if ($preTestResult) {
                    $this->preTestScore = $preTestResult->score;
                    $this->preTestResultId = $preTestResult->id;
                }
            }

            // --- Cek Post-Test ---
            $postTest = $moduleTests->first(fn($t) => str_contains(strtolower($t->type), 'post'));
            if ($postTest) {
                $postTestResult = ResultModel::where('user_id', Auth::id())->where('test_id', $postTest->id)->latest()->first();
                if ($postTestResult) {
                    $this->postTestScore = $postTestResult->score;
                    $this->postTestResultId = $postTestResult->id;
                }
            }

            // --- Cek Quiz ID (Untuk Download PDF saja) ---
            $quizTest = $moduleTests->first(fn($t) => str_contains(strtolower($t->type), 'quiz'));
            if ($quizTest) {
                $quizResult = ResultModel::where('user_id', Auth::id())->where('test_id', $quizTest->id)->latest()->first();
                if ($quizResult) {
                    $this->quizResultId = $quizResult->id;
                }
            }
        }

        // 5. Kalkulasi N-Gain
        if ($this->preTestResultId && $this->postTestResultId) {
            $this->calculateNGain();
        }
    }

    private function decodeAnswers($raw)
    {
        if (is_array($raw)) return $raw;
        if (is_string($raw) && !empty($raw)) return json_decode($raw, true) ?? [];
        return [];
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

        $this->nGainScore = $this->gainMax > 0 ? ($this->gainActual / $this->gainMax) : 0;

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

    public function downloadPreTest()
    {
        if (!$this->preTestResultId) return;
        return redirect()->route('test.download', $this->preTestResultId);
    }

    public function downloadPostTest()
    {
        if (!$this->postTestResultId) return;
        return redirect()->route('test.download', $this->postTestResultId);
    }

    public function downloadQuiz()
    {
        if (!$this->quizResultId) return;
        return redirect()->route('test.download', $this->quizResultId);
    }

    public function render()
    {
        return view('livewire.student.test-result')->layout('components.layouts.reader');
    }
}
