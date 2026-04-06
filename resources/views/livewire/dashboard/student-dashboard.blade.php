<div>
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Hello, {{ Auth::user()->name }}! 🎓</h1>
        <p class="text-slate-600 mt-2">Ready to improve your reading speed today?</p>
    </div>

    <div
        class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-[32px] p-8 md:p-10 shadow-2xl relative overflow-hidden mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full filter blur-[80px] opacity-20"></div>

        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <span
                    class="px-4 py-1.5 rounded-full bg-white/10 text-brand-300 font-bold text-xs uppercase tracking-widest border border-white/20">Current
                    Milestone</span>
                <h2 class="text-4xl font-black text-white mt-4 mb-2">Reading II: Speed Reading</h2>
                <p class="text-slate-300">Complete the Pre-Test to unlock the 14 learning sessions.</p>
            </div>
            <button
                class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition-transform active:scale-95 whitespace-nowrap">
                Take Pre-Test Now
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm text-center">
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Your Best Speed</h4>
            <div class="text-6xl font-black text-slate-900 mb-2">0 <span class="text-xl text-brand-600">WPM</span></div>
            <p class="text-slate-500 text-sm">Target: 300 WPM</p>
        </div>
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm text-center">
            <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Vocabulary Mastered</h4>
            <div class="text-6xl font-black text-slate-900 mb-2">0 <span class="text-xl text-accent-600">Words</span>
            </div>
            <p class="text-slate-500 text-sm">Target: 3,500 Words</p>
        </div>
    </div>
</div>
