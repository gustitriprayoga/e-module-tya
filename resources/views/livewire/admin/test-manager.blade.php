<div class="relative z-30" x-data="{
    testModal: @entangle('isModalOpen'),
    managerModal: @entangle('isQuestionManagerOpen'),
    passageModal: @entangle('isPassageFormOpen'),
    formModal: @entangle('isQuestionFormOpen')
}">

    {{-- Main Page Content (Unchanged) --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 bg-brand-100 text-brand-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                Test Manager
            </h1>
            <p class="text-slate-500 mt-2">Manage Pre-tests, Post-tests, and build specific questions for each.</p>
        </div>
        <button wire:click="createTest" class="flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg shadow-brand-500/30 transition-all active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Create New Test
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($tests as $testItem)
            <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[32px] p-6 md:p-8 shadow-xl shadow-slate-200/50 flex flex-col relative group hover:border-brand-300 transition-all duration-300">
                <div class="absolute top-6 right-6 flex items-center gap-2">
                    <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-slate-200">
                        {{ str_replace('-', ' ', $testItem->type) }}
                    </span>
                    @if ($testItem->is_active)
                        <span class="flex h-3 w-3 relative"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span></span>
                    @else
                        <span class="flex h-3 w-3 relative bg-slate-300 rounded-full"></span>
                    @endif
                </div>

                <h3 class="text-xl font-extrabold text-slate-900 mb-1 pr-24 line-clamp-2">{{ $testItem->title }}</h3>
                <p class="text-xs font-bold text-brand-600 uppercase tracking-widest mb-6">
                    <span class="text-slate-400">Module:</span>
                    {{ $testItem->module ? $testItem->module->title : 'Unassigned' }}
                </p>

                <div class="space-y-3 mb-8">
                    <div class="flex justify-between items-center text-sm font-bold border-b border-slate-100 pb-2">
                        <span class="text-slate-500">Duration</span>
                        <span class="text-slate-900">{{ $testItem->duration }} Mins</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold border-b border-slate-100 pb-2">
                        <span class="text-slate-500">Passing Score</span>
                        <span class="text-emerald-600">{{ $testItem->passing_score }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm font-bold pb-2">
                        <span class="text-slate-500">Total Questions</span>
                        <span class="{{ $testItem->questions_count > 0 ? 'text-brand-600 bg-brand-50' : 'text-slate-500 bg-slate-100' }} px-2 py-0.5 rounded-md">
                            {{ $testItem->questions_count }} Items
                        </span>
                    </div>
                </div>

                <div class="mt-auto flex gap-2">
                    <button wire:click="manageQuestions({{ $testItem->id }})" class="flex-1 bg-brand-50 hover:bg-brand-100 text-brand-700 py-2.5 rounded-xl font-bold text-sm transition-colors border border-brand-100">
                        Manage Questions
                    </button>
                    <button wire:click="editTest({{ $testItem->id }})" class="p-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <button onclick="confirmDeleteTest({{ $testItem->id }})" class="p-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full p-16 text-center bg-white/50 backdrop-blur-xl border border-white rounded-[32px] shadow-xl">
                <p class="text-slate-500 font-bold mb-4">No tests configured yet.</p>
                <button wire:click="createTest" class="text-brand-600 font-bold hover:underline">Create a Test now</button>
            </div>
        @endforelse
    </div>
    <div class="mt-8">{{ $tests->links() }}</div>

    {{-- Test Create/Edit Modal (Unchanged) --}}
    <div x-show="testModal" class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-cloak>
        <div x-show="testModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="testModal = false"></div>
        <div x-show="testModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" class="relative bg-white rounded-[40px] shadow-2xl w-full max-w-xl overflow-hidden border border-slate-100">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $test_id ? 'Edit Test' : 'Create Test' }}</h2>
                <button @click="testModal = false" class="text-slate-400 hover:text-slate-700 bg-white border border-slate-200 p-2 rounded-full"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" /></svg></button>
            </div>
            <form wire:submit.prevent="saveTest" class="p-8 space-y-6">
                {{-- Form fields are unchanged --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Target Module</label>
                    <select wire:model="module_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none focus:ring-4 focus:ring-brand-500/20 text-slate-700">
                        <option value="">-- Select Module --</option>
                        @foreach ($modules as $mod)
                            <option value="{{ $mod->id }}">{{ $mod->title }}</option>
                        @endforeach
                    </select>
                    @error('module_id') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Test Title</label>
                        <input wire:model="title" type="text" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none focus:ring-4 focus:ring-brand-500/20">
                        @error('title') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-1/3">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Type</label>
                        <select wire:model="type" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none focus:ring-4 focus:ring-brand-500/20">
                            <option value="pre-test">Pre-Test</option>
                            <option value="post-test">Post-Test</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Duration (Mins)</label>
                        <input wire:model="duration" type="number" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none text-center">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Passing Score</label>
                        <input wire:model="passing_score" type="number" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none text-center text-emerald-600">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-2 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="relative inline-block w-12 align-middle select-none">
                        <input wire:model="is_active" type="checkbox" id="toggleActive" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-transform duration-200 z-10 checked:translate-x-6 checked:border-emerald-500" />
                        <label for="toggleActive" class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-200 cursor-pointer transition-colors duration-200 peer-checked:bg-emerald-500"></label>
                    </div>
                    <div>
                        <label for="toggleActive" class="text-sm font-bold text-slate-900 cursor-pointer">Activate / Publish to Students</label>
                    </div>
                </div>
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-brand-500/30 w-full transition-all active:scale-95">Save Settings</button>
                </div>
            </form>
        </div>
    </div>

    {{-- NEW: Passage & Question Manager Modal --}}
    <div x-show="managerModal" class="fixed inset-0 z-[110] flex items-center justify-center px-4 py-6" x-cloak>
        <div x-show="managerModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" @click="managerModal = false"></div>
        <div x-show="managerModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" class="relative bg-white rounded-[32px] shadow-2xl w-full max-w-6xl h-[90vh] flex flex-col overflow-hidden border border-slate-100">
            @if($test)
            <div class="bg-white border-b border-slate-200 px-8 py-5 flex justify-between items-center shrink-0">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-brand-500 block mb-1">Passage & Question Manager:</span>
                    <h2 class="text-2xl font-extrabold text-slate-900 leading-tight">{{ $test->title }}</h2>
                </div>
                <div class="flex items-center gap-3">
                    <button wire:click="createPassage" class="bg-brand-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-brand-500/30 hover:bg-brand-700 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Add New Passage
                    </button>
                    <button @click="managerModal = false" class="p-2.5 text-slate-400 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 rounded-full transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" /></svg></button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-8 bg-slate-50/50 custom-scrollbar">
                <div class="space-y-8">
                    @forelse($test->testPassages as $passage)
                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-md shadow-slate-200/50" wire:key="passage-{{ $passage->id }}">
                            {{-- Passage Header --}}
                            <div class="flex justify-between items-start gap-4 mb-4 pb-4 border-b border-slate-100">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-slate-800">{{ $passage->title ?: 'Reading Passage' }}</h3>
                                    <div class="mt-2 text-sm text-slate-600 font-serif prose max-w-none prose-sm">
                                        {!! nl2br(e($passage->content)) !!}
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button wire:click="editPassage({{ $passage->id }})" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-bold">EDIT PASSAGE</button>
                                    <button onclick="confirmDeletePassage({{ $passage->id }})" class="px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold">DELETE</button>
                                </div>
                            </div>
                            
                            {{-- Questions for this passage --}}
                            <div class="space-y-3">
                                @forelse ($passage->questions as $index => $q)
                                    <div class="flex items-start gap-4 p-4 bg-slate-50 border border-slate-100 rounded-xl hover:bg-white transition-all">
                                        <div class="shrink-0 w-8 h-8 bg-white border border-slate-200 text-slate-500 font-black rounded-lg flex items-center justify-center">{{ $index + 1 }}</div>
                                        <div class="flex-1 min-w-0">
                                            <span class="px-2 py-0.5 bg-brand-50 text-brand-600 text-[10px] font-black uppercase rounded tracking-widest border border-brand-100">{{ $q->indicator }}</span>
                                            <p class="font-bold text-slate-800 text-md leading-relaxed mt-2">{{ $q->question_text }}</p>
                                        </div>
                                        <div class="flex flex-col gap-2 shrink-0">
                                            <button wire:click="editQuestion({{ $q->id }})" class="p-2 bg-white hover:bg-brand-50 text-slate-500 hover:text-brand-600 rounded-lg transition-colors border border-slate-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></button>
                                            <button onclick="confirmDeleteQuestion({{ $q->id }})" class="p-2 bg-white hover:bg-red-50 text-slate-500 hover:text-red-600 rounded-lg transition-colors border border-slate-200"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 border-2 border-dashed border-slate-200 rounded-xl">
                                        <p class="text-slate-500 font-bold text-sm">No questions for this passage yet.</p>
                                    </div>
                                @endforelse
                            </div>
                            
                            {{-- Add Question Button --}}
                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <button wire:click="createQuestion({{ $passage->id }})" class="w-full text-center py-3 bg-brand-50 hover:bg-brand-100 text-brand-600 border-2 border-dashed border-brand-200 rounded-xl font-bold text-sm transition-colors">
                                    + Add Question to this Passage
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-24 bg-white border-2 border-dashed border-slate-200 rounded-[24px]">
                            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-slate-600 font-bold text-xl">This test has no passages yet.</p>
                            <p class="text-slate-400 text-sm mt-2">Click "Add New Passage" to start building your test.</p>
                        </div>
                    @endforelse
                </div>
            </div>
             <div class="bg-white border-t border-slate-200 p-4 text-center shrink-0">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Total: <span class="text-brand-600">{{ $test->testPassages->count() }}</span> Passages, <span class="text-brand-600">{{ $test->questions_count }}</span> Questions</p>
            </div>
            @endif
        </div>
    </div>

    {{-- NEW: Passage Form Modal --}}
     <div x-show="passageModal" class="fixed inset-0 z-[120] flex items-center justify-center px-4" x-cloak>
        <div x-show="passageModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="passageModal = false"></div>
        <div x-show="passageModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" class="relative bg-white rounded-[40px] shadow-2xl w-full max-w-3xl overflow-hidden border border-slate-100">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-2xl font-extrabold text-slate-900">{{ $passage_id ? 'Edit Passage' : 'Create New Passage' }}</h2>
                <button @click="passageModal = false" class="text-slate-400 hover:text-slate-700 bg-white border border-slate-200 p-2 rounded-full"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" /></svg></button>
            </div>
            <form wire:submit.prevent="savePassage" class="p-8 space-y-6">
                 <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Passage Title (Optional)</label>
                    <input wire:model="passage_title" type="text" placeholder="e.g., Passage for items 1-10" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3 px-4 font-bold outline-none focus:ring-4 focus:ring-brand-500/20">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Passage Content</label>
                    <textarea wire:model="passage_content" rows="10" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-4 px-5 outline-none focus:bg-white focus:ring-4 focus:ring-amber-500/20 font-serif text-slate-800 resize-y" placeholder="Paste the long reading text here..."></textarea>
                    @error('passage_content') <span class="text-red-500 text-xs font-bold ml-1 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                     <button type="button" @click="passageModal = false" class="px-6 py-3.5 rounded-2xl text-slate-600 font-bold hover:bg-slate-100 transition-colors">Cancel</button>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-3.5 rounded-2xl font-black shadow-lg shadow-brand-500/30 w-1/2 transition-all active:scale-95">Save Passage</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODIFIED: Question Form Modal --}}
    <div x-show="formModal" class="fixed inset-0 z-[130] flex items-center justify-center px-4" x-cloak>
        <div x-show="formModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
        <div x-show="formModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" class="relative bg-white rounded-[40px] shadow-2xl w-full max-w-5xl overflow-hidden border border-slate-100 max-h-[90vh] flex flex-col">
            <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h2 class="text-xl font-extrabold text-slate-900">{{ $question_id ? 'Edit Question' : 'Add New Question' }}</h2>
                <button wire:click="$set('isQuestionFormOpen', false)" class="text-slate-400 hover:text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 p-2 rounded-full transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
            <form wire:submit.prevent="saveQuestion" class="p-8 max-h-[75vh] overflow-y-auto custom-scrollbar">
                <div class="flex flex-col lg:flex-row gap-10">
                    <div class="flex-1 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Reading Indicator</label>
                            <select wire:model="indicator" class="w-full bg-slate-50 border border-slate-200 rounded-2xl py-3.5 px-4 outline-none focus:bg-white focus:ring-4 focus:ring-brand-500/20 font-bold text-slate-800 appearance-none">
                                <option value="">-- Select Indicator --</option>
                                @foreach ($indicators as $ind)
                                    <option value="{{ $ind }}">{{ $ind }}</option>
                                @endforeach
                            </select>
                            @error('indicator') <span class="text-red-500 text-xs font-bold ml-1 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        {{-- DELETED: Reading Passage Textarea --}}

                        <div>
                            <label class="block text-sm font-bold text-brand-700 mb-2 ml-1">The Question</label>
                            <textarea wire:model="question_text" rows="3" class="w-full bg-brand-50/30 border border-brand-200 rounded-2xl py-4 px-5 outline-none focus:bg-white focus:ring-4 focus:ring-brand-500/20 font-bold text-slate-900 text-lg resize-y" placeholder="What is the main idea...?"></textarea>
                            @error('question_text') <span class="text-red-500 text-xs font-bold ml-1 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex-1 space-y-6 lg:border-l lg:border-slate-100 lg:pl-10">
                        <div>
                            <div class="flex justify-between items-end mb-4 ml-1">
                                <label class="block text-sm font-bold text-slate-700">Answer Options (A-E)</label>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-100 px-2 py-1 rounded-md">Fill at least 2</span>
                            </div>
                            @error('options_error')
                                <div class="mb-4 bg-red-50 text-red-600 px-4 py-3 rounded-xl text-sm font-bold">{{ $message }}</div>
                            @enderror
                            @error('options')
                                <span class="text-red-500 text-xs font-bold block mb-4 ml-1">{{ $message }}</span>
                            @enderror
                            <div class="space-y-4">
                                @foreach ($options as $index => $option)
                                    <div class="flex items-start gap-3">
                                        <button type="button" wire:click="setCorrectOption({{ $index }})" class="mt-2 shrink-0 w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all duration-200 {{ $option['is_correct'] ? 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-500/30 scale-110' : 'border-slate-300 text-slate-400 hover:border-emerald-400' }}" title="Set as correct answer">
                                            <span class="text-xs font-black">{{ chr(65 + $index) }}</span>
                                        </button>
                                        <div class="flex-1">
                                            <textarea wire:model="options.{{ $index }}.text" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 outline-none transition-all resize-none {{ $option['is_correct'] ? 'ring-2 ring-emerald-500/20 border-emerald-500 bg-emerald-50/30 font-medium text-emerald-900' : 'focus:bg-white focus:ring-4 focus:ring-brand-500/20' }}" placeholder="Type option {{ chr(65 + $index) }} here (Leave blank to remove)"></textarea>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pt-4 border-t border-slate-100">
                            <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Explanation (Optional)</label>
                            <textarea wire:model="explanation" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 px-4 outline-none focus:bg-white focus:ring-4 focus:ring-brand-500/20 text-sm text-slate-600 resize-none" placeholder="Explain why the option is correct..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="mt-10 pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="button" wire:click="$set('isQuestionFormOpen', false)" class="px-6 py-3.5 rounded-2xl text-slate-600 font-bold hover:bg-slate-100 transition-colors">Cancel</button>
                    <button type="submit" class="bg-brand-600 hover:bg-brand-700 text-white px-10 py-3.5 rounded-2xl font-black shadow-lg shadow-brand-500/30 transition-all active:scale-95">Save Question</button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Styles and Scripts --}}
    <style>
        .toggle-checkbox:checked{right:0;border-color:#10b981}.toggle-checkbox:checked+.toggle-label{background-color:#10b981}.toggle-checkbox{right:24px;border-color:#e2e8f0}.custom-scrollbar::-webkit-scrollbar{width:6px}.custom-scrollbar::-webkit-scrollbar-track{background:transparent}.custom-scrollbar::-webkit-scrollbar-thumb{background-color:#cbd5e1;border-radius:20px}
    </style>
</div>

@script
    <script>
        function confirmDialog(title, text, confirmButtonText, callback) {
            if (typeof Swal === 'undefined') return;
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                confirmButtonText: confirmButtonText,
                customClass: {
                    popup: 'rounded-[32px] shadow-2xl border border-slate-100',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) callback();
            });
        }

        window.confirmDeleteTest = function(id) {
            confirmDialog('Delete Test?', 'This will permanently remove the test and ALL questions inside it.', 'Yes, Delete', () => {
                $wire.deleteTest(id);
            });
        }
        
        window.confirmDeletePassage = function(id) {
            confirmDialog('Delete Passage?', 'This will permanently remove the passage and ALL questions associated with it.', 'Yes, Delete Passage', () => {
                $wire.deletePassage(id);
            });
        }

        window.confirmDeleteQuestion = function(id) {
             confirmDialog('Delete Question?', null, 'Yes', () => {
                $wire.deleteQuestion(id);
            });
        }
    </script>
@endscript
