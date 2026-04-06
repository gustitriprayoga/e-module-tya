<header x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="{ 'bg-white/80 backdrop-blur-lg shadow-md': scrolled, 'bg-transparent': !scrolled }"
    class="fixed top-0 w-full z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-600 to-accent-600 flex items-center justify-center shadow-lg text-white font-bold text-xl group-hover:scale-110 transition-transform">
                    UP
                </div>
                <span class="font-bold text-xl tracking-tight text-slate-900">
                    Pahlawan<span class="text-brand-600">Hub</span>
                </span>
            </a>

            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}"
                    class="{{ request()->routeIs('home') ? 'text-brand-600' : 'text-slate-600' }} hover:text-brand-600 font-medium transition-colors">Home</a>
                <a href="{{ route('modules.index') }}"
                    class="{{ request()->routeIs('modules.*') ? 'text-brand-600' : 'text-slate-600' }} hover:text-brand-600 font-medium transition-colors">Modules</a>
                <a href="{{ route('leaderboard') }}"
                    class="{{ request()->routeIs('leaderboard') ? 'text-brand-600' : 'text-slate-600' }} hover:text-brand-600 font-medium transition-colors">Leaderboard</a>
            </nav>

            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <div class="flex items-center gap-4 bg-white/50 p-1.5 pr-4 rounded-full border border-slate-200">
                        <div
                            class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold text-xs">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <a href="{{ route('dashboard') }}"
                            class="text-slate-700 font-semibold hover:text-brand-600 transition-colors text-sm">Dashboard</a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors">
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
                        class="text-brand-600 font-semibold hover:text-brand-900 transition-colors">Sign In</a>
                    <a href="#"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-full font-semibold shadow-lg shadow-brand-500/30 hover:-translate-y-0.5 transition-all">
                        Join Now
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
