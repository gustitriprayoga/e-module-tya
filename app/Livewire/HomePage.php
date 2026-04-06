<?php

namespace App\Livewire;

use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert; // Import SweetAlert Facade

class HomePage extends Component
{
    public function startPreTest()
    {
        // For demonstration: Check if user is logged in
        if (!auth()->check()) {
            // Trigger SweetAlert for unauthenticated users
            Alert::warning('Authentication Required', 'Please Sign In to take the Pre-Test and save your T1 score.');
            return redirect()->to('/login');
        }

        // Trigger SweetAlert Success
        Alert::info('Welcome to the Pre-Test', 'You have 30 minutes to complete 30 questions based on 5 indicators. Good luck!');

        // Redirect to pre-test page (create this route later)
        return redirect()->route('pre-test.start');
    }

    public function render()
    {
        return view('livewire.home-page'); // Linking to our master layout
    }
}
