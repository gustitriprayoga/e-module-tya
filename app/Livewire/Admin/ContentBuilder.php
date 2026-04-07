<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Models\Block;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ContentBuilder extends Component
{
    public Page $session;
    public $blocks;

    // Form Properties
    public $block_id, $type = 'pbl_intro', $sort_order;

    // Dynamic Content Properties (Disimpan sebagai JSON di DB)
    public $content_text = '';
    public $target_wpm = 250; // Default WPM untuk Reading Text
    public $has_timer = false;

    public $isModalOpen = false;

    public function mount($session_id)
    {
        // Load Session beserta Modulnya
        $this->session = Page::with('module')->findOrFail($session_id);
    }

    public function render()
    {
        // Ambil blok konten urut berdasarkan sort_order
        $this->blocks = Block::where('page_id', $this->session->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('livewire.admin.content-builder')
            ->layout('components.layouts.dashboard', [
                'title' => 'Design Content - ' . $this->session->title
            ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->sort_order = $this->blocks->count() + 1;
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $block = Block::findOrFail($id);
        $this->block_id = $block->id;
        $this->type = $block->type;
        $this->sort_order = $block->sort_order;

        // Ekstrak data JSON
        $content = is_array($block->content) ? $block->content : json_decode($block->content, true);
        $settings = is_array($block->settings) ? $block->settings : json_decode($block->settings, true);

        $this->content_text = $content['text'] ?? '';
        $this->target_wpm = $settings['target_wpm'] ?? 250;
        $this->has_timer = $settings['has_timer'] ?? false;

        $this->isModalOpen = true;
    }

    private function resetInputFields()
    {
        $this->block_id = null;
        $this->type = 'pbl_intro';
        $this->content_text = '';
        $this->target_wpm = 250;
        $this->has_timer = false;
        $this->sort_order = '';
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:pbl_intro,reading_text',
            'content_text' => 'required|string',
            'sort_order' => 'required|integer',
        ]);

        // Format data sesuai struktur JSON
        $contentData = ['text' => $this->content_text];
        $settingsData = [];

        // Jika tipenya Teks Bacaan, simpan pengaturan Timer & WPM
        if ($this->type === 'reading_text') {
            $settingsData = [
                'target_wpm' => (int) $this->target_wpm,
                'has_timer' => (bool) $this->has_timer
            ];
        }

        Block::updateOrCreate(['id' => $this->block_id], [
            'page_id' => $this->session->id,
            'type' => $this->type,
            'sort_order' => $this->sort_order,
            'content' => $contentData,
            'settings' => $settingsData,
        ]);

        $this->isModalOpen = false;
        toast($this->block_id ? 'Block updated!' : 'Content block added!', 'success');
        $this->resetInputFields();
    }

    public function deleteBlock($id)
    {
        $block = Block::find($id);
        if ($block) {
            $block->delete();
            Alert::success('Deleted!', 'The content block has been removed.');
        }
    }
}
