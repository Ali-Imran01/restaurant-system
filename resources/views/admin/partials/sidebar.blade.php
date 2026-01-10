<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-white border-r border-slate-200">
        <div class="flex items-center h-16 flex-shrink-0 px-4 border-b border-slate-200">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-primary-600">RestoQR</a>
        </div>
        <div class="flex-1 flex flex-col overflow-y-auto pt-5 pb-4">
            <nav class="mt-2 flex-1 px-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Dashboard
                </a>
                <a href="{{ route('admin.customisation.edit') }}" class="{{ request()->routeIs('admin.customisation.*') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Customisation
                </a>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Categories
                </a>
                <a href="{{ route('menu_items.index') }}" class="{{ request()->routeIs('menu_items.*') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Menu Items
                </a>
                <a href="{{ route('tables.index') }}" class="{{ request()->routeIs('tables.*') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Table & QR
                </a>
                <a href="{{ route('staff.history') }}" class="{{ request()->routeIs('staff.history') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Orders
                </a>
                <a href="{{ route('staff.index') }}" class="{{ request()->routeIs('staff.*') ? 'bg-primary-50 text-primary-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center px-3 py-2 text-sm font-medium rounded-xl">
                    Staff Accounts
                </a>
            </nav>
        </div>
        <div class="flex-shrink-0 flex border-t border-slate-200 p-4">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center text-slate-600 hover:text-red-600 text-sm font-medium px-3 py-2 rounded-xl hover:bg-red-50 transition-colors">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
