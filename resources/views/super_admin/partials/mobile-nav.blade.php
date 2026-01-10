<div class="md:hidden fixed bottom-6 left-0 right-0 px-6 z-50">
    <div class="bg-indigo-950/95 backdrop-blur-xl border border-white/10 rounded-[28px] shadow-[0_20px_50px_rgba(0,0,0,0.5)] px-6 h-20 flex items-center justify-between">
        {{-- Overview --}}
        <a href="{{ route('super_admin.dashboard') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('super_admin.dashboard') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 group-active:scale-90' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('super_admin.dashboard') ? 'text-indigo-400' : 'text-slate-500' }}">Stats</span>
        </a>

        {{-- Restaurants --}}
        <a href="{{ route('super_admin.restaurants') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('super_admin.restaurants*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 group-active:scale-90' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('super_admin.restaurants*') ? 'text-indigo-400' : 'text-slate-500' }}">Venues</span>
        </a>

        {{-- Users --}}
        <a href="{{ route('super_admin.users') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('super_admin.users*') ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/30' : 'text-slate-500 group-active:scale-90' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('super_admin.users*') ? 'text-indigo-400' : 'text-slate-500' }}">Team</span>
        </a>

        {{-- Exit to Admin (if appropriate) --}}
        <form action="{{ route('logout') }}" method="POST" class="flex flex-col items-center justify-center space-y-1 group">
            @csrf
            <button type="submit" class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 text-red-400/50 hover:text-red-400 group-active:scale-90">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Exit</span>
        </form>
    </div>
</div>
