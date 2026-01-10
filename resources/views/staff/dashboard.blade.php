@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-950">
    @include('staff.partials.sidebar')

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-bold text-white">Staff Dashboard</h1>
                
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Quick Stats -->
                    <div class="bg-slate-900 overflow-hidden shadow rounded-2xl border border-slate-800">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-primary-900/50 rounded-xl p-3">
                                    <svg class="h-6 w-6 text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-slate-400 truncate">Active Orders</dt>
                                        <dd class="text-2xl font-bold text-white">{{ $activeOrdersCount }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-800/50 px-6 py-3">
                            <a href="{{ route('staff.orders') }}" class="text-sm font-medium text-primary-400 hover:text-primary-300">View all orders</a>
                        </div>
                    </div>

                    <!-- Add more quick actions or stats as needed -->
                </div>

                <div class="mt-12">
                    <h2 class="text-lg font-medium text-white mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a href="{{ route('staff.orders') }}" class="flex items-center p-4 bg-slate-900 border border-slate-800 rounded-2xl hover:bg-slate-800 transition-colors group">
                            <div class="p-3 bg-green-900/30 rounded-xl group-hover:bg-green-900/50 transition-colors">
                                <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-white">Manage Orders</p>
                                <p class="text-xs text-slate-400">View and update status of active orders</p>
                            </div>
                        </a>

                        <a href="{{ route('staff.menu') }}" class="flex items-center p-4 bg-slate-900 border border-slate-800 rounded-2xl hover:bg-slate-800 transition-colors group">
                            <div class="p-3 bg-amber-900/30 rounded-xl group-hover:bg-amber-900/50 transition-colors">
                                <svg class="h-6 w-6 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-bold text-white">Stock Availability</p>
                                <p class="text-xs text-slate-400">Toggle items as sold out or available</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
