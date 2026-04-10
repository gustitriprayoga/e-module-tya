<div class="min-h-screen bg-slate-50 flex flex-col md:flex-row">

    <aside
        class="w-full md:w-80 bg-white border-r border-slate-200 flex-shrink-0 flex flex-col h-auto md:h-screen md:sticky top-0 shadow-sm z-10">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <a href="{{ route('dashboard') }}"
                class="text-xs font-bold text-slate-500 hover:text-brand-600 uppercase tracking-widest flex items-center gap-2 mb-4 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Dashboard
            </a>
            <h2 class="text-xl font-black text-slate-900 leading-snug">{{ $module->title }}</h2>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-1">
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] px-3 mb-3 mt-2">Course Sessions
            </div>

            @forelse($module->courseSessions as $index => $session)
                <a href="{{ route('student.reader', ['module_slug' => $module->slug, 'session_id' => $session->id]) }}"
                    class="flex items-start gap-3 p-3 rounded-2xl transition-all duration-200 group {{ $currentSession && $currentSession->id == $session->id ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/30' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700' }}">

                    <div
                        class="mt-0.5 font-black text-sm {{ $currentSession && $currentSession->id == $session->id ? 'text-brand-200' : 'text-slate-300 group-hover:text-brand-300' }}">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="flex-1">
                        <div class="font-bold text-sm leading-snug">{{ $session->title }}</div>
                    </div>

                    @if ($currentSession && $currentSession->id == $session->id)
                        <svg class="w-5 h-5 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </a>
            @empty
                <div
                    class="p-6 text-center text-sm text-slate-500 font-medium bg-slate-50 rounded-2xl border border-slate-100 border-dashed">
                    No sessions have been published yet.
                </div>
            @endforelse
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-[#FDFBF7]">
        @if ($currentSession)
            <div class="max-w-3xl mx-auto py-12 px-6 md:py-16 md:px-12">

                <header class="mb-12 border-b border-slate-200/60 pb-8">
                    <span
                        class="text-brand-600 font-black text-sm uppercase tracking-[0.2em] mb-3 block flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        Reading Material
                    </span>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                        {{ $currentSession->title }}
                    </h1>
                    @if ($currentSession->description)
                        <p class="text-lg text-slate-600 font-medium leading-relaxed">{{ $currentSession->description }}
                        </p>
                    @endif
                </header>

                <article
                    class="prose prose-lg prose-slate max-w-none prose-headings:font-black prose-headings:tracking-tight prose-p:leading-relaxed prose-a:text-brand-600 hover:prose-a:text-brand-700 marker:text-brand-500">

                    @forelse($contentBlocks as $block)
                        <div class="mb-8">

                            @if ($block['type'] === 'text')
                                <div class="font-serif text-lg text-slate-800 leading-loose text-justify">
                                    {{-- Menggunakan {!! !!} agar tag HTML (termasuk tooltip Highlight) dirender dengan benar --}}
                                    {!! $this->renderHighlightedText($block['content']) !!}
                                </div>
                            @elseif($block['type'] === 'image')
                                <figure
                                    class="my-10 rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 border border-slate-100 bg-white">
                                    <img src="{{ $block['content'] }}" alt="Course Illustration"
                                        class="w-full h-auto object-cover hover:scale-105 transition-transform duration-700">
                                </figure>
                            @elseif($block['type'] === 'video')
                                <div
                                    class="my-10 aspect-video rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 border border-slate-100 bg-slate-900">
                                    <iframe src="{{ $block['content'] }}" class="w-full h-full" frameborder="0"
                                        allowfullscreen></iframe>
                                </div>
                            @endif

                        </div>
                    @empty
                        <div
                            class="text-center py-20 px-6 bg-white/50 backdrop-blur-sm border border-slate-200 border-dashed rounded-3xl">
                            <div
                                class="w-20 h-20 bg-brand-50 text-brand-500 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Content Not Ready</h3>
                            <p class="text-slate-500 font-medium">The instructor is still preparing the materials for
                                this session.</p>
                        </div>
                    @endforelse
                </article>

                @if (count($contentBlocks) > 0)
                    <div
                        class="mt-20 pt-8 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                        <a href="{{ route('dashboard') }}"
                            class="w-full sm:w-auto px-6 py-3.5 rounded-2xl font-bold text-slate-500 hover:bg-slate-100 hover:text-slate-700 transition-colors text-center">
                            &larr; Back to Modules
                        </a>

                        <button
                            class="w-full sm:w-auto px-8 py-3.5 bg-brand-600 text-white rounded-2xl font-black shadow-lg shadow-brand-500/30 hover:bg-brand-700 hover:scale-105 transition-all focus:ring-4 focus:ring-brand-500/20 active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mark as Completed
                        </button>
                    </div>
                @endif

            </div>
        @else
            <div class="flex items-center justify-center h-full min-h-[60vh]">
                <div class="text-center">
                    <div
                        class="w-24 h-24 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-800 mb-2">No Sessions Available</h3>
                    <p class="text-slate-500">Please select a session from the left sidebar to start reading.</p>
                </div>
            </div>
        @endif
    </main>
</div>
