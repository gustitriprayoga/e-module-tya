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

    // Properti untuk menyimpan jawaban kuis mahasiswa
    public $userAnswers = [];

    public function mount($module_slug)
    {
        $this->module = Module::where('slug', $module_slug)->firstOrFail();
        $this->pages = Page::where('module_id', $this->module->id)
            ->where('is_published', 1)
            ->orderBy('order_number', 'asc')
            ->get();

        $this->totalPages = $this->pages->count();
        $this->vocabularies = Vocabulary::orderByRaw('LENGTH(word) DESC')->get();

        if ($this->totalPages > 0) {
            $this->loadPage(0);
        }
    }

    public function loadPage($index)
    {
        if ($index >= 0 && $index < $this->totalPages) {
            $this->currentPageIndex = $index;
            $this->currentPage = $this->pages[$index];

            $blocks = Block::where('page_id', $this->currentPage->id)
                ->orderBy('sort_order', 'asc')
                ->get();

            $this->contentBlocks = $blocks->map(function ($block) {
                return [
                    'id' => $block->id,
                    'type' => $block->type,
                    'content' => $block->content
                ];
            })->toArray();
        }
    }

    // Fungsi untuk mengecek jawaban kuis
    public function checkAnswer($blockId, $isCorrect)
    {
        if (!isset($this->userAnswers[$blockId])) {
            $this->userAnswers[$blockId] = $isCorrect ? 'correct' : 'wrong';
        }
    }

    public function nextPage()
    {
        $this->loadPage($this->currentPageIndex + 1);
        $this->dispatch('scrollToTop');
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

            $level    = htmlspecialchars($vocab->level ?? 'Vocab', ENT_QUOTES);
            $category = htmlspecialchars($vocab->category ?? 'General', ENT_QUOTES);
            $def      = htmlspecialchars($vocab->definition, ENT_QUOTES);
            $example  = htmlspecialchars($vocab->context_sentence ?? '', ENT_QUOTES);

            $replacement = '<span
            class="vocab-word text-brand-600 font-bold border-b-2 border-dashed border-brand-300 cursor-pointer rounded px-0.5 transition-colors hover:bg-brand-50 active:bg-brand-100"
            role="button"
            tabindex="0"
            data-level="' . $level . '"
            data-category="' . $category . '"
            data-definition="' . $def . '"
            data-example="' . $example . '"
        >$1</span>';

            $text = preg_replace($pattern, $replacement, $text);
        }

        return $text;
    }

    public function finishModule()
    {
        // 1. Cari Post-Test yang sedang aktif
        $postTest = \App\Models\Test::where('type', 'post-test')
            ->where('is_active', true)
            ->first();

        if ($postTest) {
            // 2. Cek apakah mahasiswa ini sudah pernah mengerjakan Post-Test tersebut
            $alreadyTaken = \App\Models\TestResult::where('user_id', auth()->id())
                ->where('test_id', $postTest->id)
                ->exists();

            if ($alreadyTaken) {
                // Jika SUDAH mengerjakan, langsung arahkan ke halaman Rapor (Test Result)
                // PERBAIKAN: Kirim ID-nya secara langsung
                return redirect()->route('student.test.result', $postTest->id);
            } else {
                // Jika BELUM mengerjakan, arahkan ke halaman Ujian (Test Screen)
                // PERBAIKAN: Kirim ID-nya secara langsung
                return redirect()->route('student.test', $postTest->id);
            }
        }

        // 3. Fallback: Jika admin belum membuat soal Post-Test
        session()->flash('message', 'Module completed! Waiting for instructor to publish the Post-Test.');
        return redirect()->route('modules.index');
    }

    public function render()
    {
        return view('livewire.student.module-reader')
            ->layout('components.layouts.reader', [
                'title' => $this->currentPage?->title ?? $this->module->title
            ]);
    }
}
