<div class="relative z-10 max-w-7xl mx-auto pb-12">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                Welcome back, {{ explode(' ', Auth::user()->name)[0] }}! 👋
            </h1>
            <p class="text-lg text-slate-500">Here is a quick overview of your reading progress.</p>
        </div>
        <div>
            <a href="{{ route('modules.index') }}"
                class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1">
                Continue Learning
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                    </path>
                </svg>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div
            class="bg-white border border-slate-100 rounded-[32px] p-8 shadow-sm flex items-center gap-6 transition-transform hover:-translate-y-1">
            <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Modules Done</p>
                <h3 class="text-3xl font-black text-slate-900">{{ $completedModules }} <span
                        class="text-lg text-slate-400 font-medium">/ {{ $totalModules }}</span></h3>
            </div>
        </div>

        <div
            class="bg-white border border-slate-100 rounded-[32px] p-8 shadow-sm flex items-center gap-6 transition-transform hover:-translate-y-1">
            <div class="w-16 h-16 bg-brand-50 text-brand-500 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Average Score</p>
                <h3 class="text-3xl font-black text-slate-900">{{ number_format($averageScore, 1) }}</h3>
            </div>
        </div>

        <div
            class="bg-white border border-slate-100 rounded-[32px] p-8 shadow-sm flex items-center gap-6 transition-transform hover:-translate-y-1">
            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Tests Completed</p>
                <h3 class="text-3xl font-black text-slate-900">{{ count($recentActivities) }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-100 rounded-[32px] overflow-hidden shadow-sm">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-xl font-extrabold text-slate-900">Recent Learning History</h3>
            <a href="{{ route('modules.index') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700">View
                Curriculum &rarr;</a>
        </div>

        <div class="p-0">
            @if (count($recentActivities) > 0)
                <div class="divide-y divide-slate-100">
                    @foreach ($recentActivities as $activity)
                        <div
                            class="p-6 hover:bg-slate-50 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-5">
                                <div
                                    class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 {{ $activity->test && $activity->test->type === 'post-test' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                    @if ($activity->test && $activity->test->type === 'post-test')
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-lg">
                                        {{ $activity->test->title ?? 'Module Assessment' }}</h4>
                                    <p class="text-sm text-slate-500 font-medium">
                                        Completed on {{ $activity->created_at->format('d M Y, h:i A') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Score</div>
                                <div
                                    class="text-3xl font-black {{ $activity->score >= 70 ? 'text-emerald-500' : 'text-slate-700' }}">
                                    {{ number_format($activity->score, 0) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-16 text-center">
                    <div
                        class="w-24 h-24 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-2">No Activity Yet</h4>
                    <p class="text-slate-500 max-w-md mx-auto leading-relaxed">You haven't completed any tests or
                        modules yet. Head over to the Course Modules to get started!</p>
                </div>
            @endif
        </div>
    </div>
</div>
