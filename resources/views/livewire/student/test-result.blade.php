<div class="max-w-5xl mx-auto pb-20" x-data="{ showDetails: false }">

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
            <strong>{{ $currentTest->title }}</strong>.
        </p>
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
        <div class="bg-slate-900 rounded-[32px] p-10 text-white relative overflow-hidden shadow-2xl mb-8">
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
                    <div
                        class="text-5xl font-black {{ $nGainScore >= 0.3 ? 'text-green-400' : 'text-amber-400' }} mb-2">
                        {{ number_format($nGainScore, 2) }}
                    </div>
                    <div class="text-sm font-bold uppercase tracking-widest text-slate-300">
                        Category: <span class="text-white">{{ $nGainCategory }}</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="text-center mb-8">
        <button @click="showDetails = !showDetails"
            class="inline-flex items-center gap-2 text-slate-500 hover:text-brand-600 font-bold transition-colors">
            <span x-text="showDetails ? 'Hide Detailed Analytics' : 'View Detailed Analytics Matrix'"></span>
            <svg class="w-5 h-5 transition-transform duration-300" :class="showDetails ? 'rotate-180' : ''"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>

    <div x-show="showDetails" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="bg-white border-2 border-slate-100 rounded-[32px] p-8 shadow-lg shadow-slate-200/50 mb-12" x-cloak>

        <h3 class="text-2xl font-black text-slate-900 mb-8 border-b border-slate-100 pb-4">Research Analytics Details
        </h3>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <div>
                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">1. Learning Journey</h4>

                <div class="relative border-l-2 border-slate-200 ml-3 space-y-6 mb-10">
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-slate-300 ring-4 ring-white">
                        </div>
                        <div class="font-bold text-slate-900">Pre-Test Completed</div>
                        <div class="text-slate-500 text-sm">Initial score recorded: <span
                                class="font-black text-slate-700">{{ number_format($preTestScore, 0) }}</span></div>
                    </div>
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-brand-500 ring-4 ring-white">
                        </div>
                        <div class="font-bold text-brand-600">Speed Reading Modules</div>
                        <div class="text-slate-500 text-sm">Interactive materials & mid-module quizzes completed.</div>
                    </div>
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-green-500 ring-4 ring-white">
                        </div>
                        <div class="font-bold text-slate-900">Post-Test Completed</div>
                        <div class="text-slate-500 text-sm">Final score recorded: <span
                                class="font-black text-slate-700">{{ number_format($postTestScore, 0) }}</span></div>
                    </div>
                </div>

                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">2. N-Gain Calculation</h4>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 font-mono text-sm overflow-x-auto">
                    <p class="text-slate-500 mb-4 border-b border-slate-200 pb-2">Formula: (PostTest - PreTest) / (100 -
                        PreTest)</p>

                    <div class="text-lg text-slate-800 leading-relaxed">
                        @if ($preTestScore == 100 && $postTestScore < 100)
                            <div class="text-red-600 bg-red-50 p-4 rounded-xl border border-red-100">
                                <strong>Kondisi Khusus (Invalid N-Gain):</strong> <br>
                                Nilai Pre-Test sudah maksimal (100), sehingga pembagi menjadi nol (100-100=0). Karena
                                nilai Post-Test menurun menjadi {{ $postTestScore }}, maka nilai N-Gain secara akademis
                                dikategorikan sebagai <strong class="uppercase">Penurunan (Decrease)</strong>.
                            </div>
                        @elseif($isDecrease)
                            = ({{ number_format($postTestScore, 0) }} - {{ number_format($preTestScore, 0) }}) / (100
                            - {{ number_format($preTestScore, 0) }}) <br>
                            = <span class="text-red-500">{{ $gainActual }}</span> / {{ $gainMax }} <br>
                            <div
                                class="mt-2 text-red-600 bg-red-50 p-3 rounded-lg border border-red-100 text-sm font-bold">
                                Terjadi Penurunan Nilai (Negative Gain). N-Gain disesuaikan menjadi 0.
                            </div>
                        @elseif($preTestScore == 100 && $postTestScore == 100)
                            <div class="text-green-600 bg-green-50 p-4 rounded-xl border border-green-100">
                                Nilai sudah mencapai titik maksimal (100) sejak awal dan dipertahankan.
                            </div>
                        @else
                            = ({{ number_format($postTestScore, 0) }} - {{ number_format($preTestScore, 0) }}) / (100
                            - {{ number_format($preTestScore, 0) }}) <br>
                            = {{ $gainActual }} / {{ $gainMax }} <br>
                            = <strong class="text-brand-600 text-2xl">{{ number_format($nGainScore, 2) }}</strong>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">3. N-Gain Criteria Matrix
                    (Hake, 1999)</h4>

                <div class="space-y-3">
                    <div
                        class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $nGainScore >= 0.7 ? 'border-green-500 bg-green-50' : 'border-slate-100 bg-white opacity-60' }}">
                        <div>
                            <div class="font-bold {{ $nGainScore >= 0.7 ? 'text-green-700' : 'text-slate-700' }}">High
                                (Tinggi)</div>
                            <div class="text-sm {{ $nGainScore >= 0.7 ? 'text-green-600' : 'text-slate-500' }}">Score
                                &ge; 0.70</div>
                        </div>
                        @if ($nGainScore >= 0.7)
                            <div class="bg-green-500 text-white text-xs font-black px-3 py-1 rounded-full">Your Result
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $nGainScore >= 0.3 && $nGainScore < 0.7 ? 'border-amber-500 bg-amber-50' : 'border-slate-100 bg-white opacity-60' }}">
                        <div>
                            <div
                                class="font-bold {{ $nGainScore >= 0.3 && $nGainScore < 0.7 ? 'text-amber-700' : 'text-slate-700' }}">
                                Medium (Sedang)</div>
                            <div
                                class="text-sm {{ $nGainScore >= 0.3 && $nGainScore < 0.7 ? 'text-amber-600' : 'text-slate-500' }}">
                                0.30 &le; Score &lt; 0.70</div>
                        </div>
                        @if ($nGainScore >= 0.3 && $nGainScore < 0.7)
                            <div class="bg-amber-500 text-white text-xs font-black px-3 py-1 rounded-full">Your Result
                            </div>
                        @endif
                    </div>

                    <div
                        class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $nGainScore < 0.3 ? 'border-red-500 bg-red-50' : 'border-slate-100 bg-white opacity-60' }}">
                        <div>
                            <div class="font-bold {{ $nGainScore < 0.3 ? 'text-red-700' : 'text-slate-700' }}">Low
                                (Rendah)</div>
                            <div class="text-sm {{ $nGainScore < 0.3 ? 'text-red-600' : 'text-slate-500' }}">Score &lt;
                                0.30</div>
                        </div>
                        @if ($nGainScore < 0.3)
                            <div class="bg-red-500 text-white text-xs font-black px-3 py-1 rounded-full">Your Result
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

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
