<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard.admin-dashboard')
            ->layout('components.layouts.dashboard', ['title' => 'Admin Overview']);
    }
}
