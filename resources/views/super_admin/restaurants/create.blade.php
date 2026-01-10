@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('super_admin.partials.sidebar')


    <div class="flex-1 flex flex-col overflow-hidden min-h-0">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:px-8 shrink-0">
            <div class="flex items-center space-x-4">
                {{-- Toggle Sidebar Button (Desktop) --}}
                <button @click="toggleSidebar()" class="hidden md:flex w-10 h-10 bg-slate-50 rounded-xl items-center justify-center text-slate-400 hover:bg-primary-500 hover:text-white transition-all shadow-sm">
                    <svg class="w-6 h-6 sidebar-transition" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Hamburger Button (Mobile) --}}
                <button @click="mobileSidebarOpen = true" class="md:hidden w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20 text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <div>
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Onboard Restaurant</h1>
                    <p class="text-slate-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-0.5">System Initialization</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50 pb-8">
            <div class="max-w-4xl mx-auto">

        <form action="{{ route('super_admin.restaurants.store') }}" method="POST" class="max-w-4xl space-y-8">
            @csrf
            
            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Restaurant Section -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="p-2 bg-primary-100 text-primary-600 rounded-xl font-black text-xs">1</span>
                            <h2 class="text-lg font-black text-slate-900">Venue Details</h2>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Restaurant Name</label>
                            <input type="text" name="name" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-primary-500 transition-all" placeholder="e.g. Pizza Palace">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Address</label>
                            <input type="text" name="address" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-primary-500 transition-all" placeholder="e.g. 123 Food St.">
                        </div>
                    </div>

                    <!-- Owner Section -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <span class="p-2 bg-amber-100 text-amber-600 rounded-xl font-black text-xs">2</span>
                            <h2 class="text-lg font-black text-slate-900">Owner Account</h2>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Owner Name</label>
                            <input type="text" name="owner_name" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-amber-500 transition-all" placeholder="e.g. John Doe">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Owner Email</label>
                            <input type="email" name="owner_email" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-amber-500 transition-all" placeholder="owner@email.com">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Initial Password</label>
                            <input type="password" name="owner_password" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-amber-500 transition-all" placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-between p-6 bg-slate-50 rounded-3xl border border-slate-100">
                    <div class="flex items-center text-slate-500 text-sm font-medium">
                        <svg class="w-5 h-5 mr-2 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        Both records will be created simultaneously.
                    </div>
                    <button type="submit" class="px-10 py-4 bg-slate-900 text-white font-black text-sm rounded-2xl hover:bg-black transition-all shadow-xl active:scale-95">
                        Initialize System
                    </button>
                </div>
            </div>
        </form>

        @if($errors->any())
            <div class="mt-8 max-w-4xl p-6 bg-red-50 rounded-2xl border border-red-100">
                <ul class="list-disc list-inside text-red-600 text-sm font-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@endsection
