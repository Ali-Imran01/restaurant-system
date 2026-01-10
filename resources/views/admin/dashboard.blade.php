@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Executive Dashboard</h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Real-time Performance Metrics</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-primary-50 px-4 py-2 rounded-2xl border border-primary-100">
                    <span class="text-primary-700 text-xs font-black uppercase tracking-wider">{{ now()->format('D, d M Y') }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50/50">
            <div class="max-w-7xl mx-auto">
                <!-- Top Metric Cards -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-10">
                    {{-- Card 1 --}}
                    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-primary-500/5 transition-all group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-primary-50 rounded-2xl group-hover:bg-primary-500 transition-colors">
                                <svg class="w-6 h-6 text-primary-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-black text-green-500 uppercase tracking-widest">Today</span>
                        </div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Orders</p>
                        <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $totalOrdersToday }}</h3>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-primary-500/5 transition-all group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-green-50 rounded-2xl group-hover:bg-green-500 transition-colors">
                                <svg class="w-6 h-6 text-green-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-black text-green-500 uppercase tracking-widest">Revenue</span>
                        </div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Today's Revenue</p>
                        <h3 class="text-3xl font-black text-slate-900 mt-1">RM{{ number_format($totalRevenueToday, 2) }}</h3>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-primary-500/5 transition-all group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-50 rounded-2xl group-hover:bg-blue-500 transition-colors">
                                <svg class="w-6 h-6 text-blue-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Infrastructure</span>
                        </div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Active Tables</p>
                        <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $activeTablesCount }}</h3>
                    </div>

                    {{-- Card 4 --}}
                    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-primary-500/5 transition-all group">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-amber-50 rounded-2xl group-hover:bg-amber-500 transition-colors">
                                <svg class="w-6 h-6 text-amber-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Inventory</span>
                        </div>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Menu Items</p>
                        <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $menuItemsCount }}</h3>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Main Chart --}}
                    <div class="lg:col-span-2 bg-white rounded-[40px] p-8 shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">Sales Trends</h3>
                                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Last 7 Days Revenue</p>
                            </div>
                        </div>
                        <div class="h-[300px] w-full">
                            <canvas id="salesTrendsChart"></canvas>
                        </div>
                    </div>

                    {{-- Top Items Chart --}}
                    <div class="bg-white rounded-[40px] p-8 shadow-sm border border-slate-100">
                        <div class="mb-8">
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Top Sellers</h3>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest">Most Popular Items</p>
                        </div>
                        <div class="space-y-6">
                            @forelse($topItems as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center font-bold text-slate-500 overflow-hidden">
                                            @if($item->menuItem->image_url)
                                                <img src="{{ $item->menuItem->image_url }}" class="w-full h-full object-cover">
                                            @else
                                                {{ substr($item->menuItem->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 tracking-tight">{{ $item->menuItem->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">RM{{ number_format($item->menuItem->price, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-black text-primary-500">{{ $item->total_quantity }}</p>
                                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Sold</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-400 text-sm italic">No sales data yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

{{-- Chart.js Script --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesTrendsChart').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(14, 165, 233, 0.2)');
    gradient.addColorStop(1, 'rgba(14, 165, 233, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json(collect($salesData)->pluck('date')),
            datasets: [{
                label: 'Revenue (RM)',
                data: @json(collect($salesData)->pluck('revenue')),
                borderColor: '#0ea5e9',
                borderWidth: 4,
                fill: true,
                backgroundColor: gradient,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0ea5e9',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { size: 10, weight: 'bold' },
                    bodyFont: { size: 14, weight: 'black' },
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'RM ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true,
                        color: 'rgba(0,0,0,0.03)'
                    },
                    ticks: {
                        font: { size: 10, weight: 'bold' },
                        color: '#94a3b8'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { size: 10, weight: 'bold' },
                        color: '#94a3b8'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
