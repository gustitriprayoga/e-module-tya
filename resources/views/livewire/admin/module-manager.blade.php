<div class="relative z-10" x-data="{ modalOpen: @entangle('isModalOpen') }">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                        </path>
                    </svg>
                </div>
                Module Builder
            </h1>
            <p class="text-slate-500 mt-2">Design your ADDIE learning syllabus and manage sessions.</p>
        </div>
        <button wire:click="create"
            class="flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Module
        </button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-center">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Modules</span>
            <span class="text-2xl font-black text-slate-800">{{ count($modules) }}</span>
        </div>
        <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-100 shadow-sm flex flex-col justify-center">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest mb-1">Published</span>
            <span
                class="text-2xl font-black text-emerald-700">{{ $modules->where('is_published', true)->count() }}</span>
        </div>
        <div class="bg-amber-50 p-5 rounded-2xl border border-amber-100 shadow-sm flex flex-col justify-center">
            <span class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">Drafts</span>
            <span
                class="text-2xl font-black text-amber-700">{{ $modules->where('is_published', false)->count() }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @forelse($modules as $index => $module)
            <div
                class="group bg-white border border-slate-200 rounded-[32px] p-6 shadow-sm hover:shadow-xl hover:border-brand-300 transition-all duration-300 flex flex-col sm:flex-row gap-6 relative overflow-hidden">

                <div class="absolute top-6 right-6 z-10 flex gap-2">
                    <div class="flex flex-col gap-1 mr-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @if ($index > 0)
                            <button wire:click="moveUp({{ $module->id }})"
                                class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors"
                                title="Move Up"><svg class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7"></path>
                                </svg></button>
                        @endif
                        @if ($index < count($modules) - 1)
                            <button wire:click="moveDown({{ $module->id }})"
                                class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg transition-colors"
                                title="Move Down"><svg class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg></button>
                        @endif
                    </div>

                    @if ($module->is_published)
                        <span
                            class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[10px] uppercase tracking-widest font-black rounded-lg border border-emerald-200 h-fit">Published</span>
                    @else
                        <span
                            class="px-3 py-1 bg-slate-100 text-slate-500 text-[10px] uppercase tracking-widest font-black rounded-lg border border-slate-200 h-fit">Draft</span>
                    @endif
                </div>

                <div class="w-full sm:w-48 h-48 rounded-2xl overflow-hidden bg-slate-100 shrink-0 relative">
                    @if ($module->cover_image)
                        <img src="{{ $module->cover_image }}" alt="{{ $module->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-50">
                            <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-widest">No Cover</span>
                        </div>
                    @endif
                    <div
                        class="absolute bottom-2 left-2 w-8 h-8 bg-white/90 backdrop-blur text-slate-800 font-black rounded-xl flex items-center justify-center shadow-sm">
                        {{ $module->order }}
                    </div>
                </div>

                <div class="flex flex-col flex-grow pt-2">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2 pr-20">{{ $module->title }}</h3>
                    <p class="text-slate-500 text-sm mb-6 line-clamp-2">{{ $module->description }}</p>

                    <div
                        class="mt-auto flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-t border-slate-100 pt-5">

                        <div
                            class="flex items-center gap-2 text-xs font-bold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-200">
                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            {{ $module->pages_count }} Pages
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <a href="{{ route('admin.sessions', $module->id) }}"
                                class="flex-1 sm:flex-none px-4 py-2 bg-brand-50 hover:bg-brand-600 text-brand-600 hover:text-white rounded-xl font-bold text-sm transition-colors text-center">
                                Build
                            </a>
                            <button wire:click="edit({{ $module->id }})"
                                class="p-2 bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 rounded-xl transition-colors shadow-sm"
                                title="Edit Metadata">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <button wire:click="delete({{ $module->id }})"
                                wire:confirm="WARNING: Deleting this module will destroy all its pages, text blocks, and quizzes. Proceed?"
                                class="p-2 bg-white border border-slate-200 hover:border-red-300 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors shadow-sm"
                                title="Delete Module">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-24 text-center border-2 border-slate-200 border-dashed rounded-[32px] bg-slate-50">
                <div
                    class="w-20 h-20 bg-white text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Syllabus is Empty</h3>
                <p class="text-slate-500 mb-6 max-w-md mx-auto">Start building your curriculum by creating the first
                    learning module. You can add pages and quizzes later.</p>
                <button wire:click="create"
                    class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg transition-all active:scale-95">
                    Create First Module
                </button>
            </div>
        @endforelse
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-cloak>
        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="modalOpen = false"></div>

        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100">

            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">
                    {{ $module_id ? 'Edit Module' : 'Create New Module' }}</h2>
                <button wire:click="closeModal"
                    class="text-slate-400 hover:text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 p-2 rounded-full transition-colors shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="p-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Module Title</label>
                        <input wire:model="title" type="text"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-bold"
                            placeholder="e.g. Reading II: Speed Reading">
                        @error('title')
                            <span class="text-red-500 text-xs mt-1 font-semibold ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Cover Image URL
                            (Optional)</label>
                        <div class="flex gap-3">
                            <input wire:model="cover_image" type="url"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-medium"
                                placeholder="https://images.unsplash.com/photo-...">
                        </div>
                        <p class="text-xs text-slate-400 mt-2 ml-1 font-medium">Use a direct image link. Leave blank to
                            use default placeholder.</p>
                        @error('cover_image')
                            <span class="text-red-500 text-xs mt-1 font-semibold ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Short Description</label>
                        <textarea wire:model="description" rows="3"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-medium resize-none"
                            placeholder="What will students learn in this module?"></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs mt-1 font-semibold ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 ml-1 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <div
                            class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                            <input wire:model="is_published" type="checkbox" name="toggle" id="toggle"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 ease-in-out z-10 checked:translate-x-6 checked:border-emerald-500" />
                            <label for="toggle"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer transition-colors duration-200 ease-in-out peer-checked:bg-emerald-500"></label>
                        </div>
                        <div>
                            <label for="toggle"
                                class="text-sm font-bold text-slate-900 cursor-pointer block">Publish to
                                Students</label>
                            <p class="text-xs text-slate-500 mt-0.5">If unchecked, this module will appear as "Coming
                                Soon".</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal"
                        class="px-6 py-3.5 rounded-2xl text-slate-600 font-bold hover:bg-slate-100 transition-colors">Cancel</button>
                    <button type="submit"
                        class="bg-slate-900 hover:bg-slate-800 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg transition-all active:scale-95">
                        {{ $module_id ? 'Save Changes' : 'Create Module' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .toggle-checkbox:checked {
            right: 0;
            border-color: #10b981;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #10b981;
        }

        .toggle-checkbox {
            right: 24px;
            border-color: #cbd5e1;
        }

        .toggle-label {
            background-color: #cbd5e1;
        }
    </style>
</div>
