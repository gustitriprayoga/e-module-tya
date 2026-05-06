<div class="min-h-[100dvh] lg:h-[100dvh] bg-slate-50 flex flex-col relative" x-data="{ timer: @entangle('timeLeft') }"
    x-init="setInterval(() => {
        if (timer > 0) timer--;
        else $wire.submitTest()
    }, 1000)">

    {{-- NAVBAR (Sticky Top) --}}
    <nav
        class="bg-white/95 backdrop-blur-md border-b border-slate-200 px-4 sm:px-6 py-3 sm:py-4 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="flex items-center gap-3 sm:gap-4 flex-1">
            <span
                class="bg-brand-600 text-white px-2 py-1 sm:px-3 sm:py-1 rounded-lg font-black text-[10px] sm:text-sm tracking-widest uppercase shrink-0">
                TEST
            </span>
            <h2 class="font-bold text-slate-800 text-sm sm:text-base line-clamp-1 max-w-[150px] sm:max-w-none">
                {{ $test->title }}
            </h2>
        </div>

        <div
            class="flex items-center gap-2 sm:gap-3 bg-red-50 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl border border-red-100 text-red-600 font-black shadow-inner shrink-0 ml-2">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="text-sm sm:text-base font-mono"
                x-text="Math.floor(timer / 60) + ':' + (timer % 60).toString().padStart(2, '0')"></span>
        </div>
    </nav>

    {{-- KONTEN UTAMA --}}
    <div class="flex-1 flex flex-col lg:flex-row lg:overflow-hidden w-full max-w-[100vw]">

        @php $currentQ = $questions[$currentQuestionIndex]; @endphp

        {{-- READING PASSAGE AREA --}}
        @if ($currentQ->testPassage)
            <div
                class="w-full lg:w-1/2 bg-white p-5 sm:p-8 lg:p-12 lg:h-full lg:overflow-y-auto border-b-4 border-slate-100 lg:border-b-0 lg:border-r lg:border-slate-200 z-10 custom-scrollbar shrink-0 lg:shrink">
                <div class="max-w-2xl mx-auto">
                    <h3
                        class="flex items-center gap-2 text-slate-400 uppercase tracking-widest text-xs font-black mb-4 sm:mb-6">
                        <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        {{ $currentQ->testPassage->title ?: 'Reading Passage' }}
                    </h3>
                    <div
                        class="leading-relaxed sm:leading-[1.8] font-serif text-lg sm:text-xl text-slate-800 text-justify selection:bg-brand-100 pb-4 lg:pb-0 break-words">
                        {!! nl2br(e($currentQ->testPassage->content)) !!}
                    </div>
                </div>
            </div>
        @endif

        {{-- QUESTION & ANSWER AREA --}}
        <div
            class="{{ $currentQ->testPassage ? 'w-full lg:w-1/2' : 'w-full max-w-3xl mx-auto' }} p-5 sm:p-8 lg:p-12 lg:h-full lg:overflow-y-auto bg-slate-50 custom-scrollbar flex flex-col justify-between">

            <div class="max-w-xl mx-auto w-full">
                <div
                    class="mb-6 sm:mb-8 bg-white p-5 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex flex-wrap items-center gap-2 mb-3 sm:mb-4">
                        <span
                            class="bg-brand-50 text-brand-600 px-2.5 py-1 rounded-md font-black text-[10px] sm:text-xs uppercase tracking-widest border border-brand-100 shrink-0">
                            Question {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}
                        </span>

                        @if ($currentQ->indicator)
                            <span
                                class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md font-bold text-[10px] sm:text-xs tracking-widest uppercase shrink-0">
                                {{ $currentQ->indicator }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-lg sm:text-2xl font-bold text-slate-900 leading-snug break-words">
                        {{ $currentQ->question_text }}
                    </h1>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    @foreach ($currentQ->options as $index => $option)
                        <button wire:click="selectAnswer({{ $currentQ->id }}, {{ $option->id }})"
                            class="w-full flex items-start gap-3 sm:gap-4 p-4 sm:p-5 rounded-xl sm:rounded-2xl border-2 transition-all text-left focus:outline-none group
                            {{ isset($answers[$currentQ->id]) && $answers[$currentQ->id] == $option->id ? 'border-brand-600 bg-brand-50 shadow-md ring-4 ring-brand-500/10' : 'border-slate-200/80 bg-white hover:border-brand-300 hover:bg-slate-50 shadow-sm' }}">

                            <span
                                class="shrink-0 w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center text-sm font-black transition-colors
                                {{ isset($answers[$currentQ->id]) && $answers[$currentQ->id] == $option->id ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-400 group-hover:bg-brand-100 group-hover:text-brand-600' }}">
                                {{ chr(65 + $index) }}
                            </span>
                            <span
                                class="flex-1 font-semibold text-sm sm:text-base text-slate-700 pt-1 leading-snug break-words">
                                {{ $option->option_text }}
                            </span>
                        </button>
                    @endforeach
                </div>

                {{-- Helper text jika belum memilih jawaban --}}
                @if (!isset($answers[$currentQ->id]))
                    <p class="text-center text-red-500 font-bold text-xs mt-4 animate-pulse">
                        * Please select an answer to continue
                    </p>
                @endif
            </div>

            {{-- NAVIGASI BAWAH DENGAN VALIDASI DISABLED --}}
            <div
                class="max-w-xl mx-auto w-full mt-10 sm:mt-12 pt-6 border-t border-slate-200 flex justify-between items-center gap-3">
                <button wire:click="previousQuestion" @disabled($currentQuestionIndex == 0)
                    class="flex items-center justify-center gap-1 sm:gap-2 px-4 sm:px-6 py-3.5 rounded-xl sm:rounded-2xl font-bold text-sm text-slate-500 hover:text-slate-800 hover:bg-white border border-transparent hover:border-slate-200 transition-all disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:border-transparent">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Previous</span>
                    <span class="sm:hidden">Prev</span>
                </button>

                @if ($currentQuestionIndex == count($questions) - 1)
                    {{-- TOMBOL FINISH: Terkunci jika soal terakhir belum dijawab --}}
                    <button onclick="confirmSubmit()" @disabled(!isset($answers[$currentQ->id]))
                        class="flex flex-1 sm:flex-none items-center justify-center gap-2 px-6 sm:px-10 py-3.5 rounded-xl sm:rounded-2xl font-black text-sm transition-all whitespace-nowrap
                        bg-brand-600 text-white shadow-lg shadow-brand-500/30 hover:bg-brand-700 hover:-translate-y-0.5 active:scale-95
                        disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-brand-600 disabled:hover:transform-none disabled:active:scale-100 disabled:shadow-none">
                        Finish <span class="hidden sm:inline">Test</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                @else
                    {{-- TOMBOL NEXT: Terkunci jika soal ini belum dijawab --}}
                    <button wire:click="nextQuestion" @disabled(!isset($answers[$currentQ->id]))
                        class="flex flex-1 sm:flex-none items-center justify-center gap-2 px-6 sm:px-10 py-3.5 rounded-xl sm:rounded-2xl font-black text-sm transition-all whitespace-nowrap
                        bg-slate-900 text-white shadow-lg shadow-slate-900/20 hover:bg-black hover:-translate-y-0.5 active:scale-95
                        disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-slate-900 disabled:hover:transform-none disabled:active:scale-100 disabled:shadow-none">
                        Next <span class="hidden sm:inline">Question</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @endif
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background-color: #94a3b8;
        }
    </style>
</div>

@script
    <script>
        window.confirmSubmit = function() {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                title: 'Finish and Submit?',
                text: "Make sure you have answered all questions. You cannot change your answers after submitting.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, Submit Now',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[32px] shadow-2xl border border-slate-100',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.submitTest();
                }
            });
        }
    </script>
@endscript
