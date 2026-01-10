@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('staff.partials.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 shrink-0">
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Staff Operations</h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Live Service Monitoring</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-primary-50 px-4 py-2 rounded-2xl border border-primary-100 flex items-center space-x-2">
                    <span class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                    <span class="text-primary-700 text-xs font-black uppercase tracking-wider">System Live</span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 bg-slate-50/50">
            <div class="max-w-7xl mx-auto">
                {{-- Quick Stats Row --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-white rounded-[32px] p-6 shadow-sm border border-slate-100 flex items-center justify-between">
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider italic">Active Orders</p>
                            <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $activeOrdersCount }}</h3>
                        </div>
                        <div class="w-14 h-14 bg-primary-50 rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>

                    <div class="md:col-span-2 bg-slate-900 rounded-[32px] p-6 shadow-2xl flex flex-col justify-center">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-white text-lg font-black tracking-tight">Need Help?</h4>
                                <p class="text-slate-400 text-sm font-medium">Quick link to customer support or table management.</p>
                            </div>
                            <a href="{{ route('staff.orders') }}" class="px-6 py-3 bg-white text-slate-900 rounded-2xl font-black text-sm hover:bg-primary-400 hover:text-white transition-all shadow-lg">
                                All Active Orders
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Quick Actions --}}
                    <div class="bg-white rounded-[40px] p-8 shadow-sm border border-slate-100">
                        <h3 class="text-xl font-black text-slate-900 tracking-tight mb-6">Service Controls</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <a href="{{ route('staff.orders') }}" class="group flex items-center p-6 bg-slate-50 border border-slate-100 rounded-[28px] hover:bg-white hover:shadow-xl hover:shadow-primary-500/5 transition-all">
                                <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center group-hover:bg-green-500 transition-colors">
                                    <svg class="w-7 h-7 text-green-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-6">
                                    <h4 class="text-lg font-black text-slate-900 tracking-tight">Order Queue</h4>
                                    <p class="text-slate-500 text-sm font-medium">Manage incoming customer requests.</p>
                                </div>
                            </a>

                            <a href="{{ route('staff.menu') }}" class="group flex items-center p-6 bg-slate-50 border border-slate-100 rounded-[28px] hover:bg-white hover:shadow-xl hover:shadow-primary-500/5 transition-all">
                                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center group-hover:bg-amber-500 transition-colors">
                                    <svg class="w-7 h-7 text-amber-500 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="ml-6">
                                    <h4 class="text-lg font-black text-slate-900 tracking-tight">Stock Toggle</h4>
                                    <p class="text-slate-500 text-sm font-medium">Update menu item availability.</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- Staff Info Box --}}
                    <div class="bg-primary-600 rounded-[40px] p-8 shadow-xl relative overflow-hidden flex flex-col justify-between">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-primary-500 rounded-full -mr-20 -mt-20 opacity-50 blur-3xl"></div>
                        <div class="relative z-10">
                            <h3 class="text-white text-2xl font-black tracking-tight leading-tight">Welcome to the <br>Shift Dashboard</h3>
                            <p class="text-primary-100 text-sm font-medium mt-4 max-w-[250px]">
                                Use the sidebar to navigate records or go straight to Active Orders to manage customers.
                            </p>
                        </div>
                        <div class="relative z-10 pt-8 flex items-center space-x-4">
                           <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30">
                               <span class="text-white font-black uppercase text-xl">{{ substr(Auth::user()->name, 0, 1) }}</span>
                           </div>
                           <div>
                               <p class="text-white text-sm font-black">{{ Auth::user()->name }}</p>
                               <p class="text-primary-200 text-xs font-bold uppercase tracking-widest">Signed In</p>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
