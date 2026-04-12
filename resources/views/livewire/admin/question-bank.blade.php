<div class="relative z-10" x-data="{ modalOpen: @entangle('isModalOpen') }">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                Question Bank
            </h1>
            <p class="text-slate-500 mt-2">Manage items for Pre-test, Post-test, and In-module Quizzes.</p>
        </div>
        <button wire:click="create"
            class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            New Question
        </button>
    </div>

    <div
        class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] p-6 shadow-xl shadow-slate-200/50 mb-6 flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Search questions or passage text..."
                class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 pl-12 pr-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none font-medium text-slate-800 transition-all">
        </div>
        <div class="w-full md:w-64">
            <select wire:model.live="indicator_filter"
                class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none font-bold text-slate-600 appearance-none">
                <option value="">All Indicators</option>
                @foreach ($indicators as $ind)
                    <option value="{{ $ind }}">{{ $ind }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div
        class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] shadow-xl shadow-slate-200/50 overflow-hidden">
        <div class="divide-y divide-slate-100">
            @forelse($questions as $question)
                <div class="p-6 md:p-8 hover:bg-slate-50/50 transition-colors group">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6">

                        <div class="flex-1 w-full">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span
                                    class="px-3 py-1 bg-brand-50 text-brand-700 text-[10px] font-black uppercase tracking-widest rounded-lg border border-brand-100">
                                    {{ $question->indicator }}
                                </span>
                                @if ($question->passage)
                                    <span
                                        class="px-3 py-1 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-lg flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        Passage Attached
                                    </span>
                                @endif
                            </div>

                            @if ($question->passage)
                                <p
                                    class="text-slate-400 text-sm italic mb-3 line-clamp-2 border-l-2 border-slate-200 pl-3">
                                    "{{ $question->passage }}"</p>
                            @endif

                            <h4 class="text-lg font-bold text-slate-900 leading-snug">{{ $question->question_text }}
                            </h4>
                        </div>

                        <div
                            class="flex items-center gap-2 shrink-0 md:opacity-0 group-hover:opacity-100 transition-opacity w-full md:w-auto justify-end">
                            <button wire:click="edit({{ $question->id }})"
                                class="p-3 bg-white border border-slate-200 hover:border-brand-300 hover:text-brand-600 rounded-xl shadow-sm transition-all"
                                title="Edit Question">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </button>
                            <button onclick="confirmDeleteQuestion({{ $question->id }})"
                                class="p-3 bg-white border border-slate-200 hover:border-red-300 hover:text-red-600 rounded-xl shadow-sm transition-all"
                                title="Delete Question">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="p-16 text-center">
                    <div
                        class="w-20 h-20 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-inner">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-extrabold text-slate-900 mb-2">Bank is Empty</h4>
                    <p class="text-slate-500 mb-6">Start building your evaluation instruments for the research.</p>
                </div>
            @endforelse
        </div>

        @if ($questions->hasPages())
            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                {{ $questions->links() }}
            </div>
        @endif
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-cloak>
        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="modalOpen = false"></div>
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            class="relative bg-white rounded-[40px] shadow-2xl w-full max-w-5xl overflow-hidden border border-slate-100">

            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">
                    {{ $question_id ? 'Edit Question' : 'Add New Question' }}</h2>
                <button wire:click="$set('isModalOpen', false)"
                    class="text-slate-400 hover:text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 p-2 rounded-full transition-colors"><svg
                        class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg></button>
            </div>

            <form wire:submit.prevent="save" class="p-8 max-h-[75vh] overflow-y-auto custom-scrollbar">
                <div class="flex flex-col lg:flex-row gap-10">

                    <div class="flex-1 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Reading Indicator
                                Target</label>
                            <select wire:model="indicator"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 outline-none focus:bg-white focus:ring-4 focus:ring-brand-500/20 font-bold text-slate-800 appearance-none">
                                <option value="">-- Select Reading Indicator --</option>
                                @foreach ($indicators as $ind)
                                    <option value="{{ $ind }}">{{ $ind }}</option>
                                @endforeach
                            </select>
                            @error('indicator')
                                <span class="text-red-500 text-xs font-bold ml-1 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <div class="flex justify-between items-end mb-2 ml-1">
                                <label class="block text-sm font-bold text-slate-700">Reading Passage / Story</label>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-1 rounded-md">Optional</span>
                            </div>
                            <textarea wire:model="passage" rows="5"
                                class="w-full bg-amber-50/30 border border-amber-200/50 rounded-2xl py-4 px-5 outline-none focus:bg-white focus:ring-4 focus:ring-amber-500/20 font-serif text-slate-800 leading-relaxed resize-y"
                                placeholder="Paste the long text or story here. Leave blank if this is a stand-alone question..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-brand-700 mb-2 ml-1">The Question</label>
                            <textarea wire:model="question_text" rows="3"
                                class="w-full bg-brand-50/30 border border-brand-200 rounded-2xl py-4 px-5 outline-none focus:bg-white focus:ring-4 focus:ring-brand-500/20 font-bold text-slate-900 text-lg resize-y"
                                placeholder="What is the main idea of paragraph 2?"></textarea>
                            @error('question_text')
                                <span class="text-red-500 text-xs font-bold ml-1 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex-1 space-y-6 lg:border-l lg:border-slate-100 lg:pl-10">
                        <div>
                            <div class="flex justify-between items-end mb-4 ml-1">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <label class="block text-sm font-bold text-slate-700">Answer Options (A-E)</label>
                                </div>
                                <span
                                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-1 rounded-md">Fill
                                    at least 2</span>
                            </div>

                            @error('options_error')
                                <div
                                    class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                        </path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                            @error('options')
                                <span class="text-red-500 text-xs font-bold block mb-4 ml-1">{{ $message }}</span>
                            @enderror

                            <div class="space-y-4">
                                @foreach ($options as $index => $option)
                                    <div class="flex items-start gap-3">
                                        <button type="button" wire:click="setCorrect({{ $index }})"
                                            class="mt-2 shrink-0 w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all duration-200 {{ $option['is_correct'] ? 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-500/30 scale-110' : 'border-slate-300 text-slate-400 hover:border-emerald-400' }}"
                                            title="Mark as correct answer">
                                            <span class="text-xs font-black">{{ chr(65 + $index) }}</span>
                                        </button>

                                        <div class="flex-1">
                                            <textarea wire:model="options.{{ $index }}.text" rows="2"
                                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 outline-none transition-all resize-none {{ $option['is_correct'] ? 'ring-2 ring-emerald-500/20 border-emerald-500 bg-emerald-50/30 font-medium text-emerald-900' : 'focus:bg-white focus:ring-4 focus:ring-brand-500/20' }}"
                                                placeholder="Type option {{ chr(65 + $index) }} here (Leave blank to remove)"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Explanation
                                (Optional)</label>
                            <textarea wire:model="explanation" rows="2"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 outline-none focus:bg-white focus:ring-4 focus:ring-brand-500/20 text-sm text-slate-600 resize-none"
                                placeholder="Explain why the option is correct..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="$set('isModalOpen', false)"
                        class="px-6 py-3.5 rounded-2xl text-slate-600 font-bold hover:bg-slate-100 transition-colors border border-transparent">Cancel</button>
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-10 py-3.5 rounded-2xl font-black shadow-lg shadow-brand-500/30 transition-all active:scale-95">
                        Save to Bank
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@script
    <script>
        window.confirmDeleteQuestion = function(id) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                title: 'Delete this question?',
                text: "It will be removed permanently from the bank and all tests.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, delete it',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[32px] shadow-2xl border border-slate-100',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteQuestion(id);
                }
            });
        }
    </script>
@endscript
