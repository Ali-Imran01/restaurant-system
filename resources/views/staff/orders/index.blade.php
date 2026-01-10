@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-950">
    @include('staff.partials.sidebar')

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-bold text-white">Active Orders</h1>

                @if(session('success'))
                    <div class="mt-4 bg-green-900/30 border border-green-800 text-green-400 px-4 py-3 rounded-xl relative" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mt-8 space-y-6">
                    @forelse($orders as $order)
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                            <div class="px-6 py-4 bg-slate-800/50 border-b border-slate-800 flex justify-between items-center">
                                <div class="flex items-center">
                                    <span class="text-lg font-bold text-white mr-4">Table {{ $order->table->table_number }}</span>
                                    <span class="text-xs text-slate-400 mr-4">#{{ $order->id }} • {{ $order->created_at->diffForHumans() }}</span>
                                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider {{ $order->payment_method == 'cash' ? 'bg-emerald-900/50 text-emerald-400 border border-emerald-800' : 'bg-blue-900/50 text-blue-400 border border-blue-800' }}">
                                        {{ $order->payment_method }}
                                    </span>
                                </div>
                                <div>
                    <div>
                <a href="{{ route('staff.orders.edit', $order) }}" class="inline-flex items-center px-3 py-1.5 border border-slate-700 text-xs font-medium rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-all mr-2">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('staff.orders.print', $order) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-slate-700 text-xs font-medium rounded-lg text-slate-300 hover:bg-slate-800 hover:text-white transition-all mr-4">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print
                </a>
                <form action="{{ route('staff.orders.status', $order) }}" method="POST" class="inline-flex items-center">
                    @csrf
                    <select name="status" onchange="this.form.submit()" class="bg-slate-950 border-slate-800 text-slate-300 text-xs rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2">
                        <option value="waiting_payment" {{ $order->status == 'waiting_payment' ? 'selected' : '' }}>Waiting Payment</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>
            </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <ul class="divide-y divide-slate-800">
                                    @foreach($order->items as $item)
                                        <li class="py-3 flex justify-between">
                                            <div class="flex flex-col">
                                                <div class="flex items-center">
                                                    <span class="h-6 w-6 bg-slate-800 text-slate-300 flex items-center justify-center rounded text-xs font-bold mr-3">{{ $item->quantity }}x</span>
                                                    <span class="text-sm text-slate-200">{{ $item->menuItem->name }}</span>
                                                </div>
                                                @if($item->notes)
                                                    <p class="text-xs text-primary-400 mt-1 ml-9 italic">"{{ $item->notes }}"</p>
                                                @endif
                                            </div>
                                            <span class="text-sm text-slate-400">RM {{ number_format($item->subtotal, 2) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="mt-6 pt-6 border-t border-slate-800 flex justify-between items-center">
                                    <span class="text-sm font-medium text-slate-400">Total Amount</span>
                                    <span class="text-xl font-bold text-white">RM {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-12 text-center">
                            <p class="text-slate-400">No active orders at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
