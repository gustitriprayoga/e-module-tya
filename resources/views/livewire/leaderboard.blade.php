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
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)">

        {{-- Header --}}
        <div class="text-center mb-8" x-show="shown" x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-8">
            <span
                class="px-4 py-1.5 rounded-full bg-accent-100 text-accent-700 border border-accent-200 font-bold text-sm mb-4 inline-block tracking-wide">
                LitFlow Performers
            </span>
            <h1 class="text-5xl font-extrabold text-slate-950 mb-4 tracking-tight">Reading Champions</h1>
            <p class="text-slate-600 text-lg">Tracking the speed reading proficiency (WPM) of our best students.</p>
        </div>

        {{-- Module Selector --}}
        <div class="max-w-sm mx-auto mb-16 relative" x-show="shown"
            x-transition:enter="transition ease-out duration-700 delay-100"
            x-transition:enter-start="opacity-0 translate-y-4">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>

            <select wire:model.live="selectedModule"
                class="w-full bg-white/90 backdrop-blur-md border-2 border-white shadow-xl shadow-slate-200/50 rounded-2xl py-3.5 pl-12 pr-10 font-black text-slate-800 focus:ring-4 focus:ring-brand-500/20 focus:border-brand-300 outline-none appearance-none transition-all cursor-pointer">
                @forelse ($modules as $module)
                    <option value="{{ $module->id }}">{{ $module->title }}</option>
                @empty
                    <option value="">Tidak ada modul tersedia</option>
                @endforelse
            </select>

            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>

        {{-- Loading State --}}
        <div wire:loading wire:target="selectedModule" class="text-center py-20">
            <div class="inline-flex flex-col items-center gap-3">
                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-brand-600"></div>
                <p class="text-slate-500 font-medium">Memuat data...</p>
            </div>
        </div>

        {{-- Content --}}
        <div wire:loading.remove wire:target="selectedModule">
            @php
                $top1 = $rankings->get(0);
                $top2 = $rankings->get(1);
                $top3 = $rankings->get(2);
                $others = $rankings->slice(3)->values();
            @endphp

            @if ($rankings->count() > 0)

                {{-- Podium --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end mb-16 px-4 md:px-0">

                    {{-- 2nd Place --}}
                    <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-300"
                        x-transition:enter-start="opacity-0 translate-y-16"
                        class="order-2 md:order-1 {{ !$top2 ? 'invisible' : '' }}">
                        @if ($top2)
                            @php $name2 = $top2->user?->name ?? 'Student'; @endphp
                            <div
                                class="bg-white/60 backdrop-blur-xl p-8 rounded-[32px] border border-white shadow-xl shadow-slate-200/50 text-center h-[280px] flex flex-col justify-center relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">
                                <div
                                    class="absolute top-0 right-0 p-4 opacity-5 font-black text-9xl group-hover:scale-110 transition-transform select-none">
                                    2</div>
                                <div
                                    class="w-20 h-20 bg-slate-100 rounded-full mx-auto mb-4 border-4 border-white shadow-inner flex items-center justify-center text-2xl font-black text-slate-400 uppercase">
                                    {{ strtoupper(substr($name2, 0, 2)) }}
                                </div>
                                <h4 class="font-extrabold text-slate-900 text-xl truncate" title="{{ $name2 }}">
                                    {{ explode(' ', $name2)[0] }}
                                </h4>
                                <p class="text-slate-500 text-xs mt-0.5">{{ $top2->user?->nim_nip ?? '' }}</p>
                                <p class="text-brand-600 font-black text-3xl mt-2">
                                    {{ number_format($top2->top_wpm) }}
                                    <span class="text-sm font-bold text-slate-500">WPM</span>
                                </p>
                                <div
                                    class="mt-3 inline-flex items-center gap-1 px-3 py-1 bg-slate-100 rounded-full mx-auto">
                                    <span class="text-slate-500 text-xs font-bold">🥈 Peringkat 2</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- 1st Place --}}
                    <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-500"
                        x-transition:enter-start="opacity-0 translate-y-24" class="order-1 md:order-2 z-10">
                        @if ($top1)
                            @php $name1 = $top1->user?->name ?? 'Student'; @endphp
                            <div
                                class="bg-gradient-to-br from-brand-600 to-accent-600 p-10 rounded-[32px] text-center shadow-2xl shadow-brand-500/50 h-[340px] flex flex-col justify-center relative md:scale-110 border-4 border-white/30 hover:-translate-y-2 transition-transform duration-300 overflow-hidden">
                                <div class="absolute inset-0 bg-white/10 filter blur-xl rounded-[32px]"></div>
                                <div class="relative z-10">
                                    <div
                                        class="absolute -top-12 left-1/2 -translate-x-1/2 bg-yellow-400 text-white p-4 rounded-full shadow-xl shadow-yellow-500/40 border-4 border-white">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <h4 class="font-extrabold text-white text-3xl mb-1 mt-4 truncate"
                                        title="{{ $name1 }}">
                                        {{ explode(' ', $name1)[0] }}
                                    </h4>
                                    <p class="text-white/60 text-xs mb-2">{{ $top1->user?->nim_nip ?? '' }}</p>
                                    <p
                                        class="text-brand-100 font-bold mb-4 uppercase text-[10px] tracking-widest bg-black/20 inline-block px-3 py-1 rounded-full">
                                        🏆 Top Speed Reader
                                    </p>
                                    <p class="text-white font-black text-5xl drop-shadow-md">
                                        {{ number_format($top1->top_wpm) }}
                                        <span class="text-lg font-bold text-brand-200">WPM</span>
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- 3rd Place --}}
                    <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-100"
                        x-transition:enter-start="opacity-0 translate-y-16"
                        class="order-3 {{ !$top3 ? 'invisible' : '' }}">
                        @if ($top3)
                            @php $name3 = $top3->user?->name ?? 'Student'; @endphp
                            <div
                                class="bg-white/60 backdrop-blur-xl p-8 rounded-[32px] border border-white shadow-xl shadow-slate-200/50 text-center h-[250px] flex flex-col justify-center relative overflow-hidden group hover:-translate-y-2 transition-transform duration-300">
                                <div
                                    class="absolute top-0 right-0 p-4 opacity-5 font-black text-9xl group-hover:scale-110 transition-transform select-none">
                                    3</div>
                                <div
                                    class="w-16 h-16 bg-orange-50 rounded-full mx-auto mb-4 border-4 border-white shadow-inner flex items-center justify-center text-xl font-black text-orange-400 uppercase">
                                    {{ strtoupper(substr($name3, 0, 2)) }}
                                </div>
                                <h4 class="font-extrabold text-slate-900 text-lg truncate" title="{{ $name3 }}">
                                    {{ explode(' ', $name3)[0] }}
                                </h4>
                                <p class="text-slate-500 text-xs mt-0.5">{{ $top3->user?->nim_nip ?? '' }}</p>
                                <p class="text-brand-600 font-black text-2xl mt-2">
                                    {{ number_format($top3->top_wpm) }}
                                    <span class="text-xs font-bold text-slate-500">WPM</span>
                                </p>
                                <div
                                    class="mt-2 inline-flex items-center gap-1 px-3 py-1 bg-orange-50 rounded-full mx-auto">
                                    <span class="text-orange-500 text-xs font-bold">🥉 Peringkat 3</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Tabel peringkat 4+ --}}
                @if ($others->count() > 0)
                    <div x-show="shown" x-transition:enter="transition ease-out duration-1000 delay-700"
                        x-transition:enter-start="opacity-0 translate-y-8"
                        class="bg-white/70 backdrop-blur-2xl rounded-[32px] shadow-2xl shadow-slate-200/50 overflow-hidden border border-white">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-900/5 border-b border-slate-200/60">
                                    <tr>
                                        <th
                                            class="px-8 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-widest w-20">
                                            Rank</th>
                                        <th
                                            class="px-8 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-widest">
                                            Student</th>
                                        <th
                                            class="px-8 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-right">
                                            WPM</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($others as $index => $rank)
                                        @php $rankName = $rank->user?->name ?? 'Unknown Student'; @endphp
                                        <tr class="hover:bg-white/80 transition-colors duration-200 group">
                                            <td class="px-8 py-5 font-black text-slate-400 text-lg">
                                                #{{ $index + 4 }}
                                            </td>
                                            <td class="px-8 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-sm font-black text-slate-500 uppercase flex-shrink-0">
                                                        {{ strtoupper(substr($rankName, 0, 2)) }}
                                                    </div>
                                                    <div>
                                                        <div
                                                            class="font-extrabold text-slate-900 group-hover:text-brand-600 transition-colors">
                                                            {{ $rankName }}
                                                        </div>
                                                        @if ($rank->user?->nim_nip)
                                                            <div class="text-xs text-slate-400 font-medium mt-0.5">
                                                                NIM: {{ $rank->user->nim_nip }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <span
                                                    class="px-4 py-1.5 bg-brand-50 text-brand-700 border border-brand-100 rounded-xl font-bold text-sm inline-block">
                                                    {{ number_format($rank->top_wpm) }} WPM
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty state --}}
                <div x-show="shown" x-transition:enter="transition ease-out duration-700 delay-300"
                    x-transition:enter-start="opacity-0 translate-y-8"
                    class="text-center py-20 bg-white/60 backdrop-blur-md rounded-[32px] border border-white shadow-xl max-w-3xl mx-auto">
                    <div
                        class="w-24 h-24 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Belum Ada Data</h3>
                    <p class="text-slate-500 font-medium">Belum ada siswa yang menyelesaikan modul ini.<br>Jadilah yang
                        pertama!</p>
                </div>
            @endif
        </div>

    </div>
</div>
