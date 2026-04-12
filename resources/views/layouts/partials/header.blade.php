<header x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{
        'bg-white/80 backdrop-blur-lg shadow-md': scrolled,
        'bg-transparent': !
            scrolled,
        'bg-white shadow-md': mobileMenuOpen
    }"
    class="fixed top-0 w-full z-50 transition-all duration-300">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-600 to-accent-600 flex items-center justify-center shadow-lg text-white font-black text-xl group-hover:scale-110 transition-transform">
                    LF
                </div>
                <span class="font-extrabold text-2xl tracking-tight text-slate-900">
                    Lit<span class="text-brand-600">Flow</span>
                </span>
            </a>

            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-brand-600 font-bold' : 'text-slate-600 font-medium' }} hover:text-brand-600 transition-colors">Home</a>
                <a href="{{ route('modules.index') }}"
                    class="{{ request()->routeIs('modules.*') ? 'text-brand-600 font-bold' : 'text-slate-600 font-medium' }} hover:text-brand-600 transition-colors">Modules</a>
                <a href="{{ route('leaderboard') }}"
                    class="{{ request()->routeIs('leaderboard') ? 'text-brand-600 font-bold' : 'text-slate-600 font-medium' }} hover:text-brand-600 transition-colors">Leaderboard</a>
            </nav>

            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <div class="flex items-center gap-4 bg-white/50 p-1.5 pr-4 rounded-full border border-slate-200">
                        <div
                            class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <a href="{{ route('dashboard') }}"
                            class="text-slate-700 font-semibold hover:text-brand-600 transition-colors text-sm">Dashboard</a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors pt-1"
                                title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-8 py-2.5 rounded-full font-bold shadow-lg shadow-brand-500/30 hover:-translate-y-0.5 transition-all">
                        Sign In
                    </a>
                @endauth
            </div>

            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                    class="text-slate-600 hover:text-brand-600 focus:outline-none p-2" aria-controls="mobile-menu"
                    aria-expanded="false">
                    <span class="sr-only">Open main menu</span>

                    <svg x-show="!mobileMenuOpen" class="w-7 h-7 transition-transform" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg x-show="mobileMenuOpen" class="w-7 h-7 transition-transform" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" aria-hidden="true" x-cloak>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden absolute top-20 left-0 w-full bg-white border-b border-slate-100 shadow-xl" id="mobile-menu"
        x-cloak>

        <div class="px-6 pt-4 pb-8 space-y-2">
            <a href="{{ route('home') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('home') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-600 font-medium hover:bg-slate-50' }}">Home</a>
            <a href="{{ route('modules.index') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('modules.*') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-600 font-medium hover:bg-slate-50' }}">Modules</a>
            <a href="{{ route('leaderboard') }}"
                class="block px-4 py-3 rounded-2xl {{ request()->routeIs('leaderboard') ? 'bg-brand-50 text-brand-600 font-bold' : 'text-slate-600 font-medium hover:bg-slate-50' }}">Leaderboard</a>

            <div class="h-px bg-slate-100 my-4"></div>

            @auth
                <div class="flex items-center justify-between px-4 py-2">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-sm uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900">{{ explode(' ', Auth::user()->name)[0] }}</div>
                            <div class="text-xs text-slate-500">Student</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                        </button>
                    </form>
                </div>
                <a href="{{ route('dashboard') }}"
                    class="block mt-4 text-center w-full bg-slate-900 text-white px-6 py-3.5 rounded-2xl font-bold shadow-lg">
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="block w-full text-center px-4 py-3.5 rounded-2xl text-white font-bold bg-brand-600 shadow-lg shadow-brand-500/30 mb-3">Sign
                    In</a>
            @endauth
        </div>
    </div>
</header>
