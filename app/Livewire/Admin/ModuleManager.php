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

    // Status Publikasi (Draft / Published)
    public $is_published = false;

    public $isModalOpen = false;

    public function render()
    {
        // Mengambil semua modul beserta jumlah sesinya (pages)
        $this->modules = Module::withCount('pages')->orderBy('order', 'asc')->get();

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
        $this->module_id = null;
        $this->title = '';
        $this->slug = '';
        $this->description = '';
        $this->cover_image = '';
        $this->is_published = false; // Default: Draft
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|url',
        ]);

        $order = Module::max('order') + 1;

        Module::updateOrCreate(['id' => $this->module_id], [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'cover_image' => $this->cover_image,
            'is_published' => $this->is_published,
            // Jika modul baru, tambahkan di urutan paling akhir
            'order' => $this->module_id ? Module::find($this->module_id)->order : $order,
        ]);

        $this->closeModal();
        toast($this->module_id ? 'Module updated successfully!' : 'New module created!', 'success');
    }

    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $this->module_id = $module->id;
        $this->title = $module->title;
        $this->slug = $module->slug;
        $this->description = $module->description;
        $this->cover_image = $module->cover_image;
        $this->is_published = $module->is_published;

        $this->openModal();
    }

    public function delete($id)
    {
        Module::findOrFail($id)->delete();
        toast('Module deleted successfully!', 'error');
    }

    // Fitur Reorder (Menaikkan/Menurunkan urutan modul)
    public function moveUp($id)
    {
        $module = Module::findOrFail($id);
        if ($module->order > 1) {
            $prevModule = Module::where('order', $module->order - 1)->first();
            if ($prevModule) {
                $prevModule->update(['order' => $module->order]);
                $module->update(['order' => $module->order - 1]);
            }
        }
    }

    public function moveDown($id)
    {
        $module = Module::findOrFail($id);
        $maxOrder = Module::max('order');
        if ($module->order < $maxOrder) {
            $nextModule = Module::where('order', $module->order + 1)->first();
            if ($nextModule) {
                $nextModule->update(['order' => $module->order]);
                $module->update(['order' => $module->order + 1]);
            }
        }
    }
}
