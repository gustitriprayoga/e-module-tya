<div class="relative z-10" x-data="{ modalOpen: @entangle('isModalOpen'), questionModalOpen: @entangle('isQuestionModalOpen') }">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                Test Manager
            </h1>
            <p class="text-slate-500 mt-2">Configure Pre-test and Post-test parameters and assign questions.</p>
        </div>
        <button wire:click="create"
            class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Test
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tests as $test)
            <div
                class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] p-6 md:p-8 shadow-xl shadow-slate-200/50 flex flex-col relative group hover:border-brand-300 transition-all duration-300">

                <div class="absolute top-6 right-6">
                    @if ($test->is_active)
                        <span class="flex h-3 w-3 relative" title="Test is Live">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    @else
                        <span class="flex h-3 w-3 relative bg-slate-300 rounded-full" title="Draft / Hidden"></span>
                    @endif
                </div>

                <div class="mb-4">
                    <span
                        class="px-3 py-1 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-lg">
                        {{ str_replace('-', ' ', $test->type) }}
                    </span>
                </div>

                <h3 class="text-xl font-extrabold text-slate-900 mb-4">{{ $test->title }}</h3>

                <div class="space-y-3 mb-8">
                    <div class="flex justify-between items-center text-sm font-bold border-b border-slate-100 pb-2">
                        <span class="text-slate-500">Duration</span>
                        <span class="text-slate-900">{{ $test->duration }} Mins</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold border-b border-slate-100 pb-2">
                        <span class="text-slate-500">Passing Score</span>
                        <span class="text-emerald-600">{{ $test->passing_score }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold pb-2">
                        <span class="text-slate-500">Total Questions</span>
                        <span class="text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md">{{ $test->questions_count }}
                            Items</span>
                    </div>
                </div>

                <div class="mt-auto flex gap-2">
                    <button wire:click="manageQuestions({{ $test->id }})"
                        class="flex-1 bg-brand-50 hover:bg-brand-100 text-brand-700 py-2.5 rounded-xl font-bold text-sm transition-colors border border-brand-100">
                        Assign Questions
                    </button>
                    <button wire:click="edit({{ $test->id }})"
                        class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </button>
                    <button onclick="confirmDeleteTest({{ $test->id }})"
                        class="p-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        @empty
            <div
                class="col-span-full p-16 text-center bg-white/50 backdrop-blur-xl border border-white rounded-[32px] shadow-xl">
                <p class="text-slate-500 font-bold mb-4">No tests configured yet.</p>
                <button wire:click="create" class="text-brand-600 font-bold hover:underline">Create Pre-test
                    now</button>
            </div>
        @endforelse
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-cloak>
        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="modalOpen = false"></div>
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            class="relative bg-white rounded-[40px] shadow-2xl w-full max-w-xl overflow-hidden border border-slate-100">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $test_id ? 'Edit Test' : 'Configure Test' }}</h2>
                <button wire:click="$set('isModalOpen', false)" class="text-slate-400 p-2"><svg class="w-6 h-6"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" />
                    </svg></button>
            </div>
            <form wire:submit.prevent="save" class="p-8 space-y-6">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Test Title</label>
                        <input wire:model="title" type="text"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none focus:ring-4 focus:ring-brand-500/20"
                            placeholder="e.g. Pre-test Speed Reading">
                        @error('title')
                            <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-1/3">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Type</label>
                        <select wire:model="type"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none focus:ring-4 focus:ring-brand-500/20">
                            <option value="pre-test">Pre-Test</option>
                            <option value="post-test">Post-Test</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Duration (Minutes)</label>
                        <input wire:model="duration" type="number"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none text-center">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Passing Score (KKM)</label>
                        <input wire:model="passing_score" type="number"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none text-center text-emerald-600">
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <div class="relative inline-block w-12 align-middle select-none">
                        <input wire:model="is_active" type="checkbox" id="toggleActive"
                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 z-10 checked:translate-x-6 checked:border-emerald-500" />
                        <label for="toggleActive"
                            class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-200 cursor-pointer transition-colors duration-200 peer-checked:bg-emerald-500"></label>
                    </div>
                    <label for="toggleActive" class="text-sm font-bold text-slate-700">Activate / Publish to
                        Students</label>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-brand-500/30 w-full transition-all active:scale-95">Save
                        Settings</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="questionModalOpen" class="fixed inset-0 z-[110] flex flex-col bg-slate-50" x-cloak>
        <div class="bg-white border-b border-slate-200 px-8 py-4 flex justify-between items-center shadow-sm shrink-0">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-brand-500 block">Assign Questions to
                    Test</span>
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $selectedTestTitle }}</h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-slate-100 px-4 py-2 rounded-xl text-sm font-bold text-slate-600">
                    <span class="text-brand-600">{{ count($selectedQuestions) }}</span> Selected
                </div>
                <button wire:click="saveQuestions"
                    class="bg-brand-600 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg hover:bg-brand-700 transition-all">Save
                    & Close</button>
                <button wire:click="$set('isQuestionModalOpen', false)"
                    class="p-2 text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" />
                    </svg></button>
            </div>
        </div>

        <div class="bg-white border-b border-slate-200 p-4 px-8 flex gap-4 shrink-0">
            <input wire:model.live.debounce.300ms="questionSearch" type="text"
                placeholder="Search specific questions..."
                class="flex-1 bg-slate-50 border border-slate-200 rounded-xl py-2 px-4 outline-none">
            <select wire:model.live="indicatorFilter"
                class="bg-slate-50 border border-slate-200 rounded-xl px-4 outline-none font-bold">
                <option value="">All Indicators</option>
                @foreach ($indicators as $ind)
                    <option value="{{ $ind }}">{{ $ind }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1 overflow-y-auto p-8 max-w-5xl mx-auto w-full">
            <div class="space-y-3">
                @forelse($availableQuestions as $q)
                    <label
                        class="flex items-start gap-4 p-5 bg-white border border-slate-200 rounded-2xl cursor-pointer hover:border-brand-300 transition-colors {{ in_array($q->id, $selectedQuestions) ? 'ring-2 ring-brand-500/20 border-brand-500 bg-brand-50/10' : '' }}">
                        <div class="mt-1">
                            <input type="checkbox" wire:model.live="selectedQuestions" value="{{ $q->id }}"
                                class="w-5 h-5 text-brand-600 rounded border-slate-300 focus:ring-brand-500">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-black uppercase rounded">{{ $q->indicator }}</span>
                                @if ($q->passage)
                                    <span
                                        class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[10px] font-black uppercase rounded">Passage
                                        Included</span>
                                @endif
                            </div>
                            <p class="font-bold text-slate-800 text-lg leading-snug">{{ $q->question_text }}</p>
                        </div>
                    </label>
                @empty
                    <div class="text-center py-10 text-slate-500 font-bold">No questions match your filter.</div>
                @endforelse
            </div>
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
            border-color: #e2e8f0;
        }
    </style>
</div>


@script
    <script>
        window.confirmDeleteTest = function(id) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                title: 'Delete Test?',
                text: "This will remove the test and all its settings. Question bank will NOT be deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'Yes, Delete'
            }).then((result) => {
                if (result.isConfirmed) $wire.deleteTest(id);
            });
        }
    </script>
@endscript
