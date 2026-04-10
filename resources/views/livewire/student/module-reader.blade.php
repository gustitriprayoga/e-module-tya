<div class="min-h-screen bg-[#FDFBF7] flex flex-col font-sans" id="reader-container">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between gap-6">

            <a href="{{ route('dashboard') }}"
                class="text-slate-400 hover:text-slate-700 transition-colors p-2 -ml-2 rounded-xl hover:bg-slate-50 flex items-center gap-2"
                title="Save & Exit">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                <span class="text-sm font-bold hidden md:inline">Exit</span>
            </a>

            @if ($totalPages > 0)
                <div class="flex-1 max-w-2xl mx-auto flex flex-col justify-center items-center">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">
                        Page {{ $currentPageIndex + 1 }} of {{ $totalPages }}
                    </span>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-brand-500 h-1.5 rounded-full transition-all duration-500 ease-out"
                            style="width: {{ (($currentPageIndex + 1) / $totalPages) * 100 }}%"></div>
                    </div>
                </div>
            @endif

            <div class="w-16"></div>
        </div>
    </nav>

    <main class="flex-1 w-full max-w-4xl mx-auto px-6 py-12 md:py-16">

        <div wire:loading wire:target="nextPage, prevPage" class="w-full flex justify-center py-20">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-brand-600"></div>
        </div>

        <div wire:loading.remove wire:target="nextPage, prevPage">
            @if ($currentPage)

                <header class="mb-12 border-b border-slate-200/60 pb-8 text-center md:text-left">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                        {{ $currentPage->title }}
                    </h1>
                    @if ($currentPage->description)
                        <p class="text-lg text-slate-500 font-medium leading-relaxed max-w-2xl">
                            {{ $currentPage->description }}</p>
                    @endif
                </header>

                <article
                    class="prose prose-lg md:prose-xl prose-slate max-w-none prose-headings:font-black prose-headings:tracking-tight prose-p:leading-relaxed prose-a:text-brand-600 hover:prose-a:text-brand-700">

                    @forelse($contentBlocks as $block)
                        <div class="mb-8">
                            @if ($block['type'] === 'text')
                                <div class="font-serif text-slate-800 leading-loose text-justify">
                                    {!! $this->renderHighlightedText($block['content']) !!}
                                </div>
                            @elseif($block['type'] === 'image')
                                <figure
                                    class="my-12 rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 border border-slate-100 bg-white">
                                    <img src="{{ $block['content'] }}" alt="Module Illustration"
                                        class="w-full h-auto object-cover">
                                </figure>
                            @elseif($block['type'] === 'video')
                                <div
                                    class="my-12 aspect-video rounded-3xl overflow-hidden shadow-xl shadow-slate-200/50 border border-slate-100 bg-slate-900">
                                    <iframe src="{{ $block['content'] }}" class="w-full h-full" frameborder="0"
                                        allowfullscreen></iframe>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div
                            class="text-center py-20 px-6 bg-white/50 border border-slate-200 border-dashed rounded-3xl">
                            <p class="text-slate-500 font-medium">Page content is empty.</p>
                        </div>
                    @endforelse

                </article>

                <div class="mt-24 pt-8 border-t border-slate-200 flex justify-between items-center gap-4">

                    @if ($currentPageIndex > 0)
                        <button wire:click="prevPage"
                            class="px-6 md:px-8 py-4 rounded-2xl font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition-all flex items-center gap-2 shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="hidden md:inline">Previous Page</span>
                            <span class="md:hidden">Prev</span>
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if ($currentPageIndex < $totalPages - 1)
                        <button wire:click="nextPage"
                            class="px-8 md:px-10 py-4 bg-slate-900 text-white rounded-2xl font-black shadow-xl shadow-slate-900/20 hover:bg-black hover:-translate-y-1 transition-all flex items-center gap-3">
                            Next Page
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    @else
                        <button
                            class="px-8 md:px-10 py-4 bg-brand-600 text-white rounded-2xl font-black shadow-xl shadow-brand-500/30 hover:bg-brand-700 hover:-translate-y-1 transition-all flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Complete & Take Post-Test
                        </button>
                    @endif

                </div>
            @else
                <div class="text-center py-32">
                    <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Module is Empty</h2>
                    <p class="text-slate-500">The instructor has not published any pages yet.</p>
                </div>
            @endif
        </div>
    </main>
</div>

@script
    <script>
        $wire.on('scrollToTop', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
@endscript
