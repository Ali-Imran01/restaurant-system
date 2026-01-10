<div class="md:hidden fixed bottom-6 left-0 right-0 px-6 z-50">
    <div class="bg-slate-900/95 backdrop-blur-xl border border-white/10 rounded-[28px] shadow-[0_20px_50px_rgba(0,0,0,0.3)] px-6 h-20 flex items-center justify-between">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-primary-500 text-white' : 'text-slate-500 group-active:scale-90' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('admin.dashboard') ? 'text-primary-400' : 'text-slate-500' }}">Home</span>
        </a>

        {{-- Menu --}}
        <a href="{{ route('menu_items.index') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('menu_items.*') ? 'bg-primary-500 text-white' : 'text-slate-500 group-active:scale-90' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('menu_items.*') ? 'text-primary-400' : 'text-slate-500' }}">Menu</span>
        </a>

        {{-- Tables --}}
        <a href="{{ route('tables.index') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('tables.*') ? 'bg-primary-500 text-white' : 'text-slate-500 group-active:scale-90' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('tables.*') ? 'text-primary-400' : 'text-slate-500' }}">QR</span>
        </a>

        {{-- Profile --}}
        <a href="{{ route('admin.customisation.edit') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 {{ request()->routeIs('admin.customisation.*') ? 'bg-primary-500 text-white' : 'text-slate-500 group-active:scale-90' }}">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest {{ request()->routeIs('admin.customisation.*') ? 'text-primary-400' : 'text-slate-500' }}">Settings</span>
        </a>

        {{-- Platform Switch (if super admin) --}}
        @if(auth()->user()->role === 'super_admin')
        <a href="{{ route('super_admin.dashboard') }}" class="flex flex-col items-center justify-center space-y-1 group">
            <div class="w-10 h-10 rounded-2xl flex items-center justify-center transition-all duration-300 bg-indigo-500/20 text-indigo-400 group-active:scale-90">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-indigo-400">Master</span>
        </a>
        @endif
    </div>
</div>
