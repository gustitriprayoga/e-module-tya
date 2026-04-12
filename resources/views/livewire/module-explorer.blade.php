<div class="relative min-h-screen overflow-hidden pt-32 pb-20">
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-sky-50"></div>
        <div
            class="absolute -top-40 -left-40 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-50 animate-blob">
        </div>
        <div
            class="absolute top-1/2 -right-40 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-50 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-40 left-1/4 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-50 animate-blob animation-delay-4000">
        </div>
        <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-[0.03]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">

        <div class="mb-12 text-center" x-show="shown" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-8">
            <span
                class="px-4 py-1.5 rounded-full bg-brand-100 text-brand-700 border border-brand-200 font-bold text-sm mb-4 inline-block tracking-wide">LitFlow
                Curriculum</span>
            <h1 class="text-5xl font-extrabold text-slate-950 mb-4 tracking-tight">Interactive Modules</h1>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg">Explore our curated speed reading curriculum designed to
                boost your English proficiency and critical thinking skills.</p>
        </div>

        <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-200"
            x-transition:enter-start="opacity-0 translate-y-8"
            class="mb-12 p-4 md:p-6 bg-white/60 backdrop-blur-2xl rounded-[32px] border border-white shadow-xl shadow-slate-200/50 flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:w-1/2">
                <span class="absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search modules..."
                    class="w-full bg-white/80 border border-slate-200 rounded-2xl py-3.5 pl-12 pr-6 focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-800 font-medium placeholder-slate-400 shadow-inner">
            </div>

            <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
                <button wire:click="setFilter('all')"
                    class="px-6 py-3 rounded-2xl font-bold shadow-sm transition-all whitespace-nowrap {{ $filter === 'all' ? 'bg-brand-600 text-white shadow-brand-500/30' : 'bg-white/80 hover:bg-white text-slate-700 border border-slate-200' }}">All
                    Modules</button>
                <button wire:click="setFilter('reading')"
                    class="px-6 py-3 rounded-2xl font-bold shadow-sm transition-all whitespace-nowrap {{ $filter === 'reading' ? 'bg-brand-600 text-white shadow-brand-500/30' : 'bg-white/80 hover:bg-white text-slate-700 border border-slate-200' }}">Reading
                    Focus</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($modules as $index => $module)
                <div x-show="shown" x-transition:enter="transition ease-out duration-700"
                    style="transition-delay: {{ $index * 100 }}ms"
                    class="group bg-white/80 backdrop-blur-xl rounded-[32px] overflow-hidden border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-brand-500/20 transition-all duration-500 hover:-translate-y-2 flex flex-col relative">

                    <div
                        class="absolute top-4 left-4 z-20 w-10 h-10 bg-white/90 backdrop-blur text-brand-600 font-black rounded-xl flex items-center justify-center shadow-lg border border-white/50">
                        {{ $module->order }}
                    </div>

                    <div class="relative h-56 overflow-hidden bg-slate-100">
                        <img src="{{ $module->cover_image ?? 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?q=80&w=2070&auto=format&fit=crop' }}"
                            alt="{{ $module->title }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent">
                        </div>

                        <span
                            class="absolute bottom-4 left-4 px-3 py-1.5 bg-white/20 backdrop-blur-md text-white border border-white/30 text-xs font-bold rounded-xl shadow-sm flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                            {{ $module->pages_count }} Sessions
                        </span>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <h3
                            class="text-2xl font-extrabold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors leading-tight">
                            {{ $module->title }}</h3>
                        <p class="text-slate-500 text-sm mb-8 line-clamp-3 leading-relaxed font-medium">
                            {{ $module->description }}</p>

                        <div class="flex items-center justify-between mt-auto pt-5 border-t border-slate-100">
                            <div class="flex -space-x-3 hover:space-x-1 transition-all duration-300 cursor-default"
                                title="Students currently learning this module">
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center text-xs font-bold text-indigo-600 shadow-sm z-30">
                                    MS</div>
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white bg-gradient-to-br from-rose-100 to-rose-200 flex items-center justify-center text-xs font-bold text-rose-600 shadow-sm z-20">
                                    PA</div>
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500 shadow-sm z-10">
                                    +24</div>
                            </div>

                            @auth
                                <a href="{{ route('dashboard') }}"
                                    class="px-5 py-2.5 bg-brand-50 text-brand-600 font-bold rounded-xl group-hover:bg-brand-600 group-hover:text-white transition-all duration-300 shadow-sm flex items-center gap-2">
                                    Start <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-brand-600 transition-all duration-300 shadow-lg flex items-center gap-2">
                                    Sign In <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full text-center py-24 bg-white/50 backdrop-blur-md rounded-[40px] border border-white shadow-xl">
                    <div
                        class="w-20 h-20 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-900 mb-2">No Modules Found</h3>
                    <p class="text-lg text-slate-500 font-medium">Try adjusting your search or filter.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-14">
            {{ $modules->links() }}
        </div>
    </div>
</div>
