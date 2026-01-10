@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('super_admin.partials.sidebar')


    <div class="flex-1 flex flex-col overflow-hidden min-h-0">
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
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Manage Venues</h1>
                    <p class="text-slate-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-0.5">Restaurant Control</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('super_admin.restaurants.create') }}" class="bg-indigo-600 text-white p-2.5 md:px-6 md:py-3 rounded-2xl font-black text-sm hover:bg-indigo-700 shadow-xl shadow-indigo-600/20 transition-all flex items-center">
                    <svg class="w-5 h-5 md:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden md:inline">Add Restaurant</span>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50 pb-8">

        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 font-bold rounded-2xl text-center">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto text-center">
                <table class="w-full">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest leading-10">Restaurant Details</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest leading-10">Stats</th>
                            <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest leading-10">Address</th>
                            <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest leading-10">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($restaurants as $restaurant)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-primary-100 rounded-2xl flex items-center justify-center text-primary-700 font-black text-lg mr-4">
                                        {{ strtoupper(substr($restaurant->name, 0, 1)) }}
                                    </div>
                                    <div class="text-left">
                                        <div class="text-sm font-bold text-slate-900">{{ $restaurant->name }}</div>
                                        <div class="text-[10px] font-medium text-slate-500 uppercase tracking-wider">ID: #{{ $restaurant->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex space-x-2">
                                    <span class="bg-slate-100 text-slate-600 text-[10px] font-black px-2.5 py-1 rounded-lg">{{ $restaurant->menu_items_count }} Items</span>
                                    <span class="bg-slate-100 text-slate-600 text-[10px] font-black px-2.5 py-1 rounded-lg">{{ $restaurant->tables_count }} Tables</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-left">
                                <span class="text-xs font-bold text-slate-500">{{ $restaurant->address ?: 'No address set' }}</span>
                            </td>
                            <td class="px-8 py-6 text-right flex justify-end space-x-2">
                                <a href="{{ route('super_admin.restaurants.edit', $restaurant) }}" class="p-3 bg-slate-100 text-slate-600 rounded-xl hover:bg-primary-600 hover:text-white transition-all inline-block group">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('super_admin.restaurants.destroy', $restaurant) }}" method="POST" onsubmit="return confirm('CRITICAL: This will permanently delete this restaurant and ALL associated menu items, tables, and order history. This cannot be undone. Proceed?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-600 hover:text-white transition-all inline-block group">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $restaurants->links() }}
        </div>
        </main>
    </div>
</div>
@endsection
