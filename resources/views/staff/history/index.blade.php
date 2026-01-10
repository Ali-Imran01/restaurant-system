@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('staff.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Order History</h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Reviewing Past Service Records</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-4 py-2 bg-slate-100 rounded-2xl text-slate-500 text-xs font-black uppercase tracking-wider">
                    {{ $orders->total() }} Total Records
                </span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50/50">
            <div class="max-w-7xl mx-auto">
                {{-- History Table --}}
                <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Order Ref</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Table</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Description</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">revenue</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Closed At</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest text-sr-only">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-slate-50/50 transition-colors group">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="text-sm font-black text-slate-950">#{{ $order->id }}</span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-slate-100 rounded-xl flex items-center justify-center text-[10px] font-black text-slate-500">
                                                {{ $order->table->table_number }}
                                            </div>
                                            <span class="text-xs font-bold text-slate-700">Table {{ $order->table->table_number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="max-w-xs">
                                            @foreach($order->items as $item)
                                                <p class="text-xs font-medium text-slate-600 truncate">{{ $item->quantity }}x {{ $item->menuItem->name }}</p>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="text-sm font-black text-primary-500">RM{{ number_format($order->total_amount, 2) }}</span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        @if($order->status === 'completed')
                                            <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-green-100">Success</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-50 text-red-600 rounded-full text-[9px] font-black uppercase tracking-widest border border-red-100">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $order->updated_at->format('d M y • H:i') }}</span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                        <a href="{{ route('staff.orders.print', $order) }}" target="_blank" class="p-3 bg-slate-50 text-slate-400 rounded-2xl hover:bg-primary-500 hover:text-white transition-all inline-flex items-center">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-8 py-20 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-400 text-sm font-medium">No historical transactions found yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
