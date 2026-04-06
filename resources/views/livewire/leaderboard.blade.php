<div class="relative min-h-screen overflow-hidden pt-32 pb-20">
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-sky-50"></div>
        <div
            class="absolute -top-40 -left-40 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-blob">
        </div>
        <div
            class="absolute top-1/2 -right-40 w-96 h-96 bg-sky-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-40 left-1/4 w-96 h-96 bg-pink-400 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-blob animation-delay-4000">
        </div>
        <div class="absolute inset-0 bg-[url('/img/pattern.svg')] opacity-[0.03]"></div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">

        <div class="text-center mb-16" x-show="shown" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-8">
            <span
                class="px-4 py-1.5 rounded-full bg-accent-100 text-accent-700 border border-accent-200 font-bold text-sm mb-4 inline-block tracking-wide">Top
                Performers</span>
            <h1 class="text-5xl font-extrabold text-slate-950 mb-4 tracking-tight">Reading Champions</h1>
            <p class="text-slate-600 text-lg">Tracking the speed reading proficiency (WPM) of English Education
                students.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end mb-16">

            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-300"
                x-transition:enter-start="opacity-0 translate-y-16"
                class="bg-white/60 backdrop-blur-xl p-8 rounded-[32px] border border-white shadow-xl shadow-slate-200/50 text-center order-2 md:order-1 h-[280px] flex flex-col justify-center relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">
                <div
                    class="absolute top-0 right-0 p-4 opacity-5 font-black text-9xl group-hover:scale-110 transition-transform">
                    2</div>
                <div
                    class="w-20 h-20 bg-slate-100 rounded-full mx-auto mb-4 border-4 border-white shadow-inner flex items-center justify-center text-2xl font-black text-slate-400">
                    #2</div>
                <h4 class="font-extrabold text-slate-900 text-xl truncate">Mutiara Sophia</h4>
                <p class="text-brand-600 font-black text-3xl mt-1">285 <span
                        class="text-sm font-bold text-slate-500">WPM</span></p>
            </div>

            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-500"
                x-transition:enter-start="opacity-0 translate-y-24"
                class="bg-gradient-to-br from-brand-600 to-accent-600 p-10 rounded-[32px] text-center shadow-2xl shadow-brand-500/50 order-1 md:order-2 h-[340px] flex flex-col justify-center relative md:scale-110 border-4 border-white/30 z-10 hover:-translate-y-2 transition-transform duration-300">

                <div class="absolute inset-0 bg-white/20 filter blur-xl animate-pulse rounded-[32px]"></div>

                <div class="relative z-10">
                    <div
                        class="absolute -top-12 left-1/2 -translate-x-1/2 bg-yellow-400 text-white p-4 rounded-full shadow-xl shadow-yellow-500/40 border-4 border-white">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-extrabold text-white text-3xl mb-2 mt-4 truncate">Dr. Gusti Tri</h4>
                    <p
                        class="text-brand-100 font-bold mb-4 uppercase text-xs tracking-widest bg-black/20 inline-block px-3 py-1 rounded-full">
                        Top Speed Reader</p>
                    <p class="text-white font-black text-5xl drop-shadow-md">312 <span
                            class="text-lg font-bold text-brand-200">WPM</span></p>
                </div>
            </div>

            <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-100"
                x-transition:enter-start="opacity-0 translate-y-16"
                class="bg-white/60 backdrop-blur-xl p-8 rounded-[32px] border border-white shadow-xl shadow-slate-200/50 text-center order-3 h-[250px] flex flex-col justify-center relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">
                <div
                    class="absolute top-0 right-0 p-4 opacity-5 font-black text-9xl group-hover:scale-110 transition-transform">
                    3</div>
                <div
                    class="w-16 h-16 bg-orange-50 rounded-full mx-auto mb-4 border-4 border-white shadow-inner flex items-center justify-center text-xl font-black text-orange-400">
                    #3</div>
                <h4 class="font-extrabold text-slate-900 text-lg truncate">Indriyani S.</h4>
                <p class="text-brand-600 font-black text-2xl mt-1">260 <span
                        class="text-xs font-bold text-slate-500">WPM</span></p>
            </div>
        </div>

        <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-700"
            x-transition:enter-start="opacity-0 translate-y-8"
            class="bg-white/70 backdrop-blur-2xl rounded-[32px] shadow-2xl shadow-slate-200/50 overflow-hidden border border-white">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-900/5 border-b border-slate-200/60">
                        <tr>
                            <th class="px-8 py-6 text-xs font-extrabold text-slate-500 uppercase tracking-widest w-24">
                                Rank</th>
                            <th class="px-8 py-6 text-xs font-extrabold text-slate-500 uppercase tracking-widest">
                                Student Info</th>
                            <th class="px-8 py-6 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Score
                            </th>
                            <th
                                class="px-8 py-6 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-right">
                                Trend</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rankings->skip(3) as $index => $rank)
                            <tr class="hover:bg-white/80 transition-colors duration-200 group">
                                <td class="px-8 py-6 font-black text-slate-400 text-lg">#{{ $index + 4 }}</td>
                                <td class="px-8 py-6">
                                    <div
                                        class="font-extrabold text-slate-900 text-lg group-hover:text-brand-600 transition-colors">
                                        {{ $rank->user->name }}</div>
                                    <div class="text-sm text-slate-500 font-medium mt-1">NIM: {{ $rank->user->nim_nip }}
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span
                                        class="px-4 py-2 bg-brand-50 text-brand-700 border border-brand-100 rounded-xl font-bold shadow-sm">
                                        {{ $rank->wpm_result }} WPM
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div
                                        class="inline-flex items-center gap-2 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">
                                        <span
                                            class="text-emerald-600 font-extrabold text-sm">+{{ rand(5, 15) }}%</span>
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-slate-500 font-bold">More rankings
                                    will appear as students complete the modules.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
