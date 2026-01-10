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
                <div class="w-10 h-10 bg-primary-500 rounded-2xl flex items-center justify-center shadow-lg shadow-primary-500/30 flex-shrink-0">
                    <span class="text-white font-black text-xl italic">R</span>
                </div>
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" 
                      x-transition:enter="transition ease-out duration-200"
                      x-transition:enter-start="opacity-0 -translate-x-4"
                      x-transition:enter-end="opacity-100 translate-x-0"
                      class="text-xl font-black text-white tracking-tight uppercase whitespace-nowrap">
                    Resto<span class="text-primary-400 font-light italic">QR</span>
                </span>
            </div>
        </div>

        {{-- Navigation Section --}}
        <nav class="mt-2 flex-1 px-4 space-y-2">
            <a href="{{ route('staff.dashboard') }}" 
               class="{{ request()->routeIs('staff.dashboard') ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/20' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white' }} group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300 overflow-hidden"
               title="Dashboard">
                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('staff.dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-white' }} transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Dashboard</span>
            </a>

            <div class="py-4">
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="px-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 block whitespace-nowrap">Service</span>
                <div class="space-y-1">
                    <a href="{{ route('staff.orders') }}" 
                       class="{{ request()->routeIs('staff.orders') ? 'bg-slate-800 text-white border-l-4 border-primary-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all overflow-hidden"
                       title="Active Orders">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Active Orders</span>
                    </a>
                    <a href="{{ route('staff.menu') }}" 
                       class="{{ request()->routeIs('staff.menu') ? 'bg-slate-800 text-white border-l-4 border-primary-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all overflow-hidden"
                       title="Menu Availability">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                        <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Menu Availability</span>
                    </a>
                    <a href="{{ route('admin.reservations.index') }}" 
                       class="{{ request()->routeIs('admin.reservations.*') ? 'bg-slate-800 text-white border-l-4 border-primary-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all overflow-hidden"
                       title="Reservations">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Reservations</span>
                    </a>
                </div>
            </div>

            <div class="py-4">
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="px-5 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3 block whitespace-nowrap">Records</span>
                <div class="space-y-1">
                    <a href="{{ route('staff.history') }}" 
                       class="{{ request()->routeIs('staff.history') ? 'bg-slate-800 text-white border-l-4 border-primary-500 pl-3' : 'text-slate-400 hover:bg-slate-800/50 hover:text-white pl-4' }} group flex items-center py-3 text-sm font-bold rounded-r-2xl transition-all overflow-hidden"
                       title="Order History">
                        <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Order History</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    {{-- Logout Section --}}
    <div class="flex-shrink-0 flex bg-slate-900 pt-4 p-6 border-t border-slate-800 overflow-hidden">
        <form action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="submit" class="w-full group flex items-center px-4 py-3.5 text-sm font-bold text-slate-400 hover:bg-red-500/10 hover:text-red-400 rounded-2xl transition-all duration-300" title="Logout">
                <svg class="mr-3 h-5 w-5 text-slate-500 group-hover:text-red-400 transition-colors flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!sidebarCollapsed || mobileSidebarOpen" class="whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</div>
