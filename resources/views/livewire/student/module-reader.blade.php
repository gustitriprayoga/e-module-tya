<div class="min-h-screen w-full bg-[#FDFBF7] flex flex-col font-sans relative overflow-x-hidden" x-data="moduleTracker">

    {{-- FLOATING TRACKER (WPM & WAKTU) --}}
    <div
        class="fixed bottom-0 left-0 w-full sm:bottom-6 sm:left-auto sm:right-6 sm:w-auto bg-slate-900/95 backdrop-blur-md text-white p-4 sm:rounded-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.15)] sm:shadow-2xl flex items-center justify-between sm:justify-start gap-4 sm:gap-6 z-50 border-t sm:border border-slate-700 transition-all">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-brand-500 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Time Spent</div>
                <div class="text-lg font-mono font-black leading-tight"
                    x-text="formatTime(globalSeconds + pageSeconds)">0:00</div>
            </div>
        </div>

        <div class="w-px h-8 bg-slate-700 hidden sm:block"></div>

        <div class="text-right sm:text-left">
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Est. WPM</div>
            <div class="text-lg font-mono font-black text-brand-400 leading-tight">
                <span x-text="calculateLiveWPM()"></span>
            </div>
        </div>
    </div>

    {{-- NEW NAVBAR: Ada Tombol Back, Judul Modul, & Progress Bar Rapi --}}
    <nav class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40 w-full shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 py-3 sm:py-4 flex flex-col gap-3">

            <div class="flex items-center justify-between gap-4">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold text-xs sm:text-sm transition-colors shrink-0 active:scale-95">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Back to Dashboard</span>
                    <span class="sm:hidden">Back</span>
                </a>

                <div class="flex-1 text-center">
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-900 line-clamp-1"
                        title="{{ $module->title ?? 'Module Reading' }}">
                        {{ $module->title ?? 'Learning Module' }}
                    </h2>
                </div>

                <div class="w-[80px] sm:w-[160px] shrink-0 opacity-0 pointer-events-none hidden sm:block"></div>
            </div>

            @if ($totalPages > 0)
                <div class="w-full flex items-center gap-3">
                    <span class="text-[10px] font-black uppercase tracking-widest text-brand-600 shrink-0">
                        Page {{ $currentPageIndex + 1 }} / {{ $totalPages }}
                    </span>
                    <div class="flex-1 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-brand-500 h-full transition-all duration-500 ease-out"
                            style="width: {{ (($currentPageIndex + 1) / $totalPages) * 100 }}%"></div>
                    </div>
                </div>
            @endif
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="flex-1 w-full relative z-10">
        <div class="w-full max-w-3xl mx-auto px-5 sm:px-8 py-8 sm:py-12 pb-32 sm:pb-32">

            <div wire:loading wire:target="nextPage, prevPage" class="flex justify-center py-32">
                <div class="flex flex-col items-center gap-3">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-brand-600"></div>
                    <p class="text-sm text-slate-400 font-medium">Loading content...</p>
                </div>
            </div>

            <div wire:loading.remove wire:target="nextPage, prevPage">
                @if ($currentPage)

                    {{-- HEADER HALAMAN & AUDIO PLAYER --}}
                    <header class="mb-8 sm:mb-12 flex flex-col sm:flex-row sm:items-start justify-between gap-4"
                        x-data="audioPlayer">
                        <div class="flex-1">
                            <h1
                                class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight font-serif italic mb-4">
                                {{ $currentPage->title }}
                            </h1>
                            <div class="h-1 w-20 bg-brand-200 rounded-full"></div>
                        </div>

                        <div x-show="hasReadableText" x-cloak
                            class="flex items-center bg-white border border-slate-200 p-1.5 rounded-2xl shadow-sm shrink-0 self-start w-full sm:w-auto mt-4 sm:mt-0">

                            <button @click="togglePlay"
                                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm transition-all focus:outline-none"
                                :class="isPlaying ? 'bg-brand-100 text-brand-700' :
                                    'bg-slate-50 hover:bg-brand-50 text-slate-700 hover:text-brand-600'">
                                <svg x-show="!isPlaying" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                                </svg>
                                <svg x-show="isPlaying" x-cloak class="w-4 h-4 animate-pulse" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>

                                <span
                                    x-text="isPlaying ? 'Pause Reading' : (isPaused ? 'Resume Audio' : 'Listen to Page')"></span>
                            </button>

                            <button @click="stop" x-show="isPlaying || isPaused" x-cloak
                                class="p-2.5 ml-1 rounded-xl text-slate-400 hover:bg-red-50 hover:text-red-500 transition-colors focus:outline-none"
                                title="Stop Audio">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                                </svg>
                            </button>
                        </div>
                    </header>

                    <div class="space-y-12">
                        @forelse($contentBlocks as $block)
                            {{-- BLOK TEXT --}}
                            @if (in_array($block['type'], ['pbl_intro', 'reading_text', 'text']))
                                <div
                                    class="read-aloud-text font-serif text-slate-800 leading-relaxed sm:leading-[1.8] text-lg sm:text-xl text-left sm:text-justify w-full overflow-hidden break-words
                                            [&_.vocab-word]:text-brand-600 [&_.vocab-word]:font-bold
                                            [&_.vocab-word]:border-b-2 [&_.vocab-word]:border-dashed [&_.vocab-word]:border-brand-300
                                            [&_.vocab-word]:cursor-pointer [&_.vocab-word]:rounded [&_.vocab-word]:px-0.5
                                            [&_.vocab-word]:transition-colors [&_.vocab-word]:duration-150">
                                    {!! $this->renderHighlightedText($block['content']['text'] ?? $block['content']) !!}
                                </div>

                                {{-- BLOK QUIZ --}}
                            @elseif($block['type'] === 'quiz')
                                <div
                                    class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm overflow-hidden">
                                    <div class="flex items-center gap-2 mb-4">
                                        <div
                                            class="w-6 h-6 rounded-full bg-brand-500 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-[10px] sm:text-xs font-black uppercase tracking-widest text-brand-600">Knowledge
                                            Check</span>
                                    </div>
                                    <p class="text-lg sm:text-xl font-bold text-slate-900 mb-6 leading-snug">
                                        {{ $block['content']['text'] }}</p>

                                    <div class="space-y-3">
                                        @foreach ($block['content']['options'] as $index => $opt)
                                            @php $status = $userAnswers[$block['id']] ?? null; @endphp
                                            <button
                                                wire:click="checkAnswer({{ $block['id'] }}, {{ $opt['is_correct'] ? 'true' : 'false' }})"
                                                @disabled(isset($userAnswers[$block['id']]))
                                                class="w-full text-left p-4 rounded-2xl border-2 transition-all duration-200 flex items-start sm:items-center gap-4 group
                                                {{ $status === 'correct' && $opt['is_correct'] ? 'border-green-500 bg-green-50' : '' }}
                                                {{ $status && !$opt['is_correct'] ? 'border-slate-100 opacity-40' : '' }}
                                                {{ !$status ? 'border-slate-200 hover:border-brand-300 hover:bg-brand-50 active:scale-[0.99]' : '' }}">

                                                <span
                                                    class="shrink-0 w-8 h-8 rounded-xl flex items-center justify-center text-sm font-black transition-colors {{ $status === 'correct' && $opt['is_correct'] ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-brand-100 group-hover:text-brand-600' }}">
                                                    {{ chr(65 + $index) }}
                                                </span>
                                                <span
                                                    class="font-semibold text-sm sm:text-base leading-snug {{ $status === 'correct' && $opt['is_correct'] ? 'text-green-800' : 'text-slate-700' }} pt-1.5 sm:pt-0">
                                                    {{ $opt['answer'] }}
                                                </span>
                                            </button>
                                        @endforeach
                                    </div>

                                    @if (isset($userAnswers[$block['id']]))
                                        <div
                                            class="mt-6 p-4 rounded-2xl flex items-center gap-3 font-semibold text-sm {{ $userAnswers[$block['id']] === 'correct' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                                            @if ($userAnswers[$block['id']] === 'correct')
                                                <svg class="w-5 h-5 shrink-0 text-green-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Correct! Well done.
                                            @else
                                                <svg class="w-5 h-5 shrink-0 text-red-500" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Not quite. Try reviewing the text above.
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @empty
                            <div class="text-center py-20 bg-white border border-slate-100 rounded-3xl shadow-sm">
                                <p class="text-slate-400 font-bold">Content is being prepared.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- NAVIGASI BUTTONS --}}
                    <div class="mt-16 pt-6 border-t border-slate-200 flex flex-row justify-between items-center gap-4">
                        @if ($currentPageIndex > 0)
                            <button @click="goPrev()"
                                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 sm:px-6 py-3.5 rounded-2xl font-bold text-sm text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 active:scale-[0.98] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Prev
                            </button>
                        @else
                            <div class="flex-1 sm:flex-none"></div>
                        @endif

                        @if ($currentPageIndex < $totalPages - 1)
                            <button @click="goNext()"
                                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-8 sm:px-10 py-3.5 bg-slate-900 text-white rounded-2xl font-bold text-sm shadow-lg shadow-slate-900/20 hover:bg-black active:scale-[0.98] transition-all">
                                Next
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @else
                            <button @click="finish()"
                                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 sm:px-10 py-3.5 bg-brand-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-brand-500/30 hover:bg-brand-700 active:scale-[0.98] transition-all">
                                <span wire:loading.remove wire:target="finishModule" class="flex items-center gap-2">
                                    Finish <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span wire:loading wire:target="finishModule" class="flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Processing...
                                </span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>

    {{-- Tooltip Vocabulary --}}
    <div id="vocab-tooltip"
        class="fixed z-[9999] w-[85%] sm:w-72 bg-slate-900 text-white text-sm p-4 sm:p-5 rounded-2xl shadow-2xl pointer-events-none opacity-0 transition-opacity duration-200"
        aria-hidden="true">
        <div id="vocab-tooltip-inner"></div>
        <div
            class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-900 hidden sm:block">
        </div>
    </div>
