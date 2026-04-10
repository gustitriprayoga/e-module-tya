<?php

namespace App\Livewire\Student;

use App\Models\Module;
use App\Models\CourseSession; // Menggunakan model yang benar
use App\Models\Vocabulary;
use Livewire\Component;

class ModuleReader extends Component
{
    public $module;
    public $currentSession;
    public $contentBlocks = [];
    public $vocabularies = [];

    public function mount($module_slug, $session_id = null)
    {
        // 1. Load Modul beserta seluruh sesinya (diurutkan berdasarkan 'order')
        $this->module = Module::where('slug', $module_slug)->with(['courseSessions' => function ($q) {
            $q->where('is_published', true)->orderBy('order');
        }])->firstOrFail();

        // 2. Tentukan sesi mana yang sedang dibuka
        if ($session_id) {
            $this->currentSession = CourseSession::where('module_id', $this->module->id)->findOrFail($session_id);
        } else {
            // Jika tidak ada ID di URL, buka sesi pertama secara otomatis
            $this->currentSession = $this->module->courseSessions->first();
        }

        // 3. Ekstrak data JSON dari Content Builder (jika ada isinya)
        if ($this->currentSession && $this->currentSession->content) {
            $this->contentBlocks = json_decode($this->currentSession->content, true) ?? [];
        }

        // 4. Ambil semua Vocabulary dari database
        // Diurutkan dari kata terpanjang agar kata pendek tidak menimpa kata yang lebih panjang (misal: "read" vs "reading")
        $this->vocabularies = Vocabulary::orderByRaw('LENGTH(word) DESC')->get();
    }

    /**
     * Fungsi untuk mendeteksi dan menandai kosakata di dalam teks materi
     */
    public function renderHighlightedText($text)
    {
        if (empty($text)) return '';

        foreach ($this->vocabularies as $vocab) {
            // Gunakan Regex batas kata (\b) dan case-insensitive (i)
            $word = preg_quote($vocab->word, '/');
            $pattern = '/\b(' . $word . ')\b/i';

            // HTML Tooltip Interaktif (Muncul saat di-hover mahasiswa)
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
                'title' => $this->currentSession?->title ?? $this->module->title
            ]);
    }
}
