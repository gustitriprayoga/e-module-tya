<?php

namespace App\Livewire\Student;

use App\Models\Module;
use App\Models\Page;
use App\Models\Block;
use App\Models\Vocabulary;
use Livewire\Component;

class ModuleReader extends Component
{
    public $module;
    public $pages;
    public $currentPage;
    public $currentPageIndex = 0;
    public $totalPages = 0;

    public $contentBlocks = [];
    public $vocabularies = [];

    public function mount($module_slug)
    {
        // 1. Load Modul
        $this->module = Module::where('slug', $module_slug)->firstOrFail();

        // 2. Load Semua Halaman (Pages) yang sudah di-publish, urutkan berdasarkan nomor halaman
        $this->pages = Page::where('module_id', $this->module->id)
            ->where('is_published', 1)
            ->orderBy('order_number', 'asc')
            ->get();

        $this->totalPages = $this->pages->count();
        $this->vocabularies = Vocabulary::orderByRaw('LENGTH(word) DESC')->get();

        // 3. Langsung buka halaman pertama (index 0) jika ada
        if ($this->totalPages > 0) {
            $this->loadPage(0);
        }
    }

    // Fungsi untuk memuat data halaman beserta blok materinya
    public function loadPage($index)
    {
        if ($index >= 0 && $index < $this->totalPages) {
            $this->currentPageIndex = $index;
            $this->currentPage = $this->pages[$index];

            // Ambil materi dari Content Builder
            $blocks = Block::where('page_id', $this->currentPage->id)
                ->orderBy('sort_order', 'asc')
                ->get();

            $this->contentBlocks = $blocks->map(function ($block) {
                return [
                    'type' => in_array($block->type, ['pbl_intro', 'reading_text']) ? 'text' : $block->type,
                    'content' => $block->content['text'] ?? ''
                ];
            })->toArray();
        }
    }

    // Navigasi ala Buku
    public function nextPage()
    {
        $this->loadPage($this->currentPageIndex + 1);
        $this->dispatch('scrollToTop'); // Akan membuat layar otomatis scroll ke atas saat ganti halaman
    }

    public function prevPage()
    {
        $this->loadPage($this->currentPageIndex - 1);
        $this->dispatch('scrollToTop');
    }

    public function renderHighlightedText($text)
    {
        if (empty($text)) return '';

        foreach ($this->vocabularies as $vocab) {
            $word = preg_quote($vocab->word, '/');
            $pattern = '/\b(' . $word . ')\b/i';

            $replacement = '<span class="text-brand-600 font-extrabold border-b-2 border-brand-300 border-dashed cursor-help relative group transition-all hover:bg-brand-50 rounded px-0.5">
                $1
                <span class="absolute hidden group-hover:block bottom-full mb-2 left-1/2 -translate-x-1/2 w-64 bg-slate-900 text-white text-xs p-4 rounded-2xl shadow-2xl z-50 font-normal normal-case tracking-normal leading-relaxed text-left">
                    <div class="flex justify-between items-center mb-2 border-b border-white/20 pb-2">
                        <strong class="text-brand-400 uppercase text-[10px] tracking-widest">' . ($vocab->level ?? 'Vocab') . ' | ' . ($vocab->category ?? 'General') . '</strong>
                    </div>
                    <div class="mb-2 italic text-sm font-serif">"' . $vocab->definition . '"</div>
                    ' . ($vocab->context_sentence ? '<div class="text-[10px] text-slate-400 border-t border-white/10 pt-2 mt-2">Example: ' . $vocab->context_sentence . '</div>' : '') . '
                    <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-900"></div>
                </span>
            </span>';

            $text = preg_replace($pattern, $replacement, $text);
        }

        return $text;
    }

    public function render()
    {
        return view('livewire.student.module-reader')
            ->layout('components.layouts.reader', [
                'title' => $this->currentPage?->title ?? $this->module->title
            ]);
    }
}
