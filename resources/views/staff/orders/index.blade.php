@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('staff.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Active Orders</h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Grouped by Table for Efficient Service</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="px-4 py-2 bg-slate-100 rounded-2xl text-slate-500 text-xs font-black uppercase tracking-wider">
                    {{ $groupedOrders->count() }} Active Tables
                </span>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50/50">
            <div class="max-w-6xl mx-auto">
                @if(session('success'))
                    <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-[24px] flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse($groupedOrders as $tableId => $orders)
                        @php $firstOrder = $orders->first(); @endphp
                        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden flex flex-col transition-all hover:shadow-xl hover:shadow-primary-500/5 group">
                            {{-- Card Header --}}
                            <div class="p-8 pb-4 flex justify-between items-start border-b border-dashed border-slate-100">
                                <div>
                                    <h3 class="text-3xl font-black text-slate-900 tracking-tighter">Table {{ $firstOrder->table->table_number }}</h3>
                                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">{{ $orders->count() }} Sub-order(s) Active</p>
                                </div>
                                <div class="flex flex-col items-end space-y-2">
                                    <span class="px-4 py-1.5 bg-primary-50 text-primary-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-primary-100">
                                        Active Serving
                                    </span>
                                </div>
                            </div>

                            {{-- Detailed Items List --}}
                            <div class="flex-1 p-8 space-y-6">
                                @foreach($orders as $order)
                                    <div class="bg-slate-50/50 rounded-3xl p-6 border border-slate-100">
                                        <div class="flex justify-between items-center mb-4">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Order #{{ $order->id }}</span>
                                                <span class="text-[10px] text-slate-300">•</span>
                                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $order->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('staff.orders.edit', $order) }}" class="p-2.5 hover:bg-white rounded-xl text-slate-400 hover:text-primary-600 transition-all border border-transparent hover:border-slate-100 shadow-sm hover:shadow-md" title="Edit Item Quantities">
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('staff.orders.print', $order) }}" target="_blank" class="p-2.5 hover:bg-white rounded-xl text-slate-400 hover:text-primary-600 transition-all border border-transparent hover:border-slate-100 shadow-sm hover:shadow-md" title="Print Receipt">
                                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>

                                        <ul class="space-y-4">
                                            @foreach($order->items as $item)
                                                <li class="flex justify-between items-center bg-white p-4 rounded-2xl border border-slate-100 shadow-sm transition-all {{ $item->is_received ? 'opacity-50 ring-1 ring-emerald-100' : '' }}" id="item-{{ $item->id }}">
                                                    <div class="flex space-x-3 items-start">
                                                        <div class="h-8 w-8 shrink-0 bg-slate-50 border border-slate-100 flex items-center justify-center rounded-xl text-xs font-black text-slate-900 shadow-inner">
                                                            {{ $item->quantity }}x
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-800 tracking-tight {{ $item->is_received ? 'line-through' : '' }}">{{ $item->menuItem->name }}</p>
                                                            @if($item->notes)
                                                                <p class="text-[10px] font-black text-primary-500 uppercase tracking-widest mt-1 italic">"{{ $item->notes }}"</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4">
                                                        <span class="text-xs font-bold text-slate-400">RM{{ number_format($item->subtotal, 2) }}</span>
                                                        @if($order->status === 'preparing' || $order->status === 'paid')
                                                            <button 
                                                                onclick="toggleReceived({{ $item->id }})" 
                                                                class="receive-btn h-8 w-8 rounded-full border-2 flex items-center justify-center transition-all shadow-sm {{ $item->is_received ? 'bg-emerald-500 border-emerald-500 text-white' : 'bg-white border-slate-200 text-slate-300 hover:border-emerald-300 hover:text-emerald-500' }}"
                                                                title="Mark as Received"
                                                            >
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="mt-8 pt-6 border-t border-slate-200/50" id="order-actions-{{ $order->id }}">
                                            @if($order->status === 'waiting_payment')
                                                <div class="grid grid-cols-2 gap-4">
                                                    <button onclick="updateStatus({{ $order->id }}, 'paid')" class="bg-emerald-500 hover:bg-emerald-600 text-white font-black uppercase tracking-widest py-4 px-6 rounded-2xl transition-all shadow-lg shadow-emerald-200 flex items-center justify-center space-x-2">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <span>PAID</span>
                                                    </button>
                                                    <button onclick="updateStatus({{ $order->id }}, 'cancelled')" class="bg-white hover:bg-red-50 text-red-500 border-2 border-red-50 font-black uppercase tracking-widest py-4 px-6 rounded-2xl transition-all flex items-center justify-center space-x-2">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                        <span>CANCEL</span>
                                                    </button>
                                                </div>
                                            @elseif($order->status === 'paid')
                                                <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 flex flex-col items-center justify-center space-y-2">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="animate-spin rounded-full h-4 w-4 border-2 border-emerald-500 border-t-transparent"></div>
                                                        <span class="text-emerald-700 text-[11px] font-black uppercase tracking-widest">Processing Payment...</span>
                                                    </div>
                                                    <p class="text-emerald-600/60 text-[9px] font-bold uppercase">Transitioning to Preparing in 5s</p>
                                                </div>
                                                <script>setTimeout(() => updateStatus({{ $order->id }}, 'preparing'), 5000);</script>
                                            @elseif($order->status === 'preparing')
                                                <div class="flex flex-col space-y-4">
                                                    <button onclick="receiveAll({{ $order->id }})" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-black uppercase tracking-widest py-4 px-6 rounded-2xl transition-all shadow-lg shadow-blue-200 flex items-center justify-center space-x-2">
                                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        <span>RECEIVED ALL</span>
                                                    </button>
                                                    <button onclick="updateStatus({{ $order->id }}, 'cancelled')" class="text-red-400 hover:text-red-600 text-[10px] font-black uppercase tracking-[0.2em] transition-all">
                                                        Cancel Entire Order
                                                    </button>
                                                </div>
                                            @else
                                                <div class="bg-slate-100 rounded-2xl p-4 text-center">
                                                    <span class="text-slate-400 text-[11px] font-black uppercase tracking-widest">{{ $order->status }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Footer Summary --}}
                            @php $totalTableAmount = $orders->sum('total_amount'); @endphp
                            <div class="p-8 pt-4 bg-slate-900 flex justify-between items-center group-hover:bg-primary-500 transition-colors duration-500">
                                <div>
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest group-hover:text-primary-100 transition-colors">Combined Total</p>
                                    <h4 class="text-white text-2xl font-black mt-1">RM{{ number_format($totalTableAmount, 2) }}</h4>
                                </div>
                                <div class="bg-white/10 p-3 rounded-2xl backdrop-blur-md">
                                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 bg-white rounded-[40px] shadow-sm border border-slate-100 text-center flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">System Idle</h3>
                            <p class="text-slate-400 text-sm font-medium mt-1">No active table orders at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>
