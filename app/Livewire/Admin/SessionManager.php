<?php

namespace App\Livewire\Admin;

use App\Models\Module;
use App\Models\Page; // Model Session
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class SessionManager extends Component
{
    public Module $module;
    public $sessions;

    // Form Properties
    public $session_id, $title, $order_number;
    public $is_published = true;
    public $isModalOpen = false;

    // Menangkap ID dari Route
    public function mount($module_id)
    {
        $this->module = Module::findOrFail($module_id);
    }

    public function render()
    {
        // Ambil sesi urut berdasarkan nomor pertemuan (order_number)
        $this->sessions = Page::where('module_id', $this->module->id)
            ->orderBy('order_number', 'asc')
            ->get();

        return view('livewire.admin.session-manager')
            ->layout('components.layouts.dashboard', [
                'title' => 'Session Builder - ' . $this->module->title
            ]);
    }

    public function create()
    {
        $this->resetInputFields();
        // Set otomatis order number berikutnya
        $this->order_number = $this->sessions->count() + 1;
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $session = Page::findOrFail($id);
        $this->session_id = $session->id;
        $this->title = $session->title;
        $this->order_number = $session->order_number;
        $this->is_published = $session->is_published;

        $this->isModalOpen = true;
    }

    private function resetInputFields()
    {
        $this->session_id = null;
        $this->title = '';
        $this->order_number = '';
        $this->is_published = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'order_number' => 'required|integer|min:1',
        ]);

        Page::updateOrCreate(['id' => $this->session_id], [
            'module_id' => $this->module->id,
            'title' => $this->title,
            'order_number' => $this->order_number,
            'is_published' => $this->is_published,
        ]);

        $this->isModalOpen = false;

        // Memanggil Toast SweetAlert
        toast($this->session_id ? 'Session updated successfully!' : 'New session created!', 'success');
        $this->resetInputFields();
    }

    // Fungsi hapus yang dipanggil oleh SweetAlert di Frontend
    public function deleteSession($id)
    {
        $session = Page::find($id);
        if ($session) {
            $session->delete();
            // Tampilkan SweetAlert ukuran penuh (bukan toast)
            Alert::success('Deleted!', 'The learning session has been removed.');
        }
    }
}
