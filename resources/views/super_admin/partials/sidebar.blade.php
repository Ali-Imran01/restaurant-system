{{-- Mobile Sidebar Backdrop --}}
<div x-show="mobileSidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     x-cloak 
     class="fixed inset-0 z-40 flex shadow-2xl md:hidden" 
     @click="mobileSidebarOpen = false">
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm"></div>
</div>

{{-- Sidebar Container --}}
<div class="fixed inset-y-0 left-0 z-50 flex flex-col sidebar-transition bg-slate-900 md:relative h-full overflow-hidden"
     :class="{
         'sidebar-collapsed': sidebarCollapsed && !mobileSidebarOpen,
         'sidebar-expanded': !sidebarCollapsed || mobileSidebarOpen,
         'mobile-sidebar-open': mobileSidebarOpen,
         'mobile-sidebar-closed': !mobileSidebarOpen
     }">
    
    <div class="flex-1 flex flex-col pt-8 pb-4 overflow-y-auto overflow-x-hidden">
        {{-- Logo Section --}}
        <div class="flex items-center flex-shrink-0 px-6 mb-10">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-500 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" 
                      x-transition:enter="transition ease-out duration-200"
                      x-transition:enter-start="opacity-0 -translate-x-4"
                      x-transition:enter-end="opacity-100 translate-x-0"
                      class="text-lg font-black text-white tracking-tight uppercase whitespace-nowrap">
                    Super <span class="text-indigo-400">Admin</span>
                </span>
            </div>
        </div>

        {{-- Navigation Section --}}
        <nav class="mt-2 flex-1 px-4 space-y-2">
            <a href="{{ route('super_admin.dashboard') }}" 
               class="{{ request()->routeIs('super_admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 overflow-hidden"
               title="Platform Overview">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('super_admin.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-white' }} transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Platform Overview</span>
            </a>

            <div class="py-4">
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="px-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 block whitespace-nowrap">Scale</span>
                <div class="space-y-1">
                    <a href="{{ route('super_admin.restaurants') }}" 
                       class="{{ request()->routeIs('super_admin.restaurants*') ? 'bg-slate-800 text-white border-l-4 border-indigo-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all overflow-hidden"
                       title="Manage Restaurants">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                        <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Manage Restaurants</span>
                    </a>
                </div>
            </div>

            <div class="py-4">
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="px-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 block whitespace-nowrap">Operations</span>
                <div class="space-y-1">
                    <a href="{{ route('super_admin.users') }}" 
                       class="{{ request()->routeIs('super_admin.users*') ? 'bg-slate-800 text-white border-l-4 border-indigo-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all overflow-hidden"
                       title="Platform Team">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Platform Team</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    {{-- Logout Section --}}
    <div class="flex-shrink-0 flex bg-slate-900 pt-4 p-6 border-t border-slate-800 overflow-hidden">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full group flex items-center px-4 py-3.5 text-sm font-bold text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-2xl transition-all duration-300" title="Sign Out">
                <svg class="mr-3 h-5 w-5 text-red-500/50 group-hover:text-red-400 transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Sign Out</span>
            </button>
        </form>
    </div>
</div>
