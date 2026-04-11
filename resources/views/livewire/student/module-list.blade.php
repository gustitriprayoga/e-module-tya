<div class="relative z-10 max-w-7xl mx-auto">
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                Course Modules
            </h1>
            <p class="text-lg text-slate-500">Explore your curriculum and track your learning progress.</p>
        </div>

        <div
            class="flex items-center gap-2 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100 overflow-x-auto">
            <button wire:click="setFilter('all')"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap {{ $filter === 'all' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">All</button>
            <button wire:click="setFilter('unlocked')"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap {{ $filter === 'unlocked' ? 'bg-brand-600 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">On
                Going</button>
            <button wire:click="setFilter('completed')"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap {{ $filter === 'completed' ? 'bg-emerald-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Completed</button>
            <button wire:click="setFilter('locked')"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap {{ $filter === 'locked' ? 'bg-amber-500 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Locked</button>
            <button wire:click="setFilter('upcoming')"
                class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all whitespace-nowrap {{ $filter === 'upcoming' ? 'bg-slate-200 text-slate-700 shadow-md' : 'text-slate-500 hover:bg-slate-50' }}">Upcoming</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($modules as $index => $module)
            <div class="relative group h-full flex flex-col" wire:key="module-{{ $module->id }}">

                @if (!$module->is_published)
                    <div
                        class="bg-slate-50/50 border-2 border-slate-200 border-dashed rounded-[32px] p-8 opacity-75 flex flex-col h-full transition-opacity hover:opacity-100">
                        <div class="absolute top-8 right-8 text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div
                            class="w-14 h-14 bg-slate-200 text-slate-400 rounded-2xl flex items-center justify-center font-black text-2xl mb-6">
                            {{ $index + 1 }}</div>
                        <h4 class="text-xl font-extrabold text-slate-500 mb-3">{{ $module->title }}</h4>
                        <p class="text-slate-400 text-sm line-clamp-3 mb-8 flex-grow">{{ $module->description }}</p>

                        <div class="mt-auto">
                            <button
                                onclick="Swal.fire({icon: 'info', title: 'Coming Soon', text: 'This module has not been released yet. Stay tuned!', confirmButtonColor: '#2563eb'})"
                                class="block w-full text-center py-3 bg-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-300 transition-colors">
                                Coming Soon
                            </button>
                        </div>
                    </div>
                @elseif ($module->is_locked)
                    <div
                        class="bg-amber-50/50 border-2 border-amber-200 border-dashed rounded-[32px] p-8 flex flex-col h-full transition-opacity">
                        <div class="absolute top-8 right-8 text-amber-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <div
                            class="w-14 h-14 bg-amber-100 text-amber-500 rounded-2xl flex items-center justify-center font-black text-2xl mb-6">
                            {{ $index + 1 }}</div>
                        <h4 class="text-xl font-extrabold text-amber-700 mb-3">{{ $module->title }}</h4>
                        <p class="text-amber-600/70 text-sm line-clamp-3 mb-8 flex-grow">{{ $module->description }}</p>

                        <div class="mt-auto">
                            @if ($module->pre_test_id)
                                <a href="{{ route('student.test', $module->pre_test_id) }}"
                                    class="block w-full text-center py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition-colors shadow-md shadow-amber-500/20">
                                    Take Pre-Test to Unlock
                                </a>
                            @else
                                <span
                                    class="text-amber-500 font-bold text-xs uppercase tracking-widest flex items-center gap-2">Locked
                                    Content</span>
                            @endif
                        </div>
                    </div>
                @else
                    <div
                        class="bg-white border border-slate-200 hover:border-brand-400 rounded-[32px] p-8 shadow-lg shadow-slate-200/40 transition-all duration-300 hover:-translate-y-1.5 flex flex-col h-full relative overflow-hidden">
                        <div
                            class="absolute -right-10 -top-10 w-32 h-32 {{ $module->is_completed ? 'bg-emerald-50' : 'bg-brand-50' }} rounded-full blur-2xl opacity-50 group-hover:opacity-100 transition-opacity duration-500">
                        </div>

                        <div class="relative z-10 flex flex-col h-full">
                            <div class="flex justify-between items-start mb-6">
                                <div
                                    class="w-14 h-14 {{ $module->is_completed ? 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600' : 'bg-brand-50 text-brand-600 group-hover:bg-brand-600' }} rounded-2xl flex items-center justify-center font-black text-2xl group-hover:text-white transition-colors duration-300">
                                    {{ $index + 1 }}
                                </div>
                                <span
                                    class="bg-slate-50 text-slate-500 font-bold text-[10px] uppercase tracking-widest px-3 py-1 rounded-lg border border-slate-100 flex items-center gap-1">
                                    {{ $module->pages_count }} Pages
                                </span>
                            </div>

                            <h4
                                class="text-xl font-extrabold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                                {{ $module->title }}</h4>
                            <p class="text-slate-500 text-sm line-clamp-3 mb-8 flex-grow">{{ $module->description }}
                            </p>

                            <div class="pt-6 border-t border-slate-100 mt-auto flex items-center justify-between">
                                @if ($module->is_completed)
                                    <span
                                        class="text-xs font-bold text-emerald-500 uppercase tracking-widest flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Completed
                                    </span>
                                    <a href="{{ route('student.test.result', $module->post_test_id) }}"
                                        class="inline-flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-600 text-emerald-600 hover:text-white px-5 py-2.5 rounded-xl font-bold transition-all duration-300 active:scale-95 group-hover:bg-emerald-600 group-hover:text-white">
                                        View Result
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Status:
                                        Unlocked</span>
                                    <a href="{{ route('student.reader', $module->slug) }}"
                                        class="inline-flex items-center justify-center gap-2 bg-brand-50 hover:bg-brand-600 text-brand-600 hover:text-white px-5 py-2.5 rounded-xl font-bold transition-all duration-300 active:scale-95 group-hover:bg-brand-600 group-hover:text-white">
                                        Start
                                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </a>
                                @endif
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
                <h3 class="text-lg font-bold text-slate-900">No Modules Found</h3>
            </div>
        @endforelse
    </div>
</div>
