<div class="relative z-10 max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
            Course Modules
        </h1>
        <p class="text-lg text-slate-500">Explore your curriculum and track your learning progress.</p>
    </div>

    @if (!$hasCompletedPreTest)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-8 flex items-start gap-4">
            <div class="bg-amber-100 text-amber-600 p-2 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-amber-800">Action Required</h3>
                <p class="text-amber-700 text-sm mt-1">You must complete the <strong>Pre-Test</strong> on your Dashboard
                    before you can access these modules.</p>
                <a href="{{ route('dashboard') }}"
                    class="inline-block mt-3 text-sm font-bold text-amber-800 hover:text-amber-900 underline">Go to
                    Dashboard &rarr;</a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($modules as $index => $module)
            <div class="relative group h-full flex flex-col">

                @if (!$hasCompletedPreTest)
                    <div
                        class="bg-slate-50 border-2 border-slate-200 border-dashed rounded-[32px] p-8 opacity-60 flex flex-col h-full cursor-not-allowed">
                        <div class="absolute top-8 right-8 text-slate-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>

                        <div
                            class="w-14 h-14 bg-slate-200 text-slate-400 rounded-2xl flex items-center justify-center font-black text-2xl mb-6">
                            {{ $index + 1 }}
                        </div>
                        <h4 class="text-xl font-extrabold text-slate-400 mb-3">{{ $module->title }}</h4>
                        <p class="text-slate-400 text-sm line-clamp-3 mb-6 flex-grow">{{ $module->description }}</p>

                        <div class="pt-6 border-t border-slate-200/50 mt-auto">
                            <span
                                class="text-slate-400 font-bold text-xs uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Locked Content
                            </span>
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white border border-slate-200 hover:border-brand-400 rounded-[32px] p-8 shadow-lg shadow-slate-200/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col h-full relative overflow-hidden">

                        <div
                            class="absolute -right-10 -top-10 w-32 h-32 bg-brand-50 rounded-full blur-2xl opacity-50 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex justify-between items-start mb-6">
                                <div
                                    class="w-14 h-14 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center font-black text-2xl group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300">
                                    {{ $index + 1 }}
                                </div>

                                <span
                                    class="bg-slate-50 text-slate-500 font-bold text-[10px] uppercase tracking-widest px-3 py-1 rounded-lg border border-slate-100 flex items-center gap-1">
                                    <svg class="w-3 h-3 text-brand-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                    {{ $module->pages_count }} Pages
                                </span>
                            </div>

                            <h4
                                class="text-xl font-extrabold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                                {{ $module->title }}</h4>
                            <p class="text-slate-500 text-sm line-clamp-3 mb-8 flex-grow">{{ $module->description }}</p>

                            <div class="pt-6 border-t border-slate-100 mt-auto flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">
                                    Status: Unlocked
                                </span>

                                <a href="{{ route('student.reader', $module->slug) }}"
                                    class="inline-flex items-center justify-center gap-2 bg-brand-50 hover:bg-brand-600 text-brand-600 hover:text-white px-5 py-2.5 rounded-xl font-bold transition-all duration-300 active:scale-95 group-hover:bg-brand-600 group-hover:text-white">
                                    Start
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div
                class="col-span-full py-20 text-center border-2 border-slate-100 border-dashed rounded-[32px] bg-slate-50/50">
                <div
                    class="w-16 h-16 bg-slate-200 text-slate-400 rounded-2xl flex items-center justify-center font-black mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">No Modules Yet</h3>
                <p class="text-slate-500 mt-1">The instructor has not published any modules.</p>
            </div>
        @endforelse
    </div>
</div>
