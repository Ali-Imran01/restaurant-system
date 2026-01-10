@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('staff.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Menu Availability</h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Quickly toggle items as available or sold out</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-4 py-2 bg-slate-100 rounded-2xl text-slate-500 text-xs font-black uppercase tracking-wider">
                    {{ $menuItems->count() }} Total Items
                </span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50/50">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-[24px] flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Menu Table --}}
                <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu Item</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Current Status</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest text-sr-only">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($menuItems as $item)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-slate-100 rounded-2xl overflow-hidden flex-shrink-0 border border-slate-200 shadow-sm">
                                                @if($item->image_url)
                                                    <img src="{{ $item->image_url }}" class="w-full h-full object-cover" alt="{{ $item->name }}">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-slate-50 text-slate-300">
                                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="text-sm font-black text-slate-950">{{ $item->name }}</p>
                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">ID: #{{ $item->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black uppercase tracking-wider border border-slate-200">
                                            {{ $item->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        @if($item->is_available)
                                            <div class="flex items-center space-x-2">
                                                <span class="w-2 h-2 bg-green-500 rounded-full shadow-[0_0_10px_rgba(34,197,94,0.5)]"></span>
                                                <span class="text-xs font-bold text-green-600 uppercase tracking-widest">In Stock</span>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2">
                                                <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                                                <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Sold Out</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                        <form action="{{ route('staff.menu.toggle', $item) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-6 py-2.5 {{ $item->is_available ? 'bg-red-50 text-red-600 hover:bg-red-500 hover:text-white border-red-100' : 'bg-green-50 text-green-600 hover:bg-green-500 hover:text-white border-green-100' }} rounded-2xl text-[10px] font-black uppercase tracking-widest border transition-all shadow-sm">
                                                Mark as {{ $item->is_available ? 'Sold Out' : 'Available' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-900 tracking-tight">No Items Registered</h3>
                                        <p class="text-slate-400 text-sm font-medium mt-1">Please ask your administrator to add items from the menu management panel.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
