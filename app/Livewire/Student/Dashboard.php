<?php

namespace App\Livewire\Student;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\Module;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $preTest;
    public $hasCompletedPreTest = false;
    public $preTestScore = null;

    public function mount()
    {
        // 1. Cari Pre-test yang sedang diaktifkan oleh Admin
        $this->preTest = Test::where('type', 'pre-test')->where('is_active', true)->first();

        if ($this->preTest) {
            // 2. Cek apakah user sudah mengerjakannya
            $result = TestResult::where('user_id', Auth::id())
                ->where('test_id', $this->preTest->id)
                ->first();

            if ($result) {
                $this->hasCompletedPreTest = true;
                $this->preTestScore = $result->score;
            }
        } else {
            // Fail-safe: Jika admin belum mengaktifkan pre-test apapun, buka saja modulnya
            $this->hasCompletedPreTest = true;
        }
    }

    public function render()
    {
        // 3. Ambil SEMUA modul untuk ditampilkan (meskipun nanti statusnya terkunci di view)
        $modules = Module::where('is_published', true)->orderBy('order')->get();

        return view('livewire.student.dashboard', [
            'modules' => $modules
        ])->layout('components.layouts.dashboard', ['title' => 'Student Dashboard']);
    }
}
