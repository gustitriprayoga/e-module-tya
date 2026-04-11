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
        $this->currentTest = Test::with('module')->findOrFail($test_id);

        $currentResult = ResultModel::where('user_id', Auth::id())
            ->where('test_id', $this->currentTest->id)
            ->latest()
            ->firstOrFail();

        // Hitung berapa soal yang dijawab benar pada ujian ini
        $this->testQuestionsTotal = $this->currentTest->questions()->count();
        $this->testQuestionsCorrect = $currentResult->score > 0 ? round(($currentResult->score / 100) * $this->testQuestionsTotal) : 0;

        if ($this->currentTest->type === 'post-test') {
            $this->isPostTest = true;
            $this->postTestScore = (float) $currentResult->score;

            // AMBIL DATA SPEED READING DARI SESSION
            $modId = $this->currentTest->module_id;
            if ($modId) {
                $this->readingWpm = session("module_{$modId}_wpm", 0);
                $this->readingTime = session("module_{$modId}_time", 0);
                $this->readingWords = session("module_{$modId}_words", 0);
                $this->moduleQuizCorrect = session("module_{$modId}_quiz_correct", 0);
                $this->moduleQuizTotal = session("module_{$modId}_quiz_total", 0);
            }

            // Cari Pre-Test
            $preTestQuery = ResultModel::where('user_id', Auth::id())
                ->whereHas('test', function ($query) {
                    $query->where('type', 'pre-test');
                    if ($this->currentTest->module_id) {
                        $query->where('module_id', $this->currentTest->module_id);
                    }
                })->latest()->first();

            if ($preTestQuery) {
                $this->preTestScore = (float) $preTestQuery->score;
            }

            $this->calculateNGain();
        } else {
            $this->isPostTest = false;
            $this->preTestScore = (float) $currentResult->score;
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

    public function render()
    {
        return view('livewire.student.test-result')
            ->layout('components.layouts.dashboard', ['title' => 'Test Results & Analytics']);
    }
}
