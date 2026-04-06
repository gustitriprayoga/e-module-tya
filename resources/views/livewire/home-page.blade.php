<div class="relative min-h-screen overflow-hidden">
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-sky-50"></div>
        <div
            class="absolute -top-40 -left-40 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-60 animate-blob">
        </div>
        <div
            class="absolute top-1/2 -right-40 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-60 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-40 left-1/4 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-60 animate-blob animation-delay-4000">
        </div>
        <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-[0.03]"></div>
    </div>

    <section x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 100)"
        class="relative pt-32 pb-24 md:pt-40 md:pb-32 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center z-10">

        <div class="absolute inset-0 pointer-events-none z-0 hidden md:block">
            <div
                class="absolute top-20 left-10 w-20 h-20 bg-white/40 backdrop-blur-xl border border-white/60 rounded-full shadow-xl animate-[float_6s_ease-in-out_infinite]">
            </div>
            <div
                class="absolute top-40 right-20 w-16 h-16 bg-gradient-to-tr from-brand-300 to-accent-300 opacity-60 backdrop-blur-md rounded-full shadow-lg animate-[float-reverse_5s_ease-in-out_infinite]">
            </div>
            <div
                class="absolute bottom-20 left-1/4 w-12 h-12 bg-pink-300/50 backdrop-blur-xl rounded-full shadow-pink-500/50 shadow-2xl animate-[float_4s_ease-in-out_infinite]">
            </div>
            <div class="absolute top-32 left-1/4 animate-[float-reverse_7s_ease-in-out_infinite] opacity-70">
                <span class="text-5xl drop-shadow-xl">📖</span>
            </div>
            <div class="absolute bottom-32 right-1/4 animate-[float_6s_ease-in-out_infinite] opacity-70">
                <span class="text-5xl drop-shadow-xl">🚀</span>
            </div>
        </div>
        <div class="relative z-10">
            <div x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-100"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/60 border border-white/80 backdrop-blur-xl text-brand-700 font-semibold text-sm mb-12 shadow-xl shadow-brand-500/10 group overflow-hidden">
                <span class="flex h-2 w-2 rounded-full bg-brand-500 animate-ping"></span>
                Reading II Course Available Now
                <div
                    class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/60 to-transparent">
                </div>
            </div>

            <h1 x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-300"
                x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                class="text-6xl md:text-8xl font-extrabold text-slate-950 tracking-tight mb-8 leading-[0.95] drop-shadow-sm">
                Master <span class="text-brand-600">Speed Reading</span> <br>
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 via-accent-500 to-brand-600 animate-shimmer">
                    The Interactive Way
                </span>
            </h1>

            <p x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-500"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                class="text-xl md:text-2xl text-slate-700 max-w-4xl mx-auto mb-16 leading-relaxed">
                Engage with Problem-Based Learning, track your Words Per Minute (WPM) in real-time, and conquer the
                <strong class="text-slate-900 font-bold">3,500 vocabulary</strong> target at Universitas Pahlawan Tuanku
                Tambusai.
            </p>

            <div x-show="visible" x-transition:enter="transition ease-out duration-1000 delay-700"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="flex flex-col sm:flex-row gap-6 w-full sm:w-auto items-center justify-center">
                <button wire:click="startPreTest"
                    class="relative group bg-brand-600 hover:bg-brand-700 text-white px-10 py-4.5 rounded-2xl font-bold text-lg shadow-xl shadow-brand-500/30 hover:shadow-brand-500/60 hover:-translate-y-1.5 transition-all duration-300 overflow-hidden">
                    Take the Pre-Test
                    <div
                        class="absolute inset-0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent">
                    </div>
                </button>
                <a href="#modules"
                    class="bg-white/40 hover:bg-white/60 text-slate-900 border border-white/60 px-10 py-4.5 rounded-2xl font-bold text-lg shadow-sm backdrop-blur-md hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    Explore Modules
                </a>
            </div>
        </div>
    </section>

    <section x-data="{ shown: false }" x-intersect.full="shown = true"
        class="relative py-16 bg-white/30 backdrop-blur-xl border-y border-white/50 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-100"
                x-transition:enter-start="opacity-0 translate-y-4"
                class="p-8 rounded-3xl bg-white/50 border border-white/70 shadow-sm hover:scale-105 transition-transform duration-300">
                <p class="text-5xl font-extrabold text-brand-600 mb-2">23</p>
                <p class="text-sm text-slate-700 font-medium uppercase tracking-wider">Research Students</p>
            </div>
            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                class="p-8 rounded-3xl bg-white/50 border border-white/70 shadow-sm hover:scale-105 transition-transform duration-300">
                <p class="text-5xl font-extrabold text-accent-600 mb-2">3,500+</p>
                <p class="text-sm text-slate-700 font-medium uppercase tracking-wider">Target Vocabulary</p>
            </div>
            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-500"
                x-transition:enter-start="opacity-0 translate-y-4"
                class="p-8 rounded-3xl bg-white/50 border border-white/70 shadow-sm hover:scale-105 transition-transform duration-300">
                <p class="text-5xl font-extrabold text-brand-600 mb-2">14</p>
                <p class="text-sm text-slate-700 font-medium uppercase tracking-wider">Learning Sessions</p>
            </div>
            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-700"
                x-transition:enter-start="opacity-0 translate-y-4"
                class="p-8 rounded-3xl bg-white/50 border border-white/70 shadow-sm hover:scale-105 transition-transform duration-300">
                <p class="text-5xl font-extrabold text-accent-600 mb-2">100%</p>
                <p class="text-sm text-slate-700 font-medium uppercase tracking-wider">Interactive Media</p>
            </div>
        </div>
    </section>

    <section id="modules" x-data="{ shown: false }" x-intersect.full="shown = true" class="relative py-28 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-show="shown" x-transition:enter="transition ease-out duration-700" class="text-center mb-16">
                <span
                    class="px-4 py-1.5 rounded-full bg-accent-50 text-accent-700 border border-accent-100 font-medium text-sm mb-4 inline-block">Course
                    Catalog</span>
                <h2 class="text-5xl font-extrabold text-slate-950 mb-4">Available Modules</h2>
                <p class="text-lg text-slate-700 max-w-xl mx-auto">Select a course to begin your personalized reading
                    journey.</p>
            </div>

            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-300"
                x-transition:enter-start="opacity-0 translate-y-8"
                class="group relative w-full max-w-3xl mx-auto aspect-[16/10] bg-slate-900 rounded-[32px] overflow-hidden shadow-2xl shadow-slate-900/30 transform transition duration-500 hover:scale-[1.03] hover:shadow-brand-900/40">
                <div class="absolute inset-0 opacity-40 group-hover:opacity-60 transition-opacity duration-700">
                    <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?q=80&w=2070&auto=format&fit=crop"
                        alt="Library Background" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent"></div>
                <div
                    class="absolute -top-16 -right-16 w-64 h-64 bg-brand-500 rounded-full filter blur-[100px] opacity-30 group-hover:opacity-50 transition-opacity">
                </div>
                <div class="relative p-10 md:p-12 flex flex-col justify-end h-full">
                    <div class="mb-auto flex justify-between items-start">
                        <span
                            class="relative px-5 py-2 rounded-full bg-brand-500/20 text-brand-300 border border-brand-500/30 text-sm font-semibold backdrop-blur-md overflow-hidden group/badge">
                            14 Sessions
                            <div
                                class="absolute inset-0 translate-x-[-100%] group-hover/badge:translate-x-[100%] transition-transform duration-1000 bg-gradient-to-r from-transparent via-white/20 to-transparent">
                            </div>
                        </span>
                        <div
                            class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 text-white group-hover:bg-brand-600 transition-colors duration-300 shadow-inner">
                            <svg class="w-7 h-7 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">
                        Reading II: Speed Reading</h3>
                    <p class="text-slate-200 mb-10 max-w-xl text-lg leading-relaxed line-clamp-2 drop-shadow">Master
                        skimming, scanning, and identifying main ideas through a digital Problem-Based Learning
                        environment at Universitas Pahlawan Tuanku Tambusai.</p>
                    <div class="w-full bg-slate-800/80 rounded-full h-3 mb-2 backdrop-blur-sm shadow-inner">
                        <div
                            class="bg-gradient-to-r from-brand-500 via-accent-500 to-pink-500 h-3 rounded-full w-0 group-hover:w-full transition-all duration-1500 ease-out shadow-lg">
                        </div>
                    </div>
                    <div
                        class="flex justify-between text-xs text-slate-300 font-semibold uppercase tracking-wider drop-shadow">
                        <span class="group-hover:text-brand-300 transition-colors">Pre-Test Locked</span>
                        <span>0% Complete</span>
                    </div>
                </div>
                <a href="#pre-test" wire:click.prevent="startPreTest" class="absolute inset-0 z-10"></a>
            </div>
        </div>
    </section>

    <section x-data="{ shown: false }" x-intersect.margin="-100px" x-on:intersect="shown = true"
        class="relative py-28 bg-white/60 backdrop-blur-2xl border-t border-white/70 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div x-show="shown" x-transition:enter="transition ease-out duration-700" class="text-center mb-20">
                <span
                    class="px-4 py-1.5 rounded-full bg-brand-50 text-brand-700 border border-brand-100 font-medium text-sm mb-4 inline-block">The
                    ADDIE Method</span>
                <h2 class="text-5xl font-extrabold text-slate-950 mb-4">Your Reading Journey</h2>
                <p class="text-lg text-slate-700 max-w-xl mx-auto">A seamless 4-step process to transform your
                    comprehension and speed.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-100"
                    x-transition:enter-start="opacity-0 translate-y-10"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="relative p-10 rounded-[28px] bg-white border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 group">
                    <div
                        class="w-16 h-16 rounded-2xl bg-brand-100 text-brand-600 flex items-center justify-center mb-8 font-extrabold text-3xl group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        1</div>
                    <h4 class="text-xl font-bold text-slate-950 mb-3">Diagnostic</h4>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">Complete the Pre-Test to analyze your
                        current reading level and vocabulary knowledge.</p>
                    <a href="#" wire:click.prevent="startPreTest"
                        class="text-brand-600 font-semibold text-sm inline-flex items-center gap-1.5 group-hover:text-brand-800">Start
                        Test <svg class="w-4 h-4 transform group-hover:translate-x-2 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg></a>
                </div>

                <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-10"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="relative p-10 rounded-[28px] bg-white border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 group">
                    <div
                        class="w-16 h-16 rounded-2xl bg-accent-100 text-accent-600 flex items-center justify-center mb-8 font-extrabold text-3xl group-hover:scale-110 group-hover:-rotate-6 transition-transform">
                        2</div>
                    <h4 class="text-xl font-bold text-slate-950 mb-3">Investigation</h4>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">Engage with 14 interactive sessions using
                        skimming and scanning to solve PBL problems.</p>
                    <a href="#modules"
                        class="text-accent-600 font-semibold text-sm inline-flex items-center gap-1.5 group-hover:text-accent-800">Start
                        Learning <svg class="w-4 h-4 transform group-hover:translate-x-2 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg></a>
                </div>

                <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-10"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="relative p-10 rounded-[28px] bg-white border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 group">
                    <div
                        class="w-16 h-16 rounded-2xl bg-pink-100 text-pink-600 flex items-center justify-center mb-8 font-extrabold text-3xl group-hover:scale-110 group-hover:rotate-6 transition-transform">
                        3</div>
                    <h4 class="text-xl font-bold text-slate-950 mb-3">Evaluation</h4>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">Take the Post-Test to measure your final
                        proficiency and vocabulary mastery.</p>
                    <a href="#"
                        class="text-pink-600 font-semibold text-sm inline-flex items-center gap-1.5 group-hover:text-pink-800">Lock
                        In Scores <svg class="w-4 h-4 transform group-hover:translate-x-2 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg></a>
                </div>

                <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-700"
                    x-transition:enter-start="opacity-0 translate-y-10"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="relative p-10 rounded-[28px] bg-white border border-slate-100 shadow-sm hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 group">
                    <div
                        class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-8 font-extrabold text-3xl group-hover:scale-110 group-hover:-rotate-6 transition-transform">
                        4</div>
                    <h4 class="text-xl font-bold text-slate-950 mb-3">N-Gain Analysis</h4>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">View your automated N-Gain analysis to see
                        your percentage of improvement.</p>
                    <a href="#"
                        class="text-emerald-600 font-semibold text-sm inline-flex items-center gap-1.5 group-hover:text-emerald-800">View
                        Progress <svg class="w-4 h-4 transform group-hover:translate-x-2 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg></a>
                </div>
            </div>
        </div>
    </section>
</div>
