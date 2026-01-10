@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50">
    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-bold text-slate-900">Admin Dashboard</h1>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-6">
                <!-- Dashboard Cards -->
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 p-5">
                        <dt class="text-sm font-medium text-slate-500 truncate">Total Orders Today</dt>
                        <dd class="mt-1 text-3xl font-bold text-slate-900">{{ $totalOrdersToday }}</dd>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 p-5">
                        <dt class="text-sm font-medium text-slate-500 truncate">Total Revenue</dt>
                        <dd class="mt-1 text-3xl font-bold text-slate-900">RM {{ number_format($totalRevenueToday, 2) }}</dd>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 p-5">
                        <dt class="text-sm font-medium text-slate-500 truncate">Total Tables</dt>
                        <dd class="mt-1 text-3xl font-bold text-slate-900">{{ $activeTablesCount }}</dd>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100 p-5">
                        <dt class="text-sm font-medium text-slate-500 truncate">Menu Items</dt>
                        <dd class="mt-1 text-3xl font-bold text-slate-900">{{ $menuItemsCount }}</dd>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
