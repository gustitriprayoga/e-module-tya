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
    public $userAnswers = [];

    // --- TRACKER GLOBAL SPEED READING ---
    public $totalWords = 0;
    public $totalSeconds = 0;

    public function mount($module_slug)
    {
        $this->module = Module::where('slug', $module_slug)->firstOrFail();
        $this->pages = Page::where('module_id', $this->module->id)
            ->where('is_published', 1)
            ->orderBy('order_number', 'asc')
            ->get();

        $this->totalPages = $this->pages->count();

        // 1. Hitung total KATA di seluruh modul ini di awal
        $this->totalWords = $this->calculateTotalWords();

        if ($this->totalPages > 0) {
            $this->loadPage(0);
        }
    }

    private function calculateTotalWords()
    {
        $pageIds = $this->pages->pluck('id');
        $blocks = Block::whereIn('page_id', $pageIds)
            ->whereIn('type', ['pbl_intro', 'reading_text', 'text'])
            ->get();

        $words = 0;
        foreach ($blocks as $b) {
            $text = is_array($b->content) ? ($b->content['text'] ?? '') : $b->content;
            $words += str_word_count(strip_tags($text));
        }
        return $words;
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

    public function checkAnswer($blockId, $isCorrect)
    {
        if (!isset($this->userAnswers[$blockId])) {
            $this->userAnswers[$blockId] = $isCorrect ? 'correct' : 'wrong';
        }
    }

    // --- LOGIKA PENYIMPANAN WAKTU DARI ALPINE JS ---
    public function syncTime($seconds)
    {
        $this->totalSeconds += $seconds;
    }

    public function nextPage($pageSeconds = 0)
    {
        $this->syncTime($pageSeconds);
        $this->loadPage($this->currentPageIndex + 1);
        $this->dispatch('scrollToTop');

        // Kirim event ke frontend untuk reset timer halaman
        $this->dispatch('reset-timer', ['totalSeconds' => $this->totalSeconds]);
    }

    public function prevPage($pageSeconds = 0)
    {
        $this->syncTime($pageSeconds);
        $this->loadPage($this->currentPageIndex - 1);
        $this->dispatch('scrollToTop');

        $this->dispatch('reset-timer', ['totalSeconds' => $this->totalSeconds]);
    }

    public function finishModule($pageSeconds = 0)
    {
        // Tambahkan detik dari halaman terakhir
        $this->syncTime($pageSeconds);

        // Kalkulasi Global WPM
        $finalWpm = $this->totalSeconds > 0 ? round(($this->totalWords / $this->totalSeconds) * 60) : 0;


        $quizCorrect = count(array_filter($this->userAnswers, fn($status) => $status === 'correct'));
        $quizTotal = \App\Models\Block::whereIn('page_id', $this->pages->pluck('id'))->where('type', 'quiz')->count();

        // --- SIMPAN KE DATABASE (Persistent) ---
        if (auth()->check()) {
            \App\Models\ReadingHistory::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'module_id' => $this->module->id,
                    'block_id' => null, // Module-level analytics
                ],
                [
                    'time_spent' => $this->totalSeconds,
                    'wpm' => $finalWpm,
                    'total_words' => $this->totalWords,
                    'quiz_correct' => $quizCorrect,
                    'quiz_total' => $quizTotal,
                ]
            );
        }

        // SIMPAN KE SESSION: Agar tetap bisa diambil jika diperlukan
        session()->put('module_' . $this->module->id . '_wpm', $finalWpm);
        session()->put('module_' . $this->module->id . '_time', $this->totalSeconds);
        session()->put('module_' . $this->module->id . '_words', $this->totalWords);
        session()->put('module_' . $this->module->id . '_quiz_correct', $quizCorrect);
        session()->put('module_' . $this->module->id . '_quiz_total', $quizTotal);

        $postTest = \App\Models\Test::where('type', 'post-test')
            ->where('module_id', $this->module->id)
            ->where('is_active', true)
            ->first();

        if ($postTest) {
            $alreadyTaken = \App\Models\TestResult::where('user_id', auth()->id())->where('test_id', $postTest->id)->exists();
            if ($alreadyTaken) {
                return redirect()->route('student.test.result', $postTest->id);
            } else {
                return redirect()->route('student.test', $postTest->id);
            }
        }
        session()->flash('message', 'Module completed! No Post-Test available yet.');
        return redirect()->route('modules.index');
    }

    // --- ALGORITMA VOCAB HIGHLIGHTER (TOKENIZER SUPER CEPAT) ---
    public function renderHighlightedText($text)
    {
        if (empty($text)) return '';

        // Ambil dictionary sebagai array Key-Value (Sangat ringan di memori)
        $dict = \Illuminate\Support\Facades\Cache::remember('vocab_dict_v4', 3600, function () {
            $vocabs = \App\Models\Vocabulary::select('word', 'definition', 'context_sentence', 'level', 'category')->get();
            if ($vocabs->isEmpty()) return [];

            $d = [];
            foreach ($vocabs as $v) {
                $d[strtolower($v->word)] = $v->toArray();
            }
            return $d;
        });

        if (empty($dict)) return $text;

        // Pisahkan tag HTML dari Teks Biasa
        $chunks = preg_split('/(<[^>]+>)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);
        $result = '';

        foreach ($chunks as $chunk) {
            if ($chunk === '' || $chunk === null) continue;

            // Jika ini tag HTML (misal: <p>, <b>), langsung lewati tanpa diproses
            if (str_starts_with($chunk, '<') && str_ends_with($chunk, '>')) {
                $result .= $chunk;
                continue;
            }

            // Memecah teks menjadi kata per kata (mempertahankan spasi & tanda baca)
            $tokens = preg_split('/(\W+)/u', $chunk, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

            foreach ($tokens as $token) {
                // Cek apakah token ini adalah kata (huruf) atau hanya tanda baca/spasi
                if (preg_match('/^\w+$/u', $token)) {
                    $lowerWord = strtolower($token);

                    // Cek di Dictionary Array
                    if (isset($dict[$lowerWord])) {
                        $v = $dict[$lowerWord];
                        $result .= '<span class="vocab-word" ' .
                            'data-word="' . htmlspecialchars($v['word'], ENT_QUOTES) . '" ' .
                            'data-definition="' . htmlspecialchars($v['definition'], ENT_QUOTES) . '" ' .
                            'data-example="' . htmlspecialchars($v['context_sentence'] ?? '', ENT_QUOTES) . '" ' .
                            'data-level="' . htmlspecialchars($v['level'] ?? 'Vocab', ENT_QUOTES) . '" ' .
                            'data-category="' . htmlspecialchars($v['category'] ?? 'General', ENT_QUOTES) . '">' .
                            $token . '</span>';
                    } else {
                        $result .= $token; // Bukan kosa kata target
                    }
                } else {
                    $result .= $token; // Tanda baca / Spasi
                }
            }
        }

        return $result;
    }

    public function render()
    {
        return view('livewire.student.module-reader')
            ->layout('components.layouts.reader', [
                'title' => $this->currentPage?->title ?? $this->module->title
            ]);
    }
}
