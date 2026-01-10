<div class="flex flex-col w-64 bg-slate-900 h-screen fixed left-0 top-0 shadow-2xl z-50">
    <div class="flex items-center justify-center h-20 border-b border-slate-800">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-primary-500 rounded-xl shadow-lg shadow-primary-500/20">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <span class="text-xl font-black text-white tracking-tight">SUPER <span class="text-primary-400">ADMIN</span></span>
        </div>
    </div>

    <div class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
        <a href="{{ route('super_admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-bold transition-all duration-200 rounded-xl group {{ request()->routeIs('super_admin.dashboard') ? 'bg-primary-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
            Platform Overview
        </a>

        <a href="{{ route('super_admin.restaurants') }}" class="flex items-center px-4 py-3 text-sm font-bold transition-all duration-200 rounded-xl group {{ request()->routeIs('super_admin.restaurants*') ? 'bg-primary-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            Manage Restaurants
        </a>

        <a href="{{ route('super_admin.users') }}" class="flex items-center px-4 py-3 text-sm font-bold transition-all duration-200 rounded-xl group {{ request()->routeIs('super_admin.users*') ? 'bg-primary-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            Platform Team
        </a>
    </div>

    <div class="p-6 mt-auto border-t border-slate-800">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-bold text-red-400 transition-all duration-200 rounded-xl hover:bg-red-500/10 hover:text-red-300">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Sign Out
            </button>
        </form>
    </div>
</div>
