<div class="min-h-screen w-full bg-[#FDFBF7] flex flex-col font-sans" x-data="moduleTracker">

    {{-- FLOATING TRACKER (WPM & WAKTU) --}}
    <div
        class="fixed bottom-6 right-6 bg-slate-900/90 backdrop-blur-md text-white p-4 rounded-3xl shadow-2xl flex items-center gap-5 z-50 border border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-brand-500 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Time Spent</div>
                <div class="text-lg font-mono font-black" x-text="formatTime(globalSeconds + pageSeconds)">0:00</div>
            </div>
        </div>
        <div class="w-px h-8 bg-slate-700"></div>
        <div>
            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Est. WPM</div>
            <div class="text-lg font-mono font-black text-brand-400">
                <span x-text="calculateLiveWPM()"></span>
            </div>
        </div>
    </div>

    {{-- Navbar --}}
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between gap-4">
            <a href="{{ route('dashboard') }}"
                class="text-slate-400 hover:text-slate-700 transition-colors p-2 -ml-2 rounded-xl hover:bg-slate-100 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="text-sm font-semibold hidden sm:inline">Exit</span>
            </a>
            @if ($totalPages > 0)
                <div class="flex-1 max-w-xs flex flex-col items-center gap-1">
                    <span
                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $currentPageIndex + 1 }}
                        / {{ $totalPages }}</span>
                    <div class="w-full bg-slate-100 rounded-full h-1.5">
                        <div class="bg-brand-500 h-1.5 rounded-full transition-all duration-500 ease-out"
                            style="width: {{ (($currentPageIndex + 1) / $totalPages) * 100 }}%"></div>
                    </div>
                </div>
            @endif
            <div class="w-16"></div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="flex-1 w-full">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 py-10 pb-32">

            <div wire:loading wire:target="nextPage, prevPage" class="flex justify-center py-32">
                <div class="flex flex-col items-center gap-3">
                    <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-brand-600"></div>
                    <p class="text-sm text-slate-400 font-medium">Loading...</p>
                </div>
            </div>

            <div wire:loading.remove wire:target="nextPage, prevPage">
                @if ($currentPage)
                    <header class="mb-10">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="text-xs font-bold uppercase tracking-widest text-brand-500 bg-brand-50 px-3 py-1 rounded-full">Page
                                {{ $currentPageIndex + 1 }}</span>
                        </div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight font-serif italic">
                            {{ $currentPage->title }}</h1>
                        <div class="mt-4 h-0.5 bg-gradient-to-r from-brand-200 to-transparent rounded-full"></div>
                    </header>

                    <div class="space-y-10">
                        @forelse($contentBlocks as $block)
                            @if (in_array($block['type'], ['pbl_intro', 'reading_text', 'text']))
                                <div
                                    class="font-serif text-slate-800 leading-[1.95] text-lg sm:text-xl text-justify
                                            [&_.vocab-word]:text-brand-600 [&_.vocab-word]:font-bold
                                            [&_.vocab-word]:border-b-2 [&_.vocab-word]:border-dashed [&_.vocab-word]:border-brand-300
                                            [&_.vocab-word]:cursor-pointer [&_.vocab-word]:rounded [&_.vocab-word]:px-0.5
                                            [&_.vocab-word]:transition-colors [&_.vocab-word]:duration-150">
                                    {!! $this->renderHighlightedText($block['content']['text'] ?? $block['content']) !!}
                                </div>
                            @elseif($block['type'] === 'quiz')
                                <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm">
                                    <div class="flex items-center gap-2 mb-5">
                                        <div class="w-6 h-6 rounded-full bg-brand-500 flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-xs font-black uppercase tracking-widest text-brand-600">Knowledge
                                            Check</span>
                                    </div>
                                    <p class="text-base sm:text-lg font-bold text-slate-900 mb-5 leading-snug">
                                        {{ $block['content']['text'] }}</p>
                                    <div class="space-y-3">
                                        @foreach ($block['content']['options'] as $index => $opt)
                                            @php $status = $userAnswers[$block['id']] ?? null; @endphp
                                            <button
                                                wire:click="checkAnswer({{ $block['id'] }}, {{ $opt['is_correct'] ? 'true' : 'false' }})"
                                                @disabled(isset($userAnswers[$block['id']]))
                                                class="w-full text-left p-4 rounded-2xl border-2 transition-all duration-200 flex items-center gap-3 group
                                                {{ $status === 'correct' && $opt['is_correct'] ? 'border-green-500 bg-green-50' : '' }}
                                                {{ $status && !$opt['is_correct'] ? 'border-slate-100 opacity-40' : '' }}
                                                {{ !$status ? 'border-slate-200 hover:border-brand-300 hover:bg-brand-50 active:scale-[0.99]' : '' }}">
                                                <span
                                                    class="shrink-0 w-8 h-8 rounded-xl flex items-center justify-center text-sm font-black transition-colors {{ $status === 'correct' && $opt['is_correct'] ? 'bg-green-500 text-white' : 'bg-slate-100 text-slate-500 group-hover:bg-brand-100 group-hover:text-brand-600' }}">
                                                    {{ chr(65 + $index) }}
                                                </span>
                                                <span
                                                    class="font-semibold text-sm sm:text-base leading-snug {{ $status === 'correct' && $opt['is_correct'] ? 'text-green-800' : 'text-slate-700' }}">
                                                    {{ $opt['answer'] }}
                                                </span>
                                            </button>
                                        @endforeach
                                    </div>
                                    @if (isset($userAnswers[$block['id']]))
                                        <div
                                            class="mt-5 p-4 rounded-2xl flex items-center gap-3 font-semibold text-sm {{ $userAnswers[$block['id']] === 'correct' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
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
                            <div class="text-center py-20">
                                <p class="text-slate-400 text-sm">Content is being prepared.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- NAVIGASI BUTTON MENGGUNAKAN ALPINE ACTIONS --}}
                    <div class="mt-16 pt-6 border-t border-slate-200 flex justify-between items-center gap-4">
                        @if ($currentPageIndex > 0)
                            <button @click="goPrev()"
                                class="flex items-center gap-2 px-5 py-3 rounded-2xl font-semibold text-sm text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 active:scale-[0.98] transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if ($currentPageIndex < $totalPages - 1)
                            <button @click="goNext()"
                                class="flex items-center gap-2 px-7 py-3 bg-slate-900 text-white rounded-2xl font-bold text-sm shadow-lg hover:bg-black active:scale-[0.98] transition-all">
                                Next <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @else
                            <button @click="finish()"
                                class="flex items-center gap-2 px-7 py-3 bg-brand-600 text-white rounded-2xl font-bold text-sm shadow-lg hover:bg-brand-700 active:scale-[0.98] transition-all">
                                <span wire:loading.remove wire:target="finishModule"
                                    class="flex items-center gap-2">Finish Module <svg class="w-4 h-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg></span>
                                <span wire:loading wire:target="finishModule" class="flex items-center gap-2"><svg
                                        class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg> Processing...</span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>

    {{-- Tooltip Vocabulary --}}
    <div id="vocab-tooltip"
        class="fixed z-[9999] w-72 bg-slate-900 text-white text-sm p-4 rounded-2xl shadow-2xl pointer-events-none opacity-0 transition-opacity duration-200"
        aria-hidden="true">
        <div id="vocab-tooltip-inner"></div>
        <div class="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-slate-900"></div>
    </div>
