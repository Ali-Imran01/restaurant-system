@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden" x-data="{ sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }">
    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        {{-- Header --}}
        <header class="bg-white border-b border-slate-200 z-10">
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button @click="toggleSidebar()" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors md:block hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <button @click="mobileSidebarOpen = true" class="p-2 rounded-xl hover:bg-slate-100 text-slate-500 transition-colors md:hidden">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Reservations</h1>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            <div class="max-w-7xl mx-auto space-y-8">
                
                {{-- Stats Summary --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Total Requests</span>
                        <div class="flex items-end justify-between">
                            <span class="text-3xl font-black text-slate-900">{{ $reservations->total() }}</span>
                            <div class="w-10 h-10 bg-primary-50 rounded-2xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor font-black"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Reservations Table --}}
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Customer</th>
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Date & Time</th>
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Guests</th>
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-5 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($reservations as $reservation)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-900 leading-none mb-1">{{ $reservation->customer_name }}</span>
                                            <span class="text-xs font-bold text-slate-400">{{ $reservation->customer_phone }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span class="font-black text-slate-700 leading-none mb-1">{{ $reservation->reservation_datetime->format('D, M d, Y') }}</span>
                                            <span class="text-xs font-bold text-primary-500">{{ $reservation->reservation_datetime->format('h:i A') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span class="inline-flex items-center justify-center px-3 py-1 bg-slate-100 rounded-full text-xs font-black text-slate-700">
                                            {{ $reservation->guest_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'confirmed' => 'bg-green-100 text-green-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                                'completed' => 'bg-slate-100 text-slate-700'
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $statusClasses[$reservation->status] }}">
                                            {{ $reservation->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <form action="{{ route('admin.reservations.status', $reservation) }}" method="POST" class="flex items-center space-x-2">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="text-xs font-black uppercase tracking-widest bg-slate-50 border-none rounded-xl focus:ring-primary-500/20 py-2 pl-3 pr-8">
                                                    @foreach(['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                                                        <option value="{{ $status }}" {{ $reservation->status === $status ? 'selected' : '' }}>{{ strtoupper($status) }}</option>
                                                    @endforeach
                                                </select>
                                            </form>
                                            
                                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-colors">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor font-black"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @if($reservation->notes)
                                <tr class="bg-slate-50/30">
                                    <td colspan="5" class="px-6 py-3 border-t-0">
                                        <div class="flex items-start space-x-2 text-xs font-bold text-slate-400">
                                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>
                                            <p>{{ $reservation->notes }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-[2rem] flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor font-black"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            </div>
                                            <p class="text-slate-400 font-bold">No reservations found.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Pagination --}}
                    @if($reservations->hasPages())
                    <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                        {{ $reservations->links() }}
                    </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
</div>
@endsection
