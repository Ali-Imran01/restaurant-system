<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-slate-900 border-r border-slate-800">
        <div class="flex items-center h-16 flex-shrink-0 px-4 border-b border-slate-800">
            <a href="{{ route('staff.dashboard') }}" class="text-xl font-bold text-white">Staff Panel</a>
        </div>
        <div class="flex-1 flex flex-col overflow-y-auto pt-5 pb-4">
            <nav class="mt-2 flex-1 px-4 space-y-1">
                <a href="{{ route('staff.dashboard') }}" class="{{ request()->routeIs('staff.dashboard') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Dashboard
                </a>
                <a href="{{ route('staff.orders') }}" class="{{ request()->routeIs('staff.orders') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Active Orders
                </a>
                <a href="{{ route('staff.menu') }}" class="{{ request()->routeIs('staff.menu') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Menu Availability
                </a>
                <a href="{{ route('staff.history') }}" class="{{ request()->routeIs('staff.history') ? 'bg-slate-800 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Order History
                </a>
            </nav>
        </div>
        <div class="flex-shrink-0 flex border-t border-slate-800 p-4">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center text-slate-400 hover:text-red-400 text-sm font-medium px-3 py-2 rounded-xl hover:bg-red-900/20 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