</div>

{{-- SCRIPT ALPINE & TOOLTIP --}}
<script>
    // Daftarkan Alpine component sebelum Alpine memproses halaman
    document.addEventListener('alpine:init', () => {
        Alpine.data('moduleTracker', () => ({
            // Ambil variabel PHP awal dengan syntax Laravel
            globalSeconds: {{ $totalSeconds ?? 0 }},
            totalWords: {{ $totalWords ?? 0 }},
            pageSeconds: 0,
            timer: null,

            init() {
                // Mulai timer saat komponen dimuat
                this.startTimer();

                // Dengarkan event dari Livewire saat berganti halaman
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
                if (totalSec < 10)
            return '--'; // Jangan hitung di 10 detik pertama (terlalu fluktuatif)
                return Math.round((this.totalWords / totalSec) * 60);
            },

            formatTime(sec) {
                let m = Math.floor(sec / 60);
                let s = sec % 60;
                return m + ':' + (s < 10 ? '0' : '') + s;
            },

            // Fungsi Navigasi
            goNext() {
                @this.call('nextPage', this.pageSeconds);
            },
            goPrev() {
                @this.call('prevPage', this.pageSeconds);
            },
            finish() {
                @this.call('finishModule', this.pageSeconds);
            }
        }));
    });

    // --- TOOLTIP LOGIC ---
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('scrollToTop', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

    const tooltip = document.getElementById('vocab-tooltip');
    const tooltipInner = document.getElementById('vocab-tooltip-inner');
    let activeWord = null;

    function showTooltip(el) {
        const data = el.dataset;
        tooltipInner.innerHTML =
            `
        <div class="flex justify-between items-center mb-2 border-b border-white/20 pb-2">
            <strong class="text-brand-400 text-[10px] uppercase tracking-widest">${data.level || 'Vocab'} | ${data.category || 'General'}</strong>
        </div>
        <div class="mb-2 italic text-sm font-serif leading-relaxed">"${data.definition}"</div>
        ${data.example ? `<div class="text-[10px] text-slate-400 border-t border-white/10 pt-2 mt-2">Example: ${data.example}</div>` : ''}`;

        tooltip.classList.remove('pointer-events-none', 'opacity-0');
        tooltip.classList.add('pointer-events-auto', 'opacity-100');

        const rect = el.getBoundingClientRect();
        const tw = tooltip.offsetWidth;
        let left = rect.left + rect.width / 2 - tw / 2 + window.scrollX;
        let top = rect.top - tooltip.offsetHeight - 10 + window.scrollY;

        left = Math.max(8, Math.min(left, window.innerWidth - tw - 8));
        if (top < window.scrollY + 8) top = rect.bottom + 10 + window.scrollY;

        tooltip.style.left = left + 'px';
        tooltip.style.top = top + 'px';
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