@push('scripts')
<script>
let lastOrderId = {{ $lastOrderId }};
const notificationSound = new Audio("data:audio/wav;base64,UklGRl9vT19XQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YV9vT18AZre3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3t7e3");

function checkUpdates() {
    fetch('{{ route('staff.orders.check') }}')
        .then(response => response.json())
        .then(data => {
            if (data.last_order_id > lastOrderId) {
                // New order detected!
                try {
                    notificationSound.play();
                } catch (e) { console.log('Audio play blocked'); }
                
                // Refresh to show the new order
                setTimeout(() => window.location.reload(), 500);
            }
        });
}

// Check every 10 seconds
setInterval(checkUpdates, 10000);

function updateStatus(orderId, status) {
    fetch(`/staff/orders/${orderId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}

function toggleReceived(itemId) {
    fetch(`/staff/order-items/${itemId}/received`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const itemElement = document.getElementById(`item-${itemId}`);
            const btn = itemElement.querySelector('.receive-btn');
            const nameText = itemElement.querySelector('p');
            
            if (data.is_received) {
                itemElement.classList.add('opacity-50', 'ring-1', 'ring-emerald-100');
                btn.classList.replace('bg-white', 'bg-emerald-500');
                btn.classList.replace('border-slate-200', 'border-emerald-500');
                btn.classList.replace('text-slate-300', 'text-white');
                nameText.classList.add('line-through');
            } else {
                itemElement.classList.remove('opacity-50', 'ring-1', 'ring-emerald-100');
                btn.classList.replace('bg-emerald-500', 'bg-white');
                btn.classList.replace('border-emerald-500', 'border-slate-200');
                btn.classList.replace('text-white', 'text-slate-300');
                nameText.classList.remove('line-through');
            }

            if (data.order_status === 'completed') {
                window.location.reload();
            }
        }
    });
}

function receiveAll(orderId) {
    fetch(`/staff/orders/${orderId}/receive-all`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.reload();
        }
    });
}
</script>
@endpush
@endsection
