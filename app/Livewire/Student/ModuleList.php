<?php

namespace App\Livewire\Student;

use App\Models\TestResult;
use App\Models\Module;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ModuleList extends Component
{
    public $filter = 'all';

    public function setFilter($status)
    {
        $this->filter = $status;
    }

    public function getModulesProperty()
    {
        $userId = Auth::id();

        // HAPUS filter `is_published` di sini agar semua modul ditarik
        $modules = Module::withCount(['pages' => function ($query) {
            $query->where('is_published', true);
        }])
            ->with(['tests' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('order', 'asc')
            ->get()
            ->map(function ($module) use ($userId) {
                $preTest = $module->tests->where('type', 'pre-test')->first();
                $postTest = $module->tests->where('type', 'post-test')->first();

                $hasPreTestResult = $preTest
                    ? TestResult::where('user_id', $userId)->where('test_id', $preTest->id)->exists()
                    : true;

                $hasPostTestResult = $postTest
                    ? TestResult::where('user_id', $userId)->where('test_id', $postTest->id)->exists()
                    : false;

                $module->is_locked = !$hasPreTestResult;
                $module->is_completed = $hasPostTestResult;
                $module->pre_test_id = $preTest ? $preTest->id : null;
                $module->post_test_id = $postTest ? $postTest->id : null;

                return $module;
            });

        if ($this->filter === 'completed') {
            return $modules->where('is_completed', true)->where('is_published', true);
        } elseif ($this->filter === 'unlocked') {
            return $modules->where('is_locked', false)->where('is_completed', false)->where('is_published', true);
        } elseif ($this->filter === 'locked') {
            return $modules->where('is_locked', true)->where('is_published', true);
        } elseif ($this->filter === 'upcoming') {
            return $modules->where('is_published', false);
        }

        return $modules;
    }

    public function render()
    {
        return view('livewire.student.module-list', [
            'modules' => $this->modules
        ])->layout('components.layouts.dashboard', ['title' => 'Course Modules']);
    }
}
