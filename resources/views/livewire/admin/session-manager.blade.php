<div class="relative z-10" x-data="{ modalOpen: @entangle('isModalOpen') }">
    <div class="mb-8">
        <a href="{{ route('admin.modules') }}"
            class="inline-flex items-center gap-2 text-brand-600 font-bold text-sm mb-4 hover:underline transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to Modules
        </a>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $module->title }}</h1>
                <p class="text-slate-500 mt-1">Manage 14 Learning Sessions (Pages) for this course.</p>
            </div>
            <button wire:click="create"
                class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Session
            </button>
        </div>
    </div>

    <div
        class="bg-white/70 backdrop-blur-xl border border-white rounded-[32px] shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="p-6 md:p-8">
            <div class="space-y-4">
                @forelse($sessions as $session)
                    <div
                        class="group flex flex-col md:flex-row items-center justify-between p-4 md:p-5 bg-white border border-slate-100 rounded-2xl hover:border-brand-300 hover:shadow-md transition-all duration-300 gap-4">

                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <div
                                class="w-12 h-12 bg-brand-50 text-brand-600 font-black text-xl rounded-xl flex items-center justify-center border border-brand-100 flex-shrink-0">
                                {{ $session->order_number }}
                            </div>
                            <div>
                                <h4
                                    class="font-extrabold text-slate-900 text-lg group-hover:text-brand-600 transition-colors">
                                    {{ $session->title }}</h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">0 Blocks
                                        Content</span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                    @if ($session->is_published)
                                        <span class="text-xs font-bold text-emerald-500">Published</span>
                                    @else
                                        <span class="text-xs font-bold text-slate-400">Draft</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                            <a href="{{ route('admin.content-builder', $session->id) }}"
                                class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-sm shadow-sm transition-colors w-full md:w-auto text-center">
                                Design Content
                            </a>
                            <button wire:click="edit({{ $session->id }})"
                                class="p-2 bg-slate-100 hover:bg-brand-50 text-slate-600 hover:text-brand-600 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <button
                                onclick="confirmDeleteSession({{ $session->id }}, '{{ addslashes($session->title) }}')"
                                class="p-2 bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 rounded-xl transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div
                            class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-1">No Sessions Yet</h4>
                        <p class="text-slate-500 mb-4">Create your first meeting session to start building content.</p>
                        <button wire:click="create" class="text-brand-600 font-bold hover:underline">Add Session
                            Now</button>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center px-4" x-cloak>
        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="modalOpen = false"></div>

        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden border border-slate-100">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $session_id ? 'Edit Session' : 'Add Session' }}
                </h2>
                <button wire:click="$set('isModalOpen', false)"
                    class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="p-8 space-y-6">
                <div class="flex gap-4">
                    <div class="w-24">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">No. Ptm</label>
                        <input wire:model="order_number" type="number"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 outline-none font-bold text-center"
                            min="1">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Session Title</label>
                        <input wire:model="title" type="text"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 outline-none font-medium"
                            placeholder="e.g. Intro to Skimming">
                    </div>
                </div>

                @error('order_number')
                    <span class="text-red-500 text-xs font-semibold block">{{ $message }}</span>
                @enderror
                @error('title')
                    <span class="text-red-500 text-xs font-semibold block">{{ $message }}</span>
                @enderror

                <div class="flex items-center gap-3 ml-1 pt-2">
                    <div
                        class="relative inline-block w-12 mr-2 align-middle select-none transition duration-200 ease-in">
                        <input wire:model="is_published" type="checkbox" id="togglePub"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 z-10 checked:translate-x-6 checked:border-emerald-500" />
                        <label for="togglePub"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer transition-colors duration-200 peer-checked:bg-emerald-500"></label>
                    </div>
                    <label for="togglePub" class="text-sm font-bold text-slate-700">Publish Session</label>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95 w-full">
                        Save Session
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

@script
    <script>
        // Fungsi ini dipanggil dari onClick HTML dan memicu method Livewire
        window.confirmDeleteSession = function(sessionId, sessionTitle) {
            Swal.fire({
                title: 'Delete this session?',
                html: `Are you sure you want to delete <b>"${sessionTitle}"</b>?<br>All blocks and quiz data inside will be lost.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48', // Tailwind red-600
                cancelButtonColor: '#94a3b8', // Tailwind slate-400
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[32px] shadow-2xl border border-slate-100',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Memanggil function deleteSession di Livewire Backend
                    $wire.deleteSession(sessionId);
                }
            })
        }
    </script>
@endscript
