<?php

namespace App\Livewire\Admin;

use App\Models\Module;
use Livewire\Component;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ModuleManager extends Component
{
    public $modules;
    public $module_id, $title, $slug, $description, $cover_image;
    public $is_active = true;
    public $isModalOpen = false;

    public function render()
    {
        // Mengambil semua modul beserta jumlah sesinya (pages)
        $this->modules = Module::withCount('pages')->orderBy('created_at', 'desc')->get();

        return view('livewire.admin.module-manager')
            ->layout('components.layouts.dashboard', ['title' => 'Module Builder (ADDIE)']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->module_id = '';
        $this->title = '';
        $this->slug = '';
        $this->description = '';
        $this->cover_image = '';
        $this->is_active = true;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|url',
        ]);

        Module::updateOrCreate(['id' => $this->module_id], [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'is_active' => $this->is_active,
        ]);

        $this->closeModal();

        // Memanggil SweetAlert Helper
        toast($this->module_id ? 'Module updated successfully!' : 'New module created!', 'success');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $this->module_id = $id;
        $this->title = $module->title;
        $this->slug = $module->slug;
        $this->description = $module->description;
        $this->cover_image = $module->cover_image;
        $this->is_active = $module->is_active;

        $this->openModal();
    }

    public function delete($id)
    {
        Module::findOrFail($id)->delete();
        toast('Module deleted successfully!', 'error');
    }
}
