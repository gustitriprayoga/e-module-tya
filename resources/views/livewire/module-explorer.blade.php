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
                class="px-4 py-1.5 rounded-full bg-brand-100 text-brand-700 border border-brand-200 font-bold text-sm mb-4 inline-block tracking-wide">PahlawanHub
                Courses</span>
            <h1 class="text-5xl font-extrabold text-slate-950 mb-4 tracking-tight">Learning Modules</h1>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg">Explore our interactive curriculum designed to boost
                your English proficiency through digital transformation.</p>
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
                <input wire:model.live="search" type="text" placeholder="Search modules..."
                    class="w-full bg-white/80 border border-slate-200 rounded-2xl py-3.5 pl-12 pr-6 focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-800 font-medium placeholder-slate-400 shadow-inner">
            </div>

            <div class="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 hide-scrollbar">
                <button
                    class="px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold shadow-lg shadow-brand-500/30 transition-all whitespace-nowrap">All
                    Modules</button>
                <button
                    class="px-6 py-3 rounded-2xl bg-white/80 hover:bg-white text-slate-700 font-bold border border-slate-200 shadow-sm transition-all whitespace-nowrap">Reading</button>
                <button
                    class="px-6 py-3 rounded-2xl bg-white/80 hover:bg-white text-slate-700 font-bold border border-slate-200 shadow-sm transition-all whitespace-nowrap">Vocabulary</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($modules as $index => $module)
                <div x-show="shown" x-transition:enter="transition ease-out duration-700"
                    style="transition-delay: {{ $index * 150 }}ms"
                    class="group bg-white/80 backdrop-blur-xl rounded-[32px] overflow-hidden border border-white shadow-xl shadow-slate-200/50 hover:shadow-2xl hover:shadow-brand-500/20 transition-all duration-500 hover:-translate-y-2 flex flex-col">

                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $module->cover_image ?? 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?q=80&w=2070&auto=format&fit=crop' }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent">
                        </div>
                        <span
                            class="absolute top-4 right-4 px-3 py-1.5 bg-white/20 backdrop-blur-md text-white border border-white/30 text-xs font-bold rounded-xl shadow-sm">
                            {{ $module->pages_count }} Sessions
                        </span>
                    </div>

                    <div class="p-8 flex flex-col flex-grow">
                        <h3
                            class="text-2xl font-extrabold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                            {{ $module->title }}</h3>
                        <p class="text-slate-600 text-sm mb-8 line-clamp-3 leading-relaxed">{{ $module->description }}
                        </p>

                        <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                            <div class="flex -space-x-3">
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                                    MS</div>
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white bg-brand-100 flex items-center justify-center text-xs font-bold text-brand-600">
                                    PA</div>
                                <div
                                    class="w-10 h-10 rounded-full border-2 border-white bg-accent-100 flex items-center justify-center text-xs font-bold text-accent-600">
                                    +21</div>
                            </div>
                            <a href="#"
                                class="p-3.5 bg-brand-50 text-brand-600 rounded-2xl group-hover:bg-brand-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-full text-center py-20 bg-white/50 backdrop-blur-md rounded-[32px] border border-white">
                    <p class="text-xl text-slate-500 font-bold">No modules found matching your search.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $modules->links() }}
        </div>
    </div>
</div>
