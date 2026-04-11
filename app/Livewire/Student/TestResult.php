<?php

namespace App\Livewire\Student;

use App\Models\Test;
use App\Models\TestResult as ResultModel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TestResult extends Component
{
    public $currentTest;
    public $postTestResult;
    public $preTestResult;

    public $preTestScore = 0;
    public $postTestScore = 0;

    public $nGainScore = 0;
    public $nGainCategory = '';

    public function mount($test_id)
    {
        $this->currentTest = Test::findOrFail($test_id);

        // 1. Ambil Hasil Test Saat Ini (Biasanya Post-Test)
        $this->postTestResult = ResultModel::where('user_id', Auth::id())
            ->where('test_id', $this->currentTest->id)
            ->firstOrFail();

        $this->postTestScore = $this->postTestResult->score;

        // 2. Ambil Hasil Pre-Test (Sebagai Pembanding)
        $this->preTestResult = ResultModel::where('user_id', Auth::id())
            ->whereHas('test', function ($query) {
                $query->where('type', 'pre-test');
            })->first();

        if ($this->preTestResult) {
            $this->preTestScore = $this->preTestResult->score;
            $this->calculateNGain();
        }
    }

    // Fungsi Kalkulasi N-Gain Score untuk Penelitian Tesis
    private function calculateNGain()
    {
        $pre = $this->preTestScore;
        $post = $this->postTestScore;

        if ($pre == 100 && $post == 100) {
            $this->nGainScore = 0;
            $this->nGainCategory = 'Maksimal';
        } elseif ($pre >= $post) {
            $this->nGainScore = 0;
            $this->nGainCategory = 'Tidak Ada Peningkatan';
        } else {
            // Rumus N-Gain: (Post - Pre) / (100 - Pre)
            $this->nGainScore = ($post - $pre) / (100 - $pre);

            // Kategorisasi N-Gain (Hake, 1999)
            if ($this->nGainScore > 0.7) {
                $this->nGainCategory = 'Tinggi (High)';
            } elseif ($this->nGainScore >= 0.3) {
                $this->nGainCategory = 'Sedang (Medium)';
            } else {
                $this->nGainCategory = 'Rendah (Low)';
            }
        }
    }

    public function render()
    {
        return view('livewire.student.test-result')
            ->layout('components.layouts.dashboard', ['title' => 'Test Results & Analytics']);
    }
}
