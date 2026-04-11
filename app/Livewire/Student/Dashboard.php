<?php

namespace App\Livewire\Student;

use App\Models\TestResult;
use App\Models\Module;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalModules = 0;
    public $completedModules = 0;
    public $averageScore = 0;
    public $recentActivities = [];

    public function mount()
    {
        $userId = Auth::id();

        // 1. Total Modul yang Tersedia
        $this->totalModules = Module::where('is_published', true)->count();

        // 2. Ambil Riwayat Ujian (Terbaru)
        $results = TestResult::with('test.module')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($results->count() > 0) {
            // Rata-rata Nilai
            $this->averageScore = $results->avg('score');

            // Hitung modul yang sudah lulus (Post-Test Selesai)
            $this->completedModules = $results->filter(function ($result) {
                return $result->test && $result->test->type === 'post-test';
            })->unique('test.module_id')->count();
        }

        // Ambil 5 riwayat terbaru untuk tabel
        $this->recentActivities = $results->take(5);
    }

    public function render()
    {
        return view('livewire.student.dashboard')
            ->layout('components.layouts.dashboard', ['title' => 'Student Dashboard']);
    }
}
