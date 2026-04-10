<div class="relative z-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            Welcome, {{ explode(' ', Auth::user()->name)[0] }}! 👋
        </h1>
        <p class="text-slate-500 mt-2">Your Speed Reading learning journey starts here.</p>
    </div>

    @if (!$hasCompletedPreTest && $preTest)
        <div
            class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] p-10 md:p-16 shadow-2xl shadow-brand-500/10 text-center max-w-3xl mx-auto relative overflow-hidden">
            <div
                class="absolute -top-24 -right-24 w-64 h-64 bg-brand-100 rounded-full blur-3xl opacity-50 pointer-events-none">
            </div>
            <div
                class="absolute -bottom-24 -left-24 w-64 h-64 bg-accent-100 rounded-full blur-3xl opacity-50 pointer-events-none">
            </div>

            <div class="relative z-10">
                <div
                    class="w-24 h-24 bg-brand-50 text-brand-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border-4 border-white">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>

                <h2 class="text-3xl font-black text-slate-900 mb-4">Course Material is Locked</h2>
                <p class="text-lg text-slate-600 mb-8 max-w-lg mx-auto leading-relaxed">
                    To personalize your learning experience and measure your progress, you must complete the <strong
                        class="text-brand-600">{{ $preTest->title }}</strong> before accessing the modules.
                </p>

                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-6 max-w-md mx-auto mb-8 text-left">
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-bold text-slate-500">Test Duration:</span>
                        <span class="font-black text-slate-900">{{ $preTest->duration }} Minutes</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-slate-500">Total Questions:</span>
                        <span class="font-black text-slate-900">{{ $preTest->questions()->count() }} Items</span>
                    </div>
                </div>

                <a href="{{ route('student.test', $preTest->id) }}"
                    class="inline-flex items-center gap-3 bg-brand-600 hover:bg-brand-700 text-white px-10 py-4 rounded-2xl font-black shadow-lg shadow-brand-500/30 transition-all hover:scale-105 hover:-translate-y-1">
                    START PRE-TEST NOW
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    @else
        @if ($preTestScore !== null)
            <div
                class="bg-gradient-to-r from-brand-600 to-accent-600 rounded-[32px] p-8 text-white shadow-xl shadow-brand-500/20 mb-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <span
                        class="bg-white/20 px-3 py-1 rounded-lg text-xs font-black uppercase tracking-widest backdrop-blur-sm border border-white/10 mb-3 inline-block">Initial
                        Assessment</span>
                    <h2 class="text-2xl font-bold">Pre-test Completed!</h2>
                    <p class="text-brand-100 mt-1">Your baseline score has been recorded. Let's improve it together.</p>
                </div>
                <div class="text-center bg-white/10 px-8 py-4 rounded-2xl backdrop-blur-md border border-white/20">
                    <div class="text-sm font-bold text-brand-100 uppercase tracking-widest mb-1">Your Score</div>
                    <div class="text-4xl font-black">{{ number_format($preTestScore, 1) }}</div>
                </div>
            </div>
        @endif

        <div class="mb-6 flex justify-between items-end">
            <h3 class="text-xl font-extrabold text-slate-900">Learning Modules</h3>
            <span class="text-sm font-bold text-slate-500">{{ count($modules) }} Modules Available</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($modules as $index => $module)
                <a href="{{ route('student.reader', ['module_slug' => $module->slug]) }}"
                    class="group bg-white/80 backdrop-blur-xl border border-white hover:border-brand-300 rounded-[32px] p-6 shadow-xl shadow-slate-200/50 transition-all duration-300 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center font-black text-xl mb-6 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                        {{ $index + 1 }}
                    </div>
                    <h4 class="text-lg font-extrabold text-slate-900 mb-2">{{ $module->title }}</h4>
                    <p class="text-slate-500 text-sm line-clamp-2 mb-6">{{ $module->description }}</p>

                    <div class="flex items-center text-brand-600 font-bold text-sm">
                        Start Learning
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-2 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-10 text-center border border-slate-100">
                    <p class="text-slate-500 font-bold">No modules available yet. Please wait for the instructor to
                        publish them.</p>
                </div>
            @endforelse
        </div>
    @endif
</div>
