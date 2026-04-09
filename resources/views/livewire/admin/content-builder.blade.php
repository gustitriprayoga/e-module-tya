<div class="relative z-10" x-data="{ modalOpen: @entangle('isModalOpen'), previewOpen: false }">

    <div class="mb-8">
        <a href="{{ route('admin.sessions', $session->module_id) }}"
            class="inline-flex items-center gap-2 text-brand-600 font-bold text-sm mb-4 hover:underline transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Back to Sessions
        </a>
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <span
                        class="px-3 py-1 bg-brand-100 text-brand-700 font-bold text-xs rounded-lg uppercase tracking-widest">
                        Meeting {{ $session->order_number }}
                    </span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $session->title }}</h1>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button @click="previewOpen = true"
                    class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl font-bold shadow-lg transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Book Preview
                </button>

                <button wire:click="create"
                    class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4">
                        </path>
                    </svg>
                    Add Block
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        @forelse($blocks as $block)
            <div class="relative pl-8 md:pl-0">
                <div class="absolute left-3 top-0 bottom-[-24px] w-0.5 bg-slate-200 md:hidden block"></div>
                <div
                    class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] shadow-xl shadow-slate-200/50 p-6 md:p-8 flex flex-col md:flex-row gap-6 relative group hover:border-brand-300 transition-all duration-300">
                    <div
                        class="absolute -left-4 md:-left-6 top-8 w-8 h-8 md:w-12 md:h-12 bg-slate-900 text-white font-black rounded-full flex items-center justify-center shadow-lg border-4 border-slate-50 z-10">
                        {{ $block->sort_order }}
                    </div>
                    <div class="flex-shrink-0 md:ml-4">
                        @if ($block->type === 'pbl_intro')
                            <div
                                class="w-16 h-16 bg-accent-100 text-accent-600 rounded-2xl flex items-center justify-center mb-2 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-bold text-slate-500 uppercase tracking-widest text-center block">PBL
                                Intro</span>
                        @else
                            <div
                                class="w-16 h-16 bg-brand-100 text-brand-600 rounded-2xl flex items-center justify-center mb-2 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="text-xs font-bold text-slate-500 uppercase tracking-widest text-center block">Reading
                                Text</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        @php $content = is_array($block->content) ? $block->content : json_decode($block->content, true); @endphp
                        <p class="text-slate-700 text-lg leading-relaxed line-clamp-3">
                            {{ $content['text'] ?? 'No content available.' }}</p>
                    </div>
                    <div class="flex flex-row md:flex-col gap-2 justify-end shrink-0">
                        <button wire:click="edit({{ $block->id }})"
                            class="p-3 bg-slate-100 hover:bg-brand-50 text-slate-600 hover:text-brand-600 rounded-xl transition-colors shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </button>
                        <button onclick="confirmDeleteBlock({{ $block->id }})"
                            class="p-3 bg-slate-100 hover:bg-red-50 text-slate-600 hover:text-red-600 rounded-xl transition-colors shadow-sm">
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
            <div class="text-center py-16 bg-white/50 backdrop-blur-xl border border-white rounded-[32px] shadow-xl">
                <p class="text-slate-500">No content blocks found. Start building below.</p>
            </div>
        @endforelse
    </div>

    <div x-show="previewOpen" class="fixed inset-0 z-[100] bg-slate-50 flex flex-col overflow-hidden" x-cloak>
        <div class="bg-slate-900 text-white p-4 flex justify-between items-center px-8 shadow-xl shrink-0">
            <div class="flex items-center gap-4">
                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                <div>
                    <span class="font-bold text-[10px] tracking-widest uppercase opacity-70 block">Book
                        Simulation</span>
                    <h3 class="font-bold text-sm">{{ $session->title }}</h3>
                </div>
            </div>
            <button @click="previewOpen = false"
                class="bg-white/10 px-4 py-2 rounded-xl font-bold text-sm hover:bg-white/20 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" />
                </svg>
                Close Book
            </button>
        </div>

        <div class="flex-1 flex items-center justify-center p-4 md:p-10 relative overflow-hidden"
            x-data="{ currentStep: 0, totalSteps: {{ count($blocks) }} }">

            <div
                class="absolute -top-40 -left-40 w-96 h-96 bg-brand-200/40 rounded-full filter blur-[100px] pointer-events-none">
            </div>
            <div
                class="absolute -bottom-40 -right-40 w-96 h-96 bg-accent-200/40 rounded-full filter blur-[100px] pointer-events-none">
            </div>

            <div
                class="w-full max-w-4xl h-full max-h-[800px] bg-white rounded-[40px] shadow-2xl border border-slate-200 flex flex-col relative z-10 overflow-hidden">

                <div class="h-1.5 bg-slate-100">
                    <div class="h-full bg-gradient-to-r from-brand-500 to-accent-500 transition-all duration-500"
                        :style="`width: ${((currentStep + 1) / (totalSteps || 1)) * 100}%`"></div>
                </div>

                <div class="flex-1 overflow-y-auto p-10 md:p-16 hide-scrollbar relative">
                    @forelse($blocks as $index => $block)
                        @php
                            $content = is_array($block->content) ? $block->content : json_decode($block->content, true);
                            $settings = is_array($block->settings)
                                ? $block->settings
                                : json_decode($block->settings, true);
                        @endphp

                        <div x-show="currentStep === {{ $index }}"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 translate-x-12"
                            x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">

                            @if ($block->type === 'pbl_intro')
                                <div class="max-w-2xl mx-auto text-center py-10">
                                    <div
                                        class="w-20 h-20 bg-accent-100 text-accent-600 rounded-[30%] flex items-center justify-center mx-auto mb-10 rotate-6 shadow-inner">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight mb-6">
                                        {{ $content['text'] ?? '' }}
                                    </h2>
                                    <div
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-accent-50 text-accent-700 rounded-full font-bold text-xs uppercase tracking-widest">
                                        <span class="w-2 h-2 rounded-full bg-accent-500 animate-ping"></span>
                                        Phase 1: Problem Trigger
                                    </div>
                                </div>
                            @elseif($block->type === 'reading_text')
                                <div class="font-serif">
                                    @if ($settings['has_timer'] ?? false)
                                        <div
                                            class="flex justify-between items-center mb-10 pb-6 border-b border-slate-100 sticky top-0 bg-white/90 backdrop-blur-md z-20">
                                            <div
                                                class="text-[10px] font-black uppercase tracking-widest text-slate-400 italic">
                                                Target Speed: {{ $settings['target_wpm'] }} WPM
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <svg class="w-5 h-5 text-brand-500" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                                        stroke-width="2.5" stroke-linecap="round" />
                                                </svg>
                                                <div class="font-mono text-4xl font-black text-slate-900">00:00</div>
                                            </div>
                                        </div>
                                    @endif

                                    <article
                                        class="text-xl md:text-2xl text-slate-800 leading-[2.2] text-justify whitespace-pre-line">
                                        {!! $this->highlightVocabulary($content['text'] ?? '') !!}
                                    </article>

                                    @if ($settings['has_timer'] ?? false)
                                        <div class="mt-16 flex justify-center">
                                            <button
                                                class="bg-brand-600 hover:bg-brand-700 text-white px-12 py-5 rounded-[24px] font-black text-xl shadow-xl shadow-brand-500/30 transition-all active:scale-95">
                                                I've Finished Reading
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-slate-400">
                            <p class="font-bold">No pages to preview.</p>
                        </div>
                    @endforelse
                </div>

                <div
                    class="p-6 border-t border-slate-100 flex justify-between items-center px-10 bg-slate-50/50 shrink-0">
                    <button @click="if(currentStep > 0) currentStep--" :disabled="currentStep === 0"
                        class="disabled:opacity-20 flex items-center gap-2 font-bold text-slate-600 hover:text-brand-600 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                        Previous
                    </button>

                    <div class="px-4 py-1.5 bg-white border border-slate-200 rounded-full shadow-sm">
                        <span class="font-bold text-xs text-slate-400 uppercase tracking-widest">
                            Page <span x-text="currentStep + 1" class="text-slate-900"></span> / <span
                                x-text="totalSteps"></span>
                        </span>
                    </div>

                    <button @click="if(currentStep < totalSteps - 1) currentStep++"
                        :disabled="currentStep === totalSteps - 1"
                        class="disabled:opacity-20 flex items-center gap-2 font-bold text-brand-600 hover:text-brand-800 transition-all">
                        Next
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-width="2.5" stroke-linecap="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-[110] flex items-center justify-center px-4" x-cloak>
        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"
            @click="modalOpen = false"></div>
        <div x-show="modalOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-8 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100">

            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $block_id ? 'Edit Block' : 'Add Block' }}</h2>
                <button wire:click="$set('isModalOpen', false)"
                    class="text-slate-400 hover:text-slate-600 bg-slate-100 p-2 rounded-full"><svg class="w-5 h-5"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" />
                    </svg></button>
            </div>

            <form wire:submit.prevent="save" class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="flex gap-4">
                    <div class="w-24 shrink-0">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Order</label>
                        <input wire:model="sort_order" type="number"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none font-bold text-center">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Block Type</label>
                        <select wire:model.live="type"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white outline-none font-bold text-slate-800">
                            <option value="pbl_intro">Problem-Based Learning Intro</option>
                            <option value="reading_text">Speed Reading Text</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Main Content</label>
                    <textarea wire:model="content_text" rows="6"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-5 focus:bg-white focus:ring-4 focus:ring-brand-500/20 outline-none text-slate-800 leading-relaxed resize-y"
                        placeholder="Enter material here..."></textarea>
                    @error('content_text')
                        <span class="text-red-500 text-xs font-semibold">{{ $message }}</span>
                    @enderror
                </div>

                @if ($type === 'reading_text')
                    <div class="bg-brand-50 border border-brand-100 rounded-[24px] p-6 space-y-5 animate-fade-in-up">
                        <div class="flex flex-col sm:flex-row gap-6 items-center">
                            <div class="w-full sm:w-1/2">
                                <label class="block text-sm font-bold text-brand-800 mb-2">Target WPM</label>
                                <input wire:model="target_wpm" type="number"
                                    class="w-full bg-white border border-brand-200 rounded-xl py-3 px-4 outline-none font-bold text-brand-900"
                                    min="50">
                            </div>
                            <div class="w-full sm:w-1/2 pt-6">
                                <label class="flex items-center gap-3 cursor-pointer">
                                    <div
                                        class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                                        <input wire:model="has_timer" type="checkbox"
                                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 z-10 checked:translate-x-6 checked:border-brand-600" />
                                        <label
                                            class="toggle-label block overflow-hidden h-6 rounded-full bg-brand-200"></label>
                                    </div>
                                    <span class="text-sm font-bold text-brand-900">Enable Live Timer</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="pt-6">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg w-full transition-all active:scale-95">
                        Save Block
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .toggle-checkbox:checked {
            right: 0;
            border-color: #2563eb;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #2563eb;
        }

        .toggle-checkbox {
            right: 24px;
            border-color: #bfdbfe;
        }

        .toggle-label {
            background-color: #bfdbfe;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>

@script
    <script>
        window.confirmDeleteBlock = function(blockId) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                title: 'Delete this block?',
                text: "This content will be permanently removed.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[32px] shadow-2xl border border-slate-100',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.deleteBlock(blockId);
                }
            });
        }
    </script>
@endscript
