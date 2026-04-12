<div class="w-full max-w-md relative z-10" x-data="{ loading: false }">
    <div class="text-center mb-8">
        <div
            class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-600 to-accent-600 shadow-xl shadow-brand-500/30 mb-5">
            <span class="text-white font-black text-3xl tracking-tighter">UP</span>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Welcome Back</h2>
        <p class="text-slate-600 mt-2 font-medium">Login to Digital Learning</p>
    </div>

    <div class="bg-white/80 backdrop-blur-2xl border border-white shadow-2xl rounded-[32px] p-8 md:p-10">
        <form wire:submit.prevent="login" @submit="loading = true">

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-800 mb-2 ml-1">Username / NIM</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <input wire:model="username" type="text" required
                        class="w-full bg-white/60 border border-slate-300 rounded-2xl py-3.5 pl-11 pr-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-medium placeholder-slate-400"
                        placeholder="1855201011">
                </div>
                @error('username')
                    <span class="text-red-500 text-xs mt-1 ml-1 font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-800 mb-2 ml-1">Password</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <input wire:model="password" type="password" required
                        class="w-full bg-white/60 border border-slate-300 rounded-2xl py-3.5 pl-11 pr-4 focus:bg-white focus:ring-4 focus:ring-brand-500/20 focus:border-brand-500 transition-all outline-none text-slate-900 font-medium placeholder-slate-400"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <span class="text-red-500 text-xs mt-1 ml-1 font-semibold">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" :disabled="loading"
                class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-brand-400 text-white font-bold py-4 rounded-2xl shadow-lg shadow-brand-500/40 transform transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                <span x-show="!loading">Sign In to Dashboard</span>

                <span x-cloak x-show="loading" class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Authenticating...
                </span>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-200 text-center">
            <p class="text-[11px] text-slate-500 uppercase tracking-widest font-extrabold mb-3">Campus Integrated Login
            </p>
            <div class="flex justify-center">
                <img src="/img/up-logo.png" alt="Universitas Pahlawan"
                    class="h-10 opacity-75 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </div>

    <p class="text-center mt-8">
        <a href="/" class="text-slate-600 hover:text-brand-600 font-bold hover:underline transition-colors">← Back
            to Homepage</a>
    </p>
</div>
