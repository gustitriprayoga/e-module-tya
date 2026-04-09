<div class="relative z-10" x-data="{ modalOpen: @entangle('isModalOpen'), importOpen: @entangle('isImportModalOpen') }">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="w-full md:w-1/2">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                Vocabulary Vault
            </h1>
            <p class="text-slate-500 mt-2">Manage the target dictionary for your Speed Reading R&D.</p>

            <div class="mt-5 bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex justify-between text-xs font-bold uppercase tracking-widest mb-2">
                    <span class="text-brand-600">Vault Progress</span>
                    <span class="text-slate-400">{{ number_format($total_words) }} / 3,500 Words</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-brand-500 to-accent-500 transition-all duration-1000"
                        style="width: {{ min(($total_words / 3500) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <button wire:click="openImportModal"
                class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Import Excel
            </button>
            <button wire:click="create"
                class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Single Word
            </button>
        </div>
    </div>

    <div
        class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] p-6 shadow-xl shadow-slate-200/50 mb-6 flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search words or definitions..."
                class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 pl-12 pr-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 outline-none font-medium text-slate-800 transition-all">
        </div>
        <div class="w-full md:w-64">
            <select wire:model.live="category_filter"
                class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 outline-none font-bold text-slate-600 appearance-none">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    @if ($cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div
        class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50/80 border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400 font-black">
                        <th class="p-6">Word</th>
                        <th class="p-6">Definition</th>
                        <th class="p-6 hidden lg:table-cell">Context Sentence</th>
                        <th class="p-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($vocabularies as $vocab)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-6 font-bold text-lg text-slate-900">
                                {{ ucfirst($vocab->word) }}
                                @if ($vocab->category)
                                    <span
                                        class="block mt-1 text-[10px] uppercase tracking-widest text-brand-500">{{ $vocab->category }}</span>
                                @endif
                            </td>
                            <td class="p-6 text-slate-600 max-w-xs truncate" title="{{ $vocab->definition }}">
                                {{ $vocab->definition }}
                            </td>
                            <td class="p-6 text-slate-500 text-sm hidden lg:table-cell max-w-sm italic truncate"
                                title="{{ $vocab->context_sentence }}">
                                "{{ $vocab->context_sentence }}"
                            </td>
                            <td class="p-6 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click="edit({{ $vocab->id }})"
                                        class="p-2 bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 rounded-xl shadow-sm transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button
                                        onclick="confirmDeleteWord({{ $vocab->id }}, '{{ addslashes($vocab->word) }}')"
                                        class="p-2 bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 rounded-xl shadow-sm transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center">
                                <div
                                    class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-xl font-bold text-slate-900 mb-1">Vault is Empty</h4>
                                <p class="text-slate-500 mb-4">Start adding words manually or import an Excel dataset.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($vocabularies->hasPages())
            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                {{ $vocabularies->links() }}
            </div>
        @endif
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-cloak>
        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="modalOpen = false"></div>
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-xl overflow-hidden border border-slate-100">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $vocab_id ? 'Edit Word' : 'Add New Word' }}</h2>
                <button wire:click="$set('isModalOpen', false)"
                    class="text-slate-400 hover:text-slate-600 bg-slate-100 p-2 rounded-full"><svg class="w-5 h-5"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" />
                    </svg></button>
            </div>
            <form wire:submit.prevent="save" class="p-8 space-y-5">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Word</label>
                        <input wire:model="word" type="text"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none font-bold text-slate-900 lowercase"
                            placeholder="e.g. accelerating">
                        @error('word')
                            <span class="text-red-500 text-xs font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-1/3">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Category (Opt)</label>
                        <input wire:model="category" type="text"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none font-bold text-slate-900"
                            placeholder="e.g. AWL">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Definition</label>
                    <textarea wire:model="definition" rows="2"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none text-slate-800 resize-none"
                        placeholder="Make it happen faster..."></textarea>
                    @error('definition')
                        <span class="text-red-500 text-xs font-semibold">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Context Sentence (Opt)</label>
                    <textarea wire:model="context_sentence" rows="2"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none text-slate-800 italic resize-none"
                        placeholder="The melting of ice is accelerating due to..."></textarea>
                </div>
                <div class="pt-6">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg w-full transition-all active:scale-95">Save
                        to Vault</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="importOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-cloak>
        <div x-show="importOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="importOpen = false"></div>
        <div x-show="importOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100 p-8 text-center">
            <div
                class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 mb-2">Bulk Import Dataset</h2>
            <p class="text-slate-500 mb-8">Upload a CSV/Excel file containing your 3,500 target words. <br> Required
                columns: <code class="bg-slate-100 text-slate-700 px-2 py-1 rounded">word</code>, <code
                    class="bg-slate-100 text-slate-700 px-2 py-1 rounded">definition</code></p>

            <div
                class="border-2 border-dashed border-slate-200 rounded-2xl p-8 mb-8 bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer">
                <span class="font-bold text-brand-600">Click to browse</span> or drag file here
            </div>

            <div class="flex gap-3">
                <button wire:click="$set('isImportModalOpen', false)"
                    class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-3.5 rounded-2xl font-bold transition-all">Cancel</button>
                <button
                    class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-2xl font-bold shadow-lg shadow-emerald-500/30 transition-all opacity-50 cursor-not-allowed">Upload
                    Data</button>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        window.confirmDeleteWord = function(id, word) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                title: 'Remove this word?',
                html: `You are about to delete <b>"${word}"</b> from the vault.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'Yes, remove it',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[32px] shadow-2xl border border-slate-100',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteWord(id);
                }
            });
        }
    </script>
@endscript
