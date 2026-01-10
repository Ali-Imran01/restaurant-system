@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('super_admin.partials.sidebar')


    <div class="flex-1 flex flex-col overflow-hidden min-h-0 md:pl-64">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:px-8 shrink-0">
            <div class="flex items-center space-x-4">
                {{-- Toggle Sidebar Button (Desktop) --}}
                <button @click="toggleSidebar()" class="hidden md:flex w-10 h-10 bg-slate-50 rounded-xl items-center justify-center text-slate-400 hover:bg-primary-500 hover:text-white transition-all shadow-sm">
                    <svg class="w-6 h-6 sidebar-transition" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Hamburger Button (Mobile) --}}
                <button @click="mobileSidebarOpen = true" class="md:hidden w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20 text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <div>
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Platform Command</h1>
                    <p class="text-slate-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-0.5">Network Overview</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50 pb-8">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Total Restaurants -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl hover:shadow-primary-500/5 transition-all duration-300">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary-50 rounded-full blur-2xl group-hover:bg-primary-100 transition-colors"></div>
                <p class="text-slate-500 text-xs font-black uppercase tracking-widest mb-4">Total Restaurants</p>
                <h3 class="text-5xl font-black text-slate-900 leading-none">{{ $totalRestaurants }}</h3>
                <div class="mt-6 flex items-center text-primary-600 font-bold text-sm">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Live on system
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 relative overflow-hidden group hover:shadow-xl transition-all duration-300">
                <p class="text-slate-500 text-xs font-black uppercase tracking-widest mb-4">Transactions</p>
                <h3 class="text-5xl font-black text-slate-900 leading-none">{{ $totalOrders }}</h3>
                <div class="mt-6 flex items-center text-emerald-600 font-bold text-sm">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Processed successfully
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-slate-900 p-8 rounded-3xl shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary-600/20 rounded-full blur-2xl"></div>
                <p class="text-slate-400 text-xs font-black uppercase tracking-widest mb-4">Gross Revenue</p>
                <h3 class="text-5xl font-black text-white leading-none">RM {{ number_format($totalRevenue, 2) }}</h3>
                <div class="mt-6 flex items-center text-primary-400 font-bold text-sm">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Across all venues
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-xl font-black text-slate-900 tracking-tight text-center">Recent Restaurants</h2>
                <a href="{{ route('super_admin.restaurants') }}" class="text-primary-600 text-sm font-bold hover:text-primary-700 transition-colors">View All</a>
            </div>
            <div class="overflow-x-auto text-center">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Restaurant Name</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Items</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($restaurants as $restaurant)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <span class="text-sm font-bold text-slate-900">{{ $restaurant->name }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="bg-slate-100 text-slate-600 text-[10px] font-black px-2.5 py-1 rounded-lg">{{ $restaurant->menu_items_count }} Items</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="flex items-center text-xs font-bold text-emerald-600">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span>
                                    Active
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-xs font-bold text-slate-500">{{ $restaurant->created_at->format('M d, Y') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </main>
    </div>
</div>
@endsection
