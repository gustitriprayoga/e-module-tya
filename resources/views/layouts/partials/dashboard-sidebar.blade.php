<div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden"
    @click="sidebarOpen = false" x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-white/90 backdrop-blur-2xl border-r border-white transition-all duration-300 lg:translate-x-0 lg:static lg:flex-shrink-0 flex flex-col h-full shadow-2xl lg:shadow-none overflow-hidden">

    <div class="h-20 flex items-center px-8 border-b border-slate-100 flex-shrink-0">
        <a href="/" class="flex items-center gap-3 group">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-600 to-accent-600 flex items-center justify-center shadow-lg shadow-brand-500/30 text-white font-black text-xl group-hover:scale-110 transition-transform">
                UP
            </div>
            <span class="font-extrabold text-xl tracking-tight text-slate-900">Pahlawan<span
                    class="text-brand-600">Hub</span></span>
        </a>
    </div>

    <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto hide-scrollbar">

        @if (request()->routeIs('dashboard.admin*'))
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-2">Researcher Menu
            </p>

            <a href="{{ route('dashboard.admin') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard.admin') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/40 font-bold' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Overview
            </a>

            <a href="{{ route('admin.modules') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                    </path>
                </svg>
                Module Builder
            </a>

            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                    </path>
                </svg>
                Instrument Bank
            </a>

            <a href="{{ route('admin.vocabulary') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('admin.vocabulary') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/40 font-bold' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                Vocab Vault
            </a>

            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Research Stats
            </a>

            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                SSO Monitor
            </a>
        @else
            <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mt-2">Student Menu</p>
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl {{ request()->routeIs('dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-500/40 font-bold' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium' }} transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                My Progress
            </a>
            <a href="{{ route('modules.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-600 hover:bg-brand-50 hover:text-brand-600 font-medium transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                Course Modules
            </a>
        @endif
    </nav>

    <div class="p-6 border-t border-slate-100 flex-shrink-0">
        @if (Auth::user()->roles->count() > 1)
            <div
                class="px-4 py-2 mb-4 bg-brand-50 rounded-xl border border-brand-100 text-[10px] font-bold text-brand-600 uppercase text-center">
                Multi-Role Access Active
            </div>
        @endif
        <p class="text-[10px] text-center text-slate-400 font-bold tracking-widest uppercase">PahlawanHub v1.0</p>
    </div>
</aside>
