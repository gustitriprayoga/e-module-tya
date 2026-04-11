<div class="max-w-5xl mx-auto pb-20" x-data="{ showDetails: false }">

    <div class="text-center mb-12 mt-8">
        <div
            class="w-24 h-24 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-3">Congratulations!</h1>
        <p class="text-lg text-slate-500">You have successfully completed the
            <strong>{{ $currentTest->title }}</strong>.</p>
    </div>

    @if (!$isPostTest)
        <div
            class="bg-white border-2 border-slate-100 rounded-[32px] p-12 text-center max-w-2xl mx-auto shadow-2xl shadow-slate-200/50 mb-10">
            <span class="text-sm font-black text-brand-600 uppercase tracking-widest block mb-4">Initial
                Assessment</span>
            <h3 class="text-2xl font-bold text-slate-700 mb-2">Your Baseline Score</h3>
            <div class="text-7xl font-black text-brand-600 mb-2">{{ number_format($preTestScore, 0) }}</div>
            <div class="text-sm font-bold text-slate-400 mb-8">{{ $testQuestionsCorrect }} out of
                {{ $testQuestionsTotal }} correct</div>

            <p class="text-slate-500 mb-10 max-w-sm mx-auto">This score will be used to measure your improvement
                (N-Gain) after you complete the interactive modules.</p>
            <a href="{{ route('modules.index') }}"
                class="inline-block px-10 py-4 bg-brand-600 text-white rounded-2xl font-black shadow-lg shadow-brand-500/30 hover:bg-brand-700 transition-transform hover:-translate-y-1">Continue
                to Modules &rarr;</a>
        </div>
    @else
        {{-- 1. SCORE CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white border-2 border-slate-100 rounded-[32px] p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-2 bg-slate-200"></div>
                <span class="text-sm font-black text-slate-400 uppercase tracking-widest block mb-4">Initial
                    Knowledge</span>
                <h3 class="text-2xl font-bold text-slate-700 mb-2">Pre-Test Score</h3>
                <div class="text-6xl font-black {{ $preTestScore < 70 ? 'text-slate-400' : 'text-slate-700' }} mb-2">
                    {{ number_format($preTestScore, 0) }}</div>
                <p class="text-slate-400 text-sm font-semibold">Taken previously</p>
            </div>

            <div
                class="bg-white border-2 border-brand-100 rounded-[32px] p-8 text-center relative overflow-hidden shadow-xl shadow-brand-500/10">
                <div class="absolute top-0 inset-x-0 h-2 bg-brand-500"></div>
                <span class="text-sm font-black text-brand-600 uppercase tracking-widest block mb-4">Final
                    Assessment</span>
                <h3 class="text-2xl font-bold text-slate-900 mb-2">Post-Test Score</h3>
                <div class="text-6xl font-black text-brand-600 mb-2">{{ number_format($postTestScore, 0) }}</div>
                <p class="text-brand-500/70 text-sm font-bold">{{ $testQuestionsCorrect }} of {{ $testQuestionsTotal }}
                    answered correctly</p>
            </div>
        </div>

        {{-- 2. READING PERFORMANCE ANALYTICS (NEW) --}}
        <h3 class="text-xl font-extrabold text-slate-900 mb-4 px-2 mt-12">Reading Performance Analytics</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div class="bg-white border border-slate-100 rounded-[24px] p-6 text-center shadow-sm">
                <div
                    class="w-10 h-10 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Reading Speed</div>
                <div class="text-3xl font-black text-slate-800">{{ $readingWpm }}<span
                        class="text-sm font-bold text-slate-400 ml-1">WPM</span></div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[24px] p-6 text-center shadow-sm">
                <div
                    class="w-10 h-10 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Time Spent</div>
                <div class="text-3xl font-black text-slate-800">{{ floor($readingTime / 60) }}<span
                        class="text-sm font-bold text-slate-400 ml-1">m</span> {{ $readingTime % 60 }}<span
                        class="text-sm font-bold text-slate-400 ml-1">s</span></div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[24px] p-6 text-center shadow-sm">
                <div
                    class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Words</div>
                <div class="text-3xl font-black text-slate-800">{{ number_format($readingWords) }}</div>
            </div>

            <div class="bg-white border border-slate-100 rounded-[24px] p-6 text-center shadow-sm">
                <div
                    class="w-10 h-10 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1">In-Module Quizzes
                </div>
                <div
                    class="text-3xl font-black {{ $moduleQuizCorrect == $moduleQuizTotal && $moduleQuizTotal > 0 ? 'text-emerald-500' : 'text-slate-800' }}">
                    {{ $moduleQuizCorrect }}<span
                        class="text-lg font-bold text-slate-300 mx-1">/</span>{{ $moduleQuizTotal }}</div>
            </div>
        </div>

        {{-- 3. N-GAIN HERO --}}
        @php
            $scoreColor = match (true) {
                $nGainCategory === 'Tinggi (High)' => 'text-green-400',
                $nGainCategory === 'Sedang (Medium)' => 'text-amber-400',
                $nGainCategory === 'Rendah (Low)' => 'text-orange-400',
                $nGainCategory === 'Tetap (No Change)' => 'text-slate-300',
                $nGainCategory === 'Maksimal (Perfect)' => 'text-emerald-400',
                $isDecrease => 'text-red-400',
                default => 'text-white',
            };
            $scoreDisplay = $nGainCategory === 'Maksimal (Perfect)' ? 'Perfect' : number_format($nGainScore, 2);
        @endphp

        <div class="bg-slate-900 rounded-[32px] p-10 text-white relative overflow-hidden shadow-2xl mb-8 mt-12">
            <div
                class="absolute -right-20 -top-20 w-64 h-64 bg-brand-500 rounded-full blur-3xl opacity-20 pointer-events-none">
            </div>
            <div
                class="absolute -left-20 -bottom-20 w-64 h-64 bg-purple-500 rounded-full blur-3xl opacity-20 pointer-events-none">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left">
                    <span
                        class="bg-white/10 border border-white/20 text-brand-200 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest mb-4 inline-block">Learning
                        Effectiveness</span>
                    <h2 class="text-3xl font-extrabold mb-2">Normalized Gain (N-Gain)</h2>
                    <p class="text-slate-400 max-w-md">Calculates the actual improvement relative to maximum possible
                        improvement.</p>
                </div>
                <div class="text-center bg-black/30 p-6 rounded-2xl border border-white/10 min-w-[200px]">
                    <div class="text-5xl font-black {{ $scoreColor }} mb-2">{{ $scoreDisplay }}</div>
                    <div class="text-sm font-bold uppercase tracking-widest text-slate-300">
                        Category: <span class="text-white">{{ $nGainCategory }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Toggle Detail Matrix --}}
        <div class="text-center mb-8">
            <button @click="showDetails = !showDetails"
                class="inline-flex items-center gap-2 text-slate-500 hover:text-brand-600 font-bold transition-colors">
                <span x-text="showDetails ? 'Hide Detailed Analytics' : 'View Detailed Analytics Matrix'"></span>
                <svg class="w-5 h-5 transition-transform duration-300" :class="showDetails ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>

        {{-- Detailed Matrix --}}
        <div x-show="showDetails" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4"
            class="bg-white border-2 border-slate-100 rounded-[32px] p-8 shadow-lg shadow-slate-200/50 mb-12" x-cloak>
            <h3 class="text-2xl font-black text-slate-900 mb-8 border-b border-slate-100 pb-4">Research Analytics
                Details</h3>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">1. N-Gain Calculation
                    </h4>
                    <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 font-mono text-sm overflow-x-auto">
                        <p class="text-slate-500 mb-4 border-b border-slate-200 pb-2">Formula: (Post - Pre) / (100 -
                            Pre)</p>
                        <div class="text-lg text-slate-800 leading-relaxed">
                            @if ($nGainCategory === 'Maksimal (Perfect)')
                                <div
                                    class="text-emerald-600 bg-emerald-50 p-4 rounded-xl border border-emerald-100 text-sm">
                                    <strong>Perfect Score Maintained.</strong> Both Pre-Test and Post-Test = 100.</div>
                            @elseif ($preTestScore == 100 && $postTestScore < 100)
                                <div class="text-red-600 bg-red-50 p-4 rounded-xl border border-red-100 text-sm">
                                    <strong>Invalid Formula:</strong> Pre-Test is already 100. Result is a Decrease.
                                </div>
                            @else
                                = ({{ number_format($postTestScore, 0) }} - {{ number_format($preTestScore, 0) }}) /
                                (100 - {{ number_format($preTestScore, 0) }}) <br>
                                = {{ $gainActual }} / {{ $gainMax }} <br>
                                @if ($nGainCategory === 'Tetap (No Change)')
                                    = <strong class="text-slate-500 text-2xl">0.00</strong>
                                @elseif ($isDecrease)
                                    = <strong
                                        class="text-red-500 text-2xl">{{ number_format($nGainScore, 2) }}</strong>
                                @else
                                    = <strong
                                        class="text-brand-600 text-2xl">{{ number_format($nGainScore, 2) }}</strong>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-6">2. N-Gain Criteria
                        Matrix (Hake, 1999)</h4>
                    <div class="space-y-3">
                        @php $isPerfect = ($nGainCategory === 'Maksimal (Perfect)'); @endphp
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $isPerfect ? 'border-emerald-500 bg-emerald-50' : 'border-slate-100 bg-white opacity-50' }}">
                            <div>
                                <div class="font-bold {{ $isPerfect ? 'text-emerald-700' : 'text-slate-700' }}">
                                    Perfect (Sempurna)</div>
                                <div class="text-sm {{ $isPerfect ? 'text-emerald-600' : 'text-slate-500' }}">Pre
                                    &amp; Post = 100</div>
                            </div>
                            @if ($isPerfect)
                                <div
                                    class="bg-emerald-500 text-white text-xs font-black px-3 py-1 rounded-full shrink-0">
                                    Your Result</div>
                            @endif
                        </div>

                        @php $isHigh = ($nGainScore >= 0.7 && !$isDecrease && !$isPerfect); @endphp
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $isHigh ? 'border-green-500 bg-green-50' : 'border-slate-100 bg-white opacity-50' }}">
                            <div>
                                <div class="font-bold {{ $isHigh ? 'text-green-700' : 'text-slate-700' }}">High
                                    (Tinggi)</div>
                                <div class="text-sm {{ $isHigh ? 'text-green-600' : 'text-slate-500' }}">Score &ge;
                                    0.70</div>
                            </div>
                            @if ($isHigh)
                                <div
                                    class="bg-green-500 text-white text-xs font-black px-3 py-1 rounded-full shrink-0">
                                    Your Result</div>
                            @endif
                        </div>

                        @php $isMedium = ($nGainScore >= 0.3 && $nGainScore < 0.7 && !$isDecrease); @endphp
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $isMedium ? 'border-amber-500 bg-amber-50' : 'border-slate-100 bg-white opacity-50' }}">
                            <div>
                                <div class="font-bold {{ $isMedium ? 'text-amber-700' : 'text-slate-700' }}">Medium
                                    (Sedang)</div>
                                <div class="text-sm {{ $isMedium ? 'text-amber-600' : 'text-slate-500' }}">0.30 &le;
                                    Score &lt; 0.70</div>
                            </div>
                            @if ($isMedium)
                                <div
                                    class="bg-amber-500 text-white text-xs font-black px-3 py-1 rounded-full shrink-0">
                                    Your Result</div>
                            @endif
                        </div>

                        @php $isLow = ($nGainScore > 0 && $nGainScore < 0.3 && !$isDecrease); @endphp
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $isLow ? 'border-orange-500 bg-orange-50' : 'border-slate-100 bg-white opacity-50' }}">
                            <div>
                                <div class="font-bold {{ $isLow ? 'text-orange-700' : 'text-slate-700' }}">Low
                                    (Rendah)</div>
                                <div class="text-sm {{ $isLow ? 'text-orange-600' : 'text-slate-500' }}">0 &lt; Score
                                    &lt; 0.30</div>
                            </div>
                            @if ($isLow)
                                <div
                                    class="bg-orange-500 text-white text-xs font-black px-3 py-1 rounded-full shrink-0">
                                    Your Result</div>
                            @endif
                        </div>

                        @php $isNoChange = ($nGainCategory === 'Tetap (No Change)'); @endphp
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $isNoChange ? 'border-slate-500 bg-slate-100' : 'border-slate-100 bg-white opacity-50' }}">
                            <div>
                                <div class="font-bold {{ $isNoChange ? 'text-slate-800' : 'text-slate-700' }}">No
                                    Change (Tetap)</div>
                                <div class="text-sm {{ $isNoChange ? 'text-slate-600' : 'text-slate-500' }}">Score =
                                    0.00</div>
                            </div>
                            @if ($isNoChange)
                                <div
                                    class="bg-slate-700 text-white text-xs font-black px-3 py-1 rounded-full shrink-0">
                                    Your Result</div>
                            @endif
                        </div>

                        @php $isDecreaseRow = ($isDecrease && $nGainCategory !== 'Maksimal (Perfect)'); @endphp
                        <div
                            class="flex items-center justify-between p-4 rounded-2xl border-2 {{ $isDecreaseRow ? 'border-red-500 bg-red-50' : 'border-slate-100 bg-white opacity-50' }}">
                            <div>
                                <div class="font-bold {{ $isDecreaseRow ? 'text-red-700' : 'text-slate-700' }}">
                                    Decrease (Penurunan)</div>
                                <div class="text-sm {{ $isDecreaseRow ? 'text-red-600' : 'text-slate-500' }}">Score
                                    &lt; 0</div>
                            </div>
                            @if ($isDecreaseRow)
                                <div class="bg-red-500 text-white text-xs font-black px-3 py-1 rounded-full shrink-0">
                                    Your Result</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-8">
        <a href="{{ route('dashboard') }}"
            class="w-full sm:w-auto px-8 py-4 bg-white border-2 border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition-colors text-center">Return
            to Dashboard</a>
        @if ($isPostTest)
            <a href="{{ route('modules.index') }}"
                class="w-full sm:w-auto px-10 py-4 bg-brand-600 text-white rounded-2xl font-black shadow-lg shadow-brand-500/30 hover:bg-brand-700 transition-transform hover:-translate-y-1 text-center">Explore
                More Modules &rarr;</a>
        @endif
    </div>
</div>
