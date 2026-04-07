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
                        class="px-3 py-1 bg-brand-100 text-brand-700 font-bold text-xs rounded-lg uppercase tracking-widest">Meeting
                        {{ $session->order_number }}</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $session->title }}</h1>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button @click="previewOpen = true"
                    class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-3 rounded-2xl font-bold shadow-lg transition-all active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    Preview
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

                        @if ($block->type === 'reading_text')
                            @php $settings = is_array($block->settings) ? $block->settings : json_decode($block->settings, true); @endphp
                            <div class="flex flex-wrap items-center gap-3 mt-4 pt-4 border-t border-slate-100">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-brand-50 text-brand-700 text-xs font-bold rounded-lg border border-brand-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Target: {{ $settings['target_wpm'] ?? 250 }} WPM
                                </span>
                                @if (isset($settings['has_timer']) && $settings['has_timer'])
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-pink-50 text-pink-700 text-xs font-bold rounded-lg border border-pink-100">
                                        <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Live Timer Active
                                    </span>
                                @endif
                            </div>
                        @endif
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
                <div
                    class="w-20 h-20 bg-brand-50 text-brand-500 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-inner">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h4 class="text-2xl font-extrabold text-slate-900 mb-2">Blank Canvas</h4>
                <p class="text-slate-500 mb-6 max-w-sm mx-auto">Add a PBL Intro to stimulate students, followed by a
                    Speed Reading Text with a timer.</p>
                <button wire:click="create" class="text-brand-600 font-bold hover:underline">Start Building</button>
            </div>
        @endforelse
    </div>

    <div x-show="previewOpen" class="fixed inset-0 z-[60] flex flex-col bg-slate-50 overflow-hidden" x-cloak>
        <div class="bg-slate-900 text-white px-6 py-4 flex justify-between items-center shadow-lg z-10 shrink-0">
            <div class="flex items-center gap-3">
                <span class="flex h-3 w-3 relative">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="font-bold tracking-widest text-xs uppercase text-slate-300">Student View Simulation</span>
            </div>
            <button @click="previewOpen = false"
                class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                Exit Preview
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-4 md:p-10 relative">
            <div class="max-w-3xl mx-auto space-y-8 pb-20">

                <div class="text-center mb-10">
                    <h2 class="text-4xl font-extrabold text-slate-900 mb-2">{{ $session->title }}</h2>
                    <p class="text-slate-500 font-medium">Session {{ $session->order_number }}</p>
                </div>

                @forelse($blocks as $block)
                    @php
                        $content = is_array($block->content) ? $block->content : json_decode($block->content, true);
                        $settings = is_array($block->settings) ? $block->settings : json_decode($block->settings, true);
                    @endphp

                    @if ($block->type === 'pbl_intro')
                        <div class="bg-accent-50 border-l-4 border-accent-500 rounded-r-2xl p-6 shadow-sm">
                            <div class="flex items-start gap-4">
                                <div class="bg-accent-100 p-2 rounded-lg text-accent-600 shrink-0 mt-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-accent-800 text-lg mb-2">Problem Trigger</h4>
                                    <p class="text-accent-900 leading-relaxed font-medium">
                                        {{ $content['text'] ?? '' }}</p>
                                </div>
                            </div>
                        </div>
                    @elseif($block->type === 'reading_text')
                        <div
                            class="bg-white rounded-[32px] shadow-xl border border-slate-100 overflow-hidden relative">

                            @if (isset($settings['has_timer']) && $settings['has_timer'])
                                <div
                                    class="bg-slate-900 px-6 py-4 flex justify-between items-center sticky top-0 z-10 shadow-md">
                                    <div class="flex items-center gap-3 text-white">
                                        <svg class="w-5 h-5 text-brand-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-bold text-sm tracking-wider">READING TIMER</span>
                                    </div>
                                    <div class="font-mono text-2xl font-black text-brand-400">00:00</div>
                                </div>
                            @endif

                            <div class="p-8 md:p-12">
                                <p
                                    class="text-slate-800 text-lg md:text-xl leading-[2.2] font-serif whitespace-pre-line text-justify">
                                    {{ $content['text'] ?? '' }}
                                </p>
                            </div>

                            @if (isset($settings['has_timer']) && $settings['has_timer'])
                                <div class="bg-slate-50 border-t border-slate-100 p-6 flex justify-center">
                                    <button
                                        class="bg-brand-600 text-white px-10 py-4 rounded-2xl font-bold shadow-lg shadow-brand-500/30 text-lg">
                                        I Have Finished Reading
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                @empty
                    <div class="text-center py-20 text-slate-400 font-bold">
                        Add blocks to see the preview.
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
            class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-100">

            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">
                    {{ $block_id ? 'Edit Content Block' : 'Add Content Block' }}</h2>
                <button wire:click="$set('isModalOpen', false)"
                    class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="flex gap-4">
                    <div class="w-24 shrink-0">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Order</label>
                        <input wire:model="sort_order" type="number"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 outline-none font-bold text-center"
                            min="1">
                        @error('sort_order')
                            <span class="text-red-500 text-xs font-semibold">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Block Type</label>
                        <select wire:model.live="type"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 outline-none font-bold text-slate-800 appearance-none">
                            <option value="pbl_intro">Problem-Based Learning Intro (Trigger)</option>
                            <option value="reading_text">Speed Reading Text (With Timer)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Main Content
                        (Text/Paragraph)</label>
                    <textarea wire:model="content_text" rows="6"
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-5 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 outline-none text-slate-800 leading-relaxed resize-y"
                        placeholder="Enter the learning material or story here..."></textarea>
                    @error('content_text')
                        <span class="text-red-500 text-xs font-semibold block mt-1 ml-1">{{ $message }}</span>
                    @enderror
                </div>

                @if ($type === 'reading_text')
                    <div class="bg-brand-50 border border-brand-100 rounded-[24px] p-6 space-y-5 animate-fade-in-up">
                        <h4
                            class="font-extrabold text-brand-900 text-sm uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Speed Reading Settings
                        </h4>
                        <div class="flex flex-col sm:flex-row gap-6 items-center">
                            <div class="w-full sm:w-1/2">
                                <label class="block text-sm font-bold text-brand-800 mb-2 ml-1">Target WPM</label>
                                <input wire:model="target_wpm" type="number"
                                    class="w-full bg-white border border-brand-200 rounded-xl py-3 px-4 focus:ring-2 focus:ring-brand-500 outline-none font-bold text-brand-900"
                                    min="50" max="1000">
                                <p class="text-[11px] text-brand-600 mt-1 ml-1">Standard target is 250 - 300 WPM.</p>
                            </div>
                            <div class="w-full sm:w-1/2 pt-2 sm:pt-6">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="relative inline-block w-12 align-middle select-none transition duration-200 ease-in">
                                        <input wire:model="has_timer" type="checkbox" id="toggleTimer"
                                            class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 z-10 checked:translate-x-6 checked:border-brand-600" />
                                        <label for="toggleTimer"
                                            class="toggle-label block overflow-hidden h-6 rounded-full bg-brand-200 cursor-pointer transition-colors duration-200 peer-checked:bg-brand-600"></label>
                                    </div>
                                    <label for="toggleTimer"
                                        class="text-sm font-bold text-brand-900 cursor-pointer">Enable Live
                                        Timer</label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="pt-6 flex justify-end">
                    <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95 w-full sm:w-auto">
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
    </style>

</div>

@script
    <script>
        window.confirmDeleteBlock = function(blockId) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                title: 'Delete this block?',
                text: "This content will be permanently removed from this session.",
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
