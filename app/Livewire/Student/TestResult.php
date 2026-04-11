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

    public $preTestScore = null;
    public $postTestScore = null;

    public $nGainScore = 0;
    public $nGainCategory = '';
    public $gainActual = 0;
    public $gainMax = 0;
    public $isDecrease = false;

    public function mount($test_id)
    {
        $this->currentTest = Test::findOrFail($test_id);

        $currentResult = ResultModel::where('user_id', Auth::id())
            ->where('test_id', $this->currentTest->id)
            ->latest()
            ->firstOrFail();

        if ($this->currentTest->type === 'post-test') {
            $this->isPostTest = true;
            $this->postTestScore = (float) $currentResult->score;

            // FIX: Cari pre-test yang berelasi dengan module yang SAMA
            // dengan cara join ke tabel tests untuk filter berdasarkan module_id
            $preTestResult = ResultModel::where('user_id', Auth::id())
                ->whereHas('test', function ($query) {
                    $query->where('type', 'pre-test')
                        ->where('module_id', $this->currentTest->module_id);
                })
                ->latest()
                ->first();

            if ($preTestResult) {
                $this->preTestScore = (float) $preTestResult->score;
                $this->calculateNGain();
            }
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

        // Edge case: pre-test sudah 100
        if ($pre == 100) {
            if ($post == 100) {
                $this->nGainScore    = 1; // sempurna
                $this->nGainCategory = 'Maksimal (Perfect)';
            } else {
                $this->isDecrease    = true;
                $this->nGainScore    = -1;
                $this->nGainCategory = 'Penurunan (Decrease)';
            }
            return;
        }

        // Kalkulasi normal
        $this->nGainScore = $this->gainActual / $this->gainMax;

        // FIX: urutan kondisi harus dari besar ke kecil,
        // dan 0 harus dicek SEBELUM < 0.3
        if ($this->nGainScore >= 0.7) {
            $this->nGainCategory = 'Tinggi (High)';
        } elseif ($this->nGainScore >= 0.3) {
            $this->nGainCategory = 'Sedang (Medium)';
        } elseif ($this->nGainScore > 0) {
            // FIX: > 0, bukan >= 0. Nilai 0.00 tidak masuk sini.
            $this->nGainCategory = 'Rendah (Low)';
        } elseif ($this->nGainScore == 0) {
            $this->nGainCategory = 'Tetap (No Change)';
        } else {
            // nGainScore < 0
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
