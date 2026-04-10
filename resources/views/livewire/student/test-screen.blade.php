<div class="min-h-screen bg-slate-50 flex flex-col" x-data="{ timer: @entangle('timeLeft') }" x-init="setInterval(() => { if (timer > 0) timer--;
    else $wire.submitTest() }, 1000)">

    <nav class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <span class="bg-brand-600 text-white px-3 py-1 rounded-lg font-black text-sm">TEST</span>
            <h2 class="font-bold text-slate-800">{{ $test->title }}</h2>
        </div>

        <div
            class="flex items-center gap-3 bg-red-50 px-4 py-2 rounded-2xl border border-red-100 text-red-600 font-black">
            <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span x-text="Math.floor(timer / 60) + ':' + (timer % 60).toString().padStart(2, '0')"></span>
        </div>
    </nav>

    <div class="flex-1 flex overflow-hidden">
        @php $currentQ = $questions[$currentQuestionIndex]; @endphp

        @if ($currentQ->passage)
            <div
                class="w-1/2 bg-white p-12 overflow-y-auto border-r border-slate-200 leading-relaxed font-serif text-xl text-slate-800 selection:bg-brand-100">
                <div class="max-w-2xl mx-auto">
                    <h3 class="text-slate-400 uppercase tracking-widest text-xs font-black mb-6">Reading Passage</h3>
                    {!! nl2br(e($currentQ->passage)) !!}
                </div>
            </div>
        @endif

        <div class="{{ $currentQ->passage ? 'w-1/2' : 'max-w-3xl mx-auto w-full' }} p-12 overflow-y-auto bg-slate-50">
            <div class="max-w-xl mx-auto">
                <div class="mb-8">
                    <span class="text-brand-600 font-black text-xs uppercase tracking-widest">Question
                        {{ $currentQuestionIndex + 1 }} of {{ count($questions) }}</span>
                    <h1 class="text-2xl font-bold text-slate-900 mt-2">{{ $currentQ->question_text }}</h1>
                </div>

                <div class="space-y-4">
                    @foreach ($currentQ->options as $index => $option)
                        <button wire:click="selectAnswer({{ $currentQ->id }}, {{ $option->id }})"
                            class="w-full flex items-start gap-4 p-5 rounded-2xl border-2 transition-all text-left {{ $answers[$currentQ->id] == $option->id ? 'border-brand-600 bg-brand-50 shadow-md ring-4 ring-brand-500/10' : 'border-white bg-white hover:border-slate-200 shadow-sm' }}">
                            <span
                                class="w-8 h-8 rounded-lg flex items-center justify-center font-black {{ $answers[$currentQ->id] == $option->id ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-400' }}">
                                {{ chr(65 + $index) }}
                            </span>
                            <span class="flex-1 font-medium text-slate-700 mt-1">{{ $option->option_text }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="mt-12 flex justify-between items-center">
                    <button wire:click="previousQuestion" @disabled($currentQuestionIndex == 0)
                        class="px-6 py-3 rounded-xl font-bold text-slate-400 hover:text-slate-600 disabled:opacity-30">
                        &larr; Previous
                    </button>

                    @if ($currentQuestionIndex == count($questions) - 1)
                        <button onclick="confirmSubmit()"
                            class="px-10 py-3 bg-brand-600 text-white rounded-2xl font-black shadow-lg shadow-brand-500/30 hover:scale-105 transition-transform">
                            Finish Test
                        </button>
                    @else
                        <button wire:click="nextQuestion"
                            class="px-10 py-3 bg-slate-900 text-white rounded-2xl font-black shadow-lg hover:bg-slate-800 transition-all">
                            Next Question &rarr;
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        window.confirmSubmit = function() {
            Swal.fire({
                title: 'Finish and Submit?',
                text: "Make sure you have answered all questions.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Yes, Submit Now'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.submitTest();
                }
            });
        }
    </script>
@endscript
