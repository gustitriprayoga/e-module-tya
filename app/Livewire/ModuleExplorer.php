<?php

namespace App\Livewire;

use App\Models\Module;
use Livewire\Component;
use Livewire\WithPagination;

class ModuleExplorer extends Component
{
    use WithPagination;

    public $search = '';

    // Memberikan judul halaman untuk layout app.blade.php
    public function render()
    {
        return view('livewire.module-explorer', [
            'modules' => Module::where('title', 'like', '%' . $this->search . '%')
                ->where('is_active', true)
                ->withCount('pages')
                ->paginate(6)
        ])->title('Explore Modules - PahlawanHub');
    }
}
