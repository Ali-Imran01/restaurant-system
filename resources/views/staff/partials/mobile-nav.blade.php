<div class="md:hidden fixed bottom-6 left-6 right-6 z-50">
    <div class="bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-[28px] shadow-[0_20px_50px_rgba(0,0,0,0.3)] px-6 h-20 flex items-center justify-between">
        <a href="{{ route('staff.dashboard') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('staff.dashboard') ? 'text-primary-400' : 'text-slate-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-[10px] font-black uppercase tracking-widest">Dash</span>
        </a>

        <a href="{{ route('staff.orders') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('staff.orders') ? 'text-primary-400' : 'text-slate-500' }}">
            <div class="relative">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span class="absolute -top-1 -right-1 w-2 h-2 bg-primary-500 rounded-full animate-ping"></span>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest">Orders</span>
        </a>

        <a href="{{ route('staff.menu') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('staff.menu') ? 'text-primary-400' : 'text-slate-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span class="text-[10px] font-black uppercase tracking-widest">Menu</span>
        </a>

        <a href="{{ route('staff.history') }}" class="flex flex-col items-center space-y-1 {{ request()->routeIs('staff.history') ? 'text-primary-400' : 'text-slate-500' }}">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-[10px] font-black uppercase tracking-widest">History</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="flex flex-col items-center">
            @csrf
            <button type="submit" class="flex flex-col items-center space-y-1 text-slate-500">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="text-[10px] font-black uppercase tracking-widest">Exit</span>
            </button>
        </form>
    </div>
</div>
