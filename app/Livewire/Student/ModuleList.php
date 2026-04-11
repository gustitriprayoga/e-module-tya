<?php

namespace App\Livewire\Student;

use App\Models\Test;
use App\Models\TestResult;
use App\Models\Module;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ModuleList extends Component
{
    public $modules;
    public $hasCompletedPreTest = false;

    public function mount()
    {
        // 1. Cek apakah ada Pre-test yang aktif
        $preTest = Test::where('type', 'pre-test')->where('is_active', true)->first();

        // 2. Cek apakah mahasiswa sudah menyelesaikannya
        if ($preTest && Auth::check()) {
            $this->hasCompletedPreTest = TestResult::where('user_id', Auth::id())
                ->where('test_id', $preTest->id)
                ->exists();
        } else {
            // Jika tidak ada pre-test yang diatur admin, buka saja semua modul
            $this->hasCompletedPreTest = true;
        }

        // 3. Ambil semua modul beserta jumlah halamannya (pages_count)
        $this->modules = Module::where('is_published', true)
            ->withCount(['pages' => function ($query) {
                $query->where('is_published', true);
            }])
            ->orderBy('order', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.student.module-list')
            ->layout('components.layouts.dashboard', ['title' => 'Course Modules']);
    }
}
