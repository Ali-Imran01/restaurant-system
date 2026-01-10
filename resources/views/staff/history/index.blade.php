@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-950">
    @include('staff.partials.sidebar')

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-bold text-white">Order History</h1>
                <p class="text-slate-400 mt-1 text-sm">Review past transactions and cancelled orders.</p>

                <div class="mt-8 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border border-slate-800 sm:rounded-2xl bg-slate-900">
                                <table class="min-w-full divide-y divide-slate-800">
                                    <thead class="bg-slate-800/50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-widest">Order ID</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-widest">Table</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-widest">Items</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-widest">Total</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-widest">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-widest">Date</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Print</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-800">
                                        @forelse($orders as $order)
                                            <tr class="hover:bg-slate-800/50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">
                                                    #{{ $order->id }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                                                    Table {{ $order->table->table_number }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-slate-400">
                                                    <div class="max-w-xs">
                                                        @foreach($order->items as $item)
                                                            <div class="flex justify-between">
                                                                <span>{{ $item->quantity }}x {{ $item->menuItem->name }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-primary-400">
                                                    RM {{ number_format($order->total_amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status === 'completed' ? 'bg-green-900/50 text-green-400' : 'bg-red-900/50 text-red-400' }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                                    {{ $order->updated_at->format('d M Y, H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('staff.orders.print', $order) }}" target="_blank" class="text-primary-400 hover:text-primary-300">Print</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="px-6 py-10 text-center text-slate-500 italic">
                                                    No historical orders found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
