<div class="max-w-5xl mx-auto pb-20">
    <div class="text-center mb-12 mt-8">
        <div
            class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-3">Congratulations!</h1>
        <p class="text-lg text-slate-500">You have successfully completed the
            <strong>{{ $currentTest->title }}</strong>.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <div class="bg-white border-2 border-slate-100 rounded-[32px] p-8 text-center relative overflow-hidden">
            <div class="absolute top-0 inset-x-0 h-2 bg-slate-200"></div>
            <span class="text-sm font-black text-slate-400 uppercase tracking-widest block mb-4">Initial
                Knowledge</span>
            <h3 class="text-2xl font-bold text-slate-700 mb-2">Pre-Test Score</h3>
            <div class="text-6xl font-black {{ $preTestScore < 70 ? 'text-slate-400' : 'text-slate-700' }} mb-4">
                {{ number_format($preTestScore, 0) }}
            </div>
            <p class="text-slate-500 text-sm">Taken before module completion</p>
        </div>

        <div
            class="bg-white border-2 border-brand-100 rounded-[32px] p-8 text-center relative overflow-hidden shadow-xl shadow-brand-500/10">
            <div class="absolute top-0 inset-x-0 h-2 bg-brand-500"></div>
            <span class="text-sm font-black text-brand-600 uppercase tracking-widest block mb-4">Final Assessment</span>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Post-Test Score</h3>
            <div class="text-6xl font-black text-brand-600 mb-4">
                {{ number_format($postTestScore, 0) }}
            </div>
            <p class="text-slate-500 text-sm">After completing Speed Reading Module</p>
        </div>

    </div>

    @if ($preTestResult)
        <div class="bg-slate-900 rounded-[32px] p-10 text-white relative overflow-hidden shadow-2xl mb-12">
            <div
                class="absolute -right-20 -top-20 w-64 h-64 bg-brand-500 rounded-full blur-3xl opacity-20 pointer-events-none">
            </div>
            <div
                class="absolute -left-20 -bottom-20 w-64 h-64 bg-accent-500 rounded-full blur-3xl opacity-20 pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left">
                    <span
                        class="bg-white/10 border border-white/20 text-brand-200 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest mb-4 inline-block">Learning
                        Effectiveness</span>
                    <h2 class="text-3xl font-extrabold mb-2">Normalized Gain (N-Gain)</h2>
                    <p class="text-slate-400 max-w-md">This metric calculates the actual improvement in your reading
                        comprehension relative to your maximum possible improvement.</p>
                </div>

                <div class="text-center bg-black/30 p-6 rounded-2xl border border-white/10 min-w-[200px]">
                    <div class="text-5xl font-black {{ $nGainScore > 0.3 ? 'text-green-400' : 'text-amber-400' }} mb-2">
                        {{ number_format($nGainScore, 2) }}
                    </div>
                    <div class="text-sm font-bold uppercase tracking-widest text-slate-300">
                        Category: <span class="text-white">{{ $nGainCategory }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
        <a href="{{ route('dashboard') }}"
            class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition-colors text-center">
            Return to Dashboard
        </a>
        <a href="{{ route('modules.index') }}"
            class="w-full sm:w-auto px-10 py-4 bg-brand-600 text-white rounded-2xl font-black shadow-lg shadow-brand-500/30 hover:bg-brand-700 transition-transform hover:-translate-y-1 text-center">
            Explore More Modules &rarr;
        </a>
    </div>
</div>
