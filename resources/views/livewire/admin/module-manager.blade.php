<div class="relative z-10" x-data="{ modalOpen: @entangle('isModalOpen') }">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Course Modules</h1>
            <p class="text-slate-500 mt-1">Manage your Reading II course and its learning sessions.</p>
        </div>
        <button wire:click="create"
            class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Module
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($modules as $module)
            <div
                class="group bg-white/70 backdrop-blur-xl border border-white rounded-[32px] overflow-hidden shadow-xl shadow-slate-200/50 hover:-translate-y-2 transition-all duration-300 flex flex-col">
                <div class="relative h-48 overflow-hidden bg-slate-100">
                    @if ($module->cover_image)
                        <img src="{{ $module->cover_image }}" alt="{{ $module->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-400">No Image</div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>

                    <div class="absolute top-4 right-4">
                        @if ($module->is_active)
                            <span
                                class="px-3 py-1 bg-emerald-500/90 backdrop-blur-md text-white text-xs font-bold rounded-xl shadow-sm border border-emerald-400">Published</span>
                        @else
                            <span
                                class="px-3 py-1 bg-slate-500/90 backdrop-blur-md text-white text-xs font-bold rounded-xl shadow-sm border border-slate-400">Draft</span>
                        @endif
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-2">{{ $module->title }}</h3>
                    <p class="text-slate-500 text-sm mb-6 line-clamp-2">{{ $module->description }}</p>

                    <div class="mt-auto">
                        <div
                            class="flex items-center gap-2 text-sm font-bold text-slate-600 mb-4 bg-slate-50 px-4 py-2 rounded-xl border border-slate-100">
                            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                            {{ $module->pages_count }} Learning Sessions
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.sessions', $module->id) }}"
                                class="flex-1 bg-slate-900 hover:bg-slate-800 text-white text-center py-2.5 rounded-xl font-bold text-sm transition-colors">
                                Manage Sessions
                            </a>
                            <button wire:click="edit({{ $module->id }})"
                                class="p-2.5 bg-brand-50 hover:bg-brand-100 text-brand-600 rounded-xl transition-colors"
                                title="Edit Module">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <button wire:click="delete({{ $module->id }})"
                                wire:confirm="Are you sure you want to delete this module? All sessions inside will be lost."
                                class="p-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-colors"
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
                class="col-span-full bg-white/50 backdrop-blur-xl border border-white rounded-[32px] p-12 text-center shadow-xl">
                <div
                    class="w-20 h-20 bg-brand-100 text-brand-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-extrabold text-slate-900 mb-2">No Modules Found</h3>
                <p class="text-slate-500 mb-6">Start your R&D process by creating the first learning module.</p>
                <button wire:click="create"
                    class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all">Create
                    First Module</button>
            </div>
        @endforelse
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-cloak>
        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="modalOpen = false"></div>

        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-8 scale-95"
            class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100">

            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">
                    {{ $module_id ? 'Edit Module' : 'Create New Module' }}</h2>
                <button wire:click="closeModal"
                    class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="p-8">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Module Title</label>
                        <input wire:model="title" type="text"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-medium"
                            placeholder="e.g. Reading II: Speed Reading">
                        @error('title')
                            <span class="text-red-500 text-xs mt-1 font-semibold ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Cover Image URL</label>
                        <input wire:model="cover_image" type="url"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-medium"
                            placeholder="https://images.unsplash.com/photo-...">
                        @error('cover_image')
                            <span class="text-red-500 text-xs mt-1 font-semibold ml-1">{{ $message }}</span>
                        @enderror
                        <p class="text-xs text-slate-500 mt-2 ml-1">Paste an image URL for the course cover (e.g., from
                            Unsplash).</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Module Description</label>
                        <textarea wire:model="description" rows="4"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-medium resize-none"
                            placeholder="Master skimming, scanning, and identifying main ideas..."></textarea>
                        @error('description')
                            <span class="text-red-500 text-xs mt-1 font-semibold ml-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 ml-1">
                        <div
                            class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input wire:model="is_active" type="checkbox" name="toggle" id="toggle"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 ease-in-out z-10 checked:translate-x-6 checked:border-brand-500" />
                            <label for="toggle"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer transition-colors duration-200 ease-in-out peer-checked:bg-brand-500"></label>
                        </div>
                        <label for="toggle" class="text-sm font-bold text-slate-700">Publish to Students</label>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="closeModal"
                        class="px-6 py-3 rounded-2xl text-slate-600 font-bold hover:bg-slate-100 transition-colors">Cancel</button>
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
                        Save Module
                    </button>
                </div>
            </form>
        </div>
    </div>
    <style>
        /* Custom Toggle Switch CSS */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #3b82f6;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #3b82f6;
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
