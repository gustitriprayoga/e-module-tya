<?php

namespace App\Livewire;

use App\Models\Module;
use Livewire\Component;
use Livewire\WithPagination;

class ModuleExplorer extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, reading, vocabulary

    // Reset pagination ketika melakukan pencarian atau filter
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function setFilter($type)
    {
        $this->filter = $type;
        $this->resetPage();
    }

    public function render()
    {
        // Ganti is_active menjadi is_published (Sesuai struktur database ADDIE kita)
        $query = Module::where('is_published', true)
            ->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });

        // Filter sederhana berdasarkan judul/deskripsi (Karena kita belum punya kolom kategori di tabel Modules)
        if ($this->filter === 'reading') {
            $query->where('title', 'like', '%Reading%');
        } elseif ($this->filter === 'vocabulary') {
            $query->where('title', 'like', '%Vocab%');
        }

        return view('livewire.module-explorer', [
            'modules' => $query->withCount('pages')->orderBy('order', 'asc')->paginate(6)
        ])->title('Explore Modules - LitFlow');
    }
}
