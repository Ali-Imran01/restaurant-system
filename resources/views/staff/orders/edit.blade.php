@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-950">
    @include('staff.partials.sidebar')

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center">
                        <a href="{{ route('staff.orders') }}" class="mr-4 text-slate-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-white">Edit Order #{{ $order->id }} - Table {{ $order->table->table_number }}</h1>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Current Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden">
                            <form action="{{ route('staff.orders.update', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="p-6">
                                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Order Items</h3>
                                    <div class="space-y-4" id="order-items-container">
                                        @foreach($order->items as $item)
                                            <div class="flex flex-col bg-slate-800/50 rounded-xl border border-slate-700 overflow-hidden" id="item-row-{{ $item->menu_item_id }}">
                                                <div class="flex items-center justify-between p-4 border-b border-slate-700/50">
                                                    <div class="flex-1">
                                                        <h4 class="font-bold text-white">{{ $item->menuItem->name }}</h4>
                                                        <p class="text-xs text-slate-400">RM {{ number_format($item->menuItem->price, 2) }}</p>
                                                    </div>
                                                    <div class="flex items-center space-x-4">
                                                        <div class="flex items-center bg-slate-950 rounded-lg border border-slate-800 p-1">
                                                            <button type="button" onclick="decrementQty({{ $item->menu_item_id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white">-</button>
                                                            <input type="number" name="items[{{ $item->menu_item_id }}][quantity]" id="qty-{{ $item->menu_item_id }}" value="{{ $item->quantity }}" class="w-12 bg-transparent text-center text-white border-0 focus:ring-0 text-sm font-bold p-0" min="0">
                                                            <button type="button" onclick="incrementQty({{ $item->menu_item_id }})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white">+</button>
                                                        </div>
                                                        <button type="button" onclick="removeItem({{ $item->menu_item_id }})" class="text-red-500 hover:text-red-400">
                                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="px-4 py-2 bg-slate-900/30">
                                                    <input type="text" name="items[{{ $item->menu_item_id }}][notes]" value="{{ $item->notes }}" placeholder="Notes (e.g. no spicy)" class="w-full bg-transparent border-0 focus:ring-0 text-xs text-slate-400 italic p-0">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-8 pt-6 border-t border-slate-800 flex justify-between items-center">
                                        <div class="text-slate-400">
                                            <p class="text-sm font-bold">Total Amount</p>
                                        </div>
                                        <div class="text-2xl font-bold text-white">
                                            RM <span id="display-total">{{ number_format($order->total_amount, 2) }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <button type="submit" class="w-full bg-primary-600 text-white h-14 rounded-xl font-bold hover:bg-primary-700 shadow-lg shadow-primary-900/20 transition-all">
                                            Save Changes & Update Total
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Add More Items -->
                    <div class="lg:col-span-1">
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Add Items</h3>
                            <div class="relative mb-6">
                                <input type="text" id="menu-search" placeholder="Search menu..." class="w-full bg-slate-950 border-slate-800 text-white rounded-xl text-sm p-3 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="space-y-2 max-h-[500px] overflow-y-auto no-scrollbar" id="menu-items-list">
                                @foreach($menuItems as $menuItem)
                                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-800/50 cursor-pointer transition-all border border-transparent hover:border-slate-700" onclick="addNewItem({{ $menuItem->id }}, '{{ addslashes($menuItem->name) }}', {{ $menuItem->price }})">
                                        <div>
                                            <p class="text-sm font-bold text-white">{{ $menuItem->name }}</p>
                                            <p class="text-xs text-slate-500">RM {{ number_format($menuItem->price, 2) }}</p>
                                        </div>
                                        <div class="text-primary-500">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    function incrementQty(id) {
        const input = document.getElementById('qty-' + id);
        input.value = parseInt(input.value) + 1;
    }

    function decrementQty(id) {
        const input = document.getElementById('qty-' + id);
        if (parseInt(input.value) > 0) {
            input.value = parseInt(input.value) - 1;
        }
    }

    function removeItem(id) {
        const row = document.getElementById('item-row-' + id);
        const input = document.getElementById('qty-' + id);
        input.value = 0;
        row.style.opacity = '0.5';
        row.classList.add('grayscale');
    }

    function addNewItem(id, name, price) {
        const container = document.getElementById('order-items-container');
        const existingRow = document.getElementById('item-row-' + id);

        if (existingRow) {
            existingRow.style.opacity = '1';
            existingRow.classList.remove('grayscale');
            incrementQty(id);
            return;
        }

        const html = `
            <div class="flex flex-col bg-slate-800/50 rounded-xl border border-slate-700 overflow-hidden animate-in fade-in slide-in-from-left-4 duration-300" id="item-row-${id}">
                <div class="flex items-center justify-between p-4 border-b border-slate-700/50">
                    <div class="flex-1">
                        <h4 class="font-bold text-white">${name}</h4>
                        <p class="text-xs text-slate-400">RM ${price.toFixed(2)}</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center bg-slate-950 rounded-lg border border-slate-800 p-1">
                            <button type="button" onclick="decrementQty(${id})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white">-</button>
                            <input type="number" name="items[${id}][quantity]" id="qty-${id}" value="1" class="w-12 bg-transparent text-center text-white border-0 focus:ring-0 text-sm font-bold p-0" min="0">
                            <button type="button" onclick="incrementQty(${id})" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-white">+</button>
                        </div>
                        <button type="button" onclick="removeItem(${id})" class="text-red-500 hover:text-red-400">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="px-4 py-2 bg-slate-900/30">
                    <input type="text" name="items[${id}][notes]" value="" placeholder="Notes (e.g. no spicy)" class="w-full bg-transparent border-0 focus:ring-0 text-xs text-slate-400 italic p-0">
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    document.getElementById('menu-search').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        const items = document.querySelectorAll('#menu-items-list > div');
        
        items.forEach(item => {
            const name = item.querySelector('p').innerText.toLowerCase();
            if (name.includes(term)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
</style>
@endsection
