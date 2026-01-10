<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-72">
        <div class="flex flex-col h-0 flex-1 bg-slate-900 shadow-2xl">
            <div class="flex-1 flex flex-col pt-8 pb-4 overflow-y-auto">
                {{-- Logo Section --}}
                <div class="flex items-center flex-shrink-0 px-8 mb-10 overflow-hidden">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-500 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                            <span class="text-white font-black text-xl italic">R</span>
                        </div>
                        <span class="text-xl font-black text-white tracking-tight uppercase">Resto<span class="text-primary-400 font-light italic">QR</span></span>
                    </div>
                </div>

                {{-- Navigation Section --}}
                <nav class="mt-2 flex-1 px-4 space-y-2">
                    <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('staff.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-white' }} transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <div class="py-4">
                        <span class="px-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 block">Service</span>
                        <div class="space-y-1">
                            <a href="{{ route('staff.orders') }}" class="{{ request()->routeIs('staff.orders') ? 'bg-slate-800 text-white border-l-4 border-primary-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all">
                                Active Orders
                            </a>
                            <a href="{{ route('staff.menu') }}" class="{{ request()->routeIs('staff.menu') ? 'bg-slate-800 text-white border-l-4 border-primary-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all">
                                Menu Availability
                            </a>
                        </div>
                    </div>

                    <div class="py-4">
                        <span class="px-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 block">Records</span>
                        <div class="space-y-1">
                            <a href="{{ route('staff.history') }}" class="{{ request()->routeIs('staff.history') ? 'bg-slate-800 text-white border-l-4 border-primary-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all">
                                Order History
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            {{-- Logout Section --}}
            <div class="flex-shrink-0 flex bg-slate-900 pt-4 p-6 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full group flex items-center px-4 py-3.5 text-sm font-bold text-slate-400 hover:bg-red-500/10 hover:text-red-400 rounded-2xl transition-all duration-300">
                        <svg class="mr-3 h-5 w-5 text-slate-500 group-hover:text-red-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