</div>

{{-- SCRIPT ALPINE & TOOLTIP --}}
<script>
    document.addEventListener('alpine:init', () => {
        // --- 1. TRACKER & NAVIGATION LOGIC ---
        Alpine.data('moduleTracker', () => ({
            globalSeconds: {{ $totalSeconds ?? 0 }},
            totalWords: {{ $totalWords ?? 0 }},
            pageSeconds: 0,
            timer: null,

            init() {
                this.startTimer();
                window.addEventListener('reset-timer', (e) => {
                    this.globalSeconds = e.detail[0].totalSeconds;
                    this.pageSeconds = 0;
                });
            },

            startTimer() {
                if (this.timer) clearInterval(this.timer);
                this.timer = setInterval(() => {
                    this.pageSeconds++;
                }, 1000);
            },

            calculateLiveWPM() {
                let totalSec = this.globalSeconds + this.pageSeconds;
                if (totalSec < 10) return '--';
                return Math.round((this.totalWords / totalSec) * 60);
            },

            formatTime(sec) {
                let m = Math.floor(sec / 60);
                let s = sec % 60;
                return m + ':' + (s < 10 ? '0' : '') + s;
            },

            goNext() {
                window.speechSynthesis.cancel();
                @this.call('nextPage', this.pageSeconds);
            },
            goPrev() {
                window.speechSynthesis.cancel();
                @this.call('prevPage', this.pageSeconds);
            },
            finish() {
                window.speechSynthesis.cancel();
                @this.call('finishModule', this.pageSeconds);
            }
        }));

        // --- 2. AUDIO PLAYER LOGIC (Text-to-Speech) ---
        Alpine.data('audioPlayer', () => ({
            synth: window.speechSynthesis,
            utterance: null,
            isPlaying: false,
            isPaused: false,
            hasReadableText: false,

            init() {
                // Tampilkan tombol Play hanya jika ada teks untuk dibaca
                setTimeout(() => {
                    this.hasReadableText = document.querySelectorAll('.read-aloud-text')
                        .length > 0;
                }, 100);

                // Stop audio jika mahasiswa keluar dari halaman atau berpindah page
                window.addEventListener('beforeunload', () => this.stop());
                window.addEventListener('reset-timer', () => this.stop());
            },

            togglePlay() {
                if (this.isPlaying) {
                    this.synth.pause();
                    this.isPlaying = false;
                    this.isPaused = true;
                } else if (this.isPaused) {
                    this.synth.resume();
                    this.isPlaying = true;
                    this.isPaused = false;
                } else {
                    // Start fresh: Ambil hanya konten teks pembelajaran (abaikan soal kuis)
                    const textElements = document.querySelectorAll('.read-aloud-text');
                    const textToRead = Array.from(textElements).map(el => el.innerText).join(' . ');

                    if (!textToRead.trim()) return;

                    this.utterance = new SpeechSynthesisUtterance(textToRead);
                    this.utterance.lang = 'en-US'; // Setting ke logat Inggris
                    this.utterance.rate = 0.9; // Kecepatan membaca agak lambat untuk pembelajaran

                    this.utterance.onend = () => {
                        this.resetState();
                    };
                    this.utterance.onerror = (e) => {
                        console.error(e);
                        this.resetState();
                    };

                    this.synth.speak(this.utterance);
                    this.isPlaying = true;
                    this.isPaused = false;
                }
            },

            stop() {
                this.synth.cancel();
                this.resetState();
            },

            resetState() {
                this.isPlaying = false;
                this.isPaused = false;
            }
        }));
    });

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('scrollToTop', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

    // --- 3. TOOLTIP VOCAB LOGIC ---
    const tooltip = document.getElementById('vocab-tooltip');
    const tooltipInner = document.getElementById('vocab-tooltip-inner');
    let activeWord = null;

    function showTooltip(el) {
        const data = el.dataset;
        tooltipInner.innerHTML =
            `
        <div class="flex justify-between items-center mb-3 border-b border-white/10 pb-2">
            <strong class="text-brand-400 text-[10px] uppercase tracking-widest">${data.level || 'Vocab'} | ${data.category || 'General'}</strong>
        </div>
        <div class="mb-2 italic text-sm font-serif leading-relaxed text-slate-100">"${data.definition}"</div>
        ${data.example ? `<div class="text-[10px] text-slate-400 border-t border-white/10 pt-2 mt-3">Example: ${data.example}</div>` : ''}`;

        tooltip.classList.remove('pointer-events-none', 'opacity-0');
        tooltip.classList.add('pointer-events-auto', 'opacity-100');

        const rect = el.getBoundingClientRect();
        const isMobile = window.innerWidth < 640;

        if (isMobile) {
            tooltip.style.bottom = '100px';
            tooltip.style.top = 'auto';
            tooltip.style.left = '50%';
            tooltip.style.transform = 'translateX(-50%)';
        } else {
            tooltip.style.transform = 'none';
            const tw = tooltip.offsetWidth;
            let left = rect.left + rect.width / 2 - tw / 2 + window.scrollX;
            let top = rect.top - tooltip.offsetHeight - 15 + window.scrollY;

            left = Math.max(8, Math.min(left, window.innerWidth - tw - 8));
            if (top < window.scrollY + 8) top = rect.bottom + 10 + window.scrollY;

            tooltip.style.left = left + 'px';
            tooltip.style.top = top + 'px';
            tooltip.style.bottom = 'auto';
        }

        activeWord = el;
    }

    function hideTooltip() {
        tooltip.classList.add('pointer-events-none', 'opacity-0');
        tooltip.classList.remove('pointer-events-auto', 'opacity-100');
        activeWord = null;
    }

    document.addEventListener('click', (e) => {
        const word = e.target.closest('.vocab-word');
        if (word) {
            e.stopPropagation();
            if (activeWord === word) {
                hideTooltip();
                return;
            }
            showTooltip(word);
        } else {
            hideTooltip();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') hideTooltip();
    });
</script>
