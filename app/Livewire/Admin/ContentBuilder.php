<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Models\Block;
use App\Models\Vocabulary;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class ContentBuilder extends Component
{
    public Page $session;
    public $blocks;

    // Form Properties
    public $block_id, $type = 'pbl_intro', $sort_order;
    public $content_text = '';
    public $target_wpm = 250;
    public $has_timer = false;

    public $isModalOpen = false;

    public function mount($session_id)
    {
        $this->session = Page::with('module')->findOrFail($session_id);
    }

    public function render()
    {
        $this->blocks = Block::where('page_id', $this->session->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('livewire.admin.content-builder')
            ->layout('components.layouts.dashboard', [
                'title' => 'Design Content - ' . $this->session->title
            ]);
    }

    // Fungsi deteksi kosakata otomatis untuk Preview
    public function highlightVocabulary($text)
    {
        if (empty($text)) return '';

        // Mengambil daftar kata kunci dari database Vocabulary Vault
        $vocabularies = Vocabulary::pluck('word')->toArray();

        // Jika DB kosong, gunakan sampel untuk testing
        if (empty($vocabularies)) {
            $vocabularies = ['accelerating', 'climate', 'mitigate', 'comprehension'];
        }

        foreach ($vocabularies as $vocab) {
            $pattern = '/\b(' . preg_quote($vocab, '/') . ')\b/i';

            // Link ke fitur glosarium interaktif
            $replacement = '<span class="text-brand-600 font-bold border-b-2 border-brand-300 border-dashed cursor-help relative group transition-all hover:bg-brand-50" title="Click for definition">
                $1
                <span class="absolute hidden group-hover:block bottom-full mb-2 left-1/2 -translate-x-1/2 w-64 bg-slate-900 text-white text-xs p-3 rounded-xl shadow-2xl z-50 text-center font-normal tracking-wide leading-relaxed">
                    <strong class="text-brand-400 block mb-1 uppercase text-[10px]">Vocabulary Insight</strong>
                    Definition and context sentence from your vault will be shown here.
                </span>
            </span>';

            $text = preg_replace($pattern, $replacement, $text);
        }

        return nl2br($text);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->sort_order = $this->blocks->count() + 1;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:pbl_intro,reading_text',
            'content_text' => 'required|string',
            'sort_order' => 'required|integer',
        ]);

        Block::updateOrCreate(['id' => $this->block_id], [
            'page_id' => $this->session->id,
            'type' => $this->type,
            'sort_order' => $this->sort_order,
            'content' => ['text' => $this->content_text],
            'settings' => $this->type === 'reading_text' ? [
                'target_wpm' => (int) $this->target_wpm,
                'has_timer' => (bool) $this->has_timer
            ] : [],
        ]);

        $this->isModalOpen = false;
        toast($this->block_id ? 'Block updated!' : 'Content block added!', 'success');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $block = Block::findOrFail($id);
        $this->block_id = $block->id;
        $this->type = $block->type;
        $this->sort_order = $block->sort_order;

        $content = $block->content;
        $settings = $block->settings;

        $this->content_text = $content['text'] ?? '';
        $this->target_wpm = $settings['target_wpm'] ?? 250;
        $this->has_timer = $settings['has_timer'] ?? false;

        $this->isModalOpen = true;
    }

    public function deleteBlock($id)
    {
        Block::findOrFail($id)->delete();
        Alert::success('Deleted!', 'The content block has been removed.');
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
}
