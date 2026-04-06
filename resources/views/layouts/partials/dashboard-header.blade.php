<header
    class="h-20 bg-white/60 backdrop-blur-xl border-b border-white flex items-center justify-between px-4 sm:px-6 lg:px-8 z-20 shadow-sm">
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true"
            class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
            </svg>
        </button>
        <h2 class="text-xl font-extrabold text-slate-800">{{ $title ?? 'Dashboard' }}</h2>
    </div>

    <div class="flex items-center gap-4">
        @if (Auth::user()->roles->count() > 1)
            <div x-data="{ open: false }" class="relative hidden sm:block">
                <button @click="open = !open"
                    class="px-5 py-2 rounded-full bg-brand-50 border border-brand-100 text-brand-700 text-xs font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-brand-100 transition-colors">
                    {{ request()->routeIs('dashboard.admin*') ? 'Admin Mode' : 'Student Mode' }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition.opacity
                    class="absolute right-0 mt-2 w-48 bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50"
                    x-cloak>

                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('dashboard.admin') }}"
                            class="block px-4 py-3 text-sm font-bold text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors">
                            Switch to Admin
                        </a>
                    @endif

                    @if (Auth::user()->hasRole(['mahasiswa', 'dosen']))
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-3 text-sm font-bold text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors border-t border-slate-100">
                            Switch to Student
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div
                class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-bold uppercase tracking-widest hidden sm:block">
                {{ Auth::user()->roles->pluck('name')->first() ?? 'User' }}
            </div>
        @endif

        <div x-data="{ profileOpen: false }" class="relative">
            <button @click="profileOpen = !profileOpen"
                class="w-10 h-10 rounded-full bg-slate-200 border-2 border-white shadow-sm flex items-center justify-center font-bold text-slate-600 hover:ring-2 hover:ring-brand-500 transition-all">
                {{ substr(Auth::user()->name, 0, 1) }}
            </button>

            <div x-show="profileOpen" @click.away="profileOpen = false" x-transition.opacity
                class="absolute right-0 mt-2 w-56 bg-white/90 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-100 overflow-hidden z-50"
                x-cloak>
                <div class="px-4 py-3 border-b border-slate-100">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ Auth::user()->nim_nip ?? 'No NIM' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
