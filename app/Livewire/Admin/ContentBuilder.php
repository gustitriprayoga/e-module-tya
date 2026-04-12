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

    // Quiz Properties
    public $option_a, $option_b, $option_c, $correct_answer = 'A';

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

    public function create()
    {
        $this->resetInputFields();
        $this->sort_order = $this->blocks->count() + 1;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|in:pbl_intro,reading_text,quiz',
            'content_text' => 'required|string',
            'sort_order' => 'required|integer',
            // Validasi tambahan jika tipe quiz
            'option_a' => 'required_if:type,quiz',
            'option_b' => 'required_if:type,quiz',
            'option_c' => 'required_if:type,quiz',
        ]);

        $dataContent = ['text' => $this->content_text];

        // Simpan struktur kuis ke dalam JSON content
        if ($this->type === 'quiz') {
            $dataContent['options'] = [
                ['answer' => $this->option_a, 'is_correct' => $this->correct_answer === 'A'],
                ['answer' => $this->option_b, 'is_correct' => $this->correct_answer === 'B'],
                ['answer' => $this->option_c, 'is_correct' => $this->correct_answer === 'C'],
            ];
        }

        Block::updateOrCreate(['id' => $this->block_id], [
            'page_id' => $this->session->id,
            'type' => $this->type,
            'sort_order' => $this->sort_order,
            'content' => $dataContent,
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
        $this->content_text = $content['text'] ?? '';

        if ($this->type === 'quiz' && isset($content['options'])) {
            $this->option_a = $content['options'][0]['answer'] ?? '';
            $this->option_b = $content['options'][1]['answer'] ?? '';
            $this->option_c = $content['options'][2]['answer'] ?? '';

            if ($content['options'][0]['is_correct']) $this->correct_answer = 'A';
            elseif ($content['options'][1]['is_correct']) $this->correct_answer = 'B';
            elseif ($content['options'][2]['is_correct']) $this->correct_answer = 'C';
        }

        $this->isModalOpen = true;
    }

    public function highlightVocabulary($text)
    {
        return $text; // Return teks aslinya saja, highlighter aslinya berjalan di ModuleReader (student)
    }

    private function resetInputFields()
    {
        $this->block_id = null;
        $this->type = 'pbl_intro';
        $this->content_text = '';
        $this->option_a = '';
        $this->option_b = '';
        $this->option_c = '';
        $this->correct_answer = 'A';
        $this->sort_order = '';
    }
}
