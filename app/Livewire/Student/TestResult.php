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
    public $gainActual = 0;
    public $gainMax = 0;
    public $isDecrease = false; // Tambahan properti baru

    public function mount($test_id)
    {
        $this->currentTest = Test::findOrFail($test_id);

        $this->postTestResult = ResultModel::where('user_id', Auth::id())
            ->where('test_id', $this->currentTest->id)
            ->firstOrFail();

        $this->postTestScore = $this->postTestResult->score;

        $this->preTestResult = ResultModel::where('user_id', Auth::id())
            ->whereHas('test', function ($query) {
                $query->where('type', 'pre-test');
            })->first();

        if ($this->preTestResult) {
            $this->preTestScore = $this->preTestResult->score;
            $this->calculateNGain();
        }
    }

    private function calculateNGain()
    {
        $pre = $this->preTestScore;
        $post = $this->postTestScore;

        $this->gainActual = $post - $pre;
        $this->gainMax = 100 - $pre;

        // KONDISI 1: Terjadi Penurunan Nilai (Post < Pre)
        if ($post < $pre) {
            $this->isDecrease = true;
            $this->nGainScore = 0;
            $this->nGainCategory = 'Penurunan (Decrease)';
        }
        // KONDISI 2: Sudah Sempurna Sejak Awal
        elseif ($pre == 100 && $post == 100) {
            $this->nGainScore = 0;
            $this->nGainCategory = 'Maksimal (Perfect)';
        }
        // KONDISI 3: Nilai Tidak Berubah
        elseif ($pre == $post) {
            $this->nGainScore = 0;
            $this->nGainCategory = 'Tetap (No Change)';
        }
        // KONDISI 4: Hitungan N-Gain Normal
        else {
            $this->nGainScore = $this->gainActual / $this->gainMax;

            if ($this->nGainScore >= 0.7) {
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
