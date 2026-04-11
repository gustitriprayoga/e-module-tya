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

    // Default ke 0, jangan null agar tampilan tidak error
    public $preTestScore = 0;
    public $postTestScore = 0;

    public $nGainScore = 0;
    public $nGainCategory = '';
    public $gainActual = 0;
    public $gainMax = 0;
    public $isDecrease = false;

    public function mount($test_id)
    {
        // Load test beserta relasi modulnya
        $this->currentTest = Test::with('module')->findOrFail($test_id);

        $currentResult = ResultModel::where('user_id', Auth::id())
            ->where('test_id', $this->currentTest->id)
            ->latest()
            ->firstOrFail();

        if ($this->currentTest->type === 'post-test') {
            $this->isPostTest = true;
            $this->postTestScore = (float) $currentResult->score;

            // Cari pre-test dengan query yang AMAN (Tahan Banting)
            $preTestQuery = ResultModel::where('user_id', Auth::id())
                ->whereHas('test', function ($query) {
                    $query->where('type', 'pre-test');
                    // Hanya filter module_id JIKA currentTest memiliki module_id
                    if ($this->currentTest->module_id) {
                        $query->where('module_id', $this->currentTest->module_id);
                    }
                })
                ->latest()
                ->first();

            // Jika nilai ditemukan, masukkan. Jika tidak, tetap 0.
            if ($preTestQuery) {
                $this->preTestScore = (float) $preTestQuery->score;
            }

            // Selalu jalankan kalkulasi N-Gain saat Post-Test
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

        // Edge case: pre-test sudah 100
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

        // Kalkulasi normal
        $this->nGainScore = $this->gainActual / $this->gainMax;

        // Kategorisasi
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
