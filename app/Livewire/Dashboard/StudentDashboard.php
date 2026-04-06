<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class StudentDashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard.student-dashboard')
            ->layout('components.layouts.dashboard', ['title' => 'My Progress']);
    }
}
