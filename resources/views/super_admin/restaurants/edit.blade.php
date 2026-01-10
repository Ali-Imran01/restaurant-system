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
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Edit Venue</h1>
                    <p class="text-slate-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-0.5">{{ $restaurant->name }}</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50 pb-8">
            <div class="max-w-4xl mx-auto">

        <form action="{{ route('super_admin.restaurants.update', $restaurant) }}" method="POST" class="max-w-4xl space-y-8">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="owner_id" value="{{ $owner->id }}">

            <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-slate-100 flex flex-col md:flex-row gap-10">
                <!-- Left: Restaurant Details -->
                <div class="flex-1 space-y-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="p-2 bg-primary-100 text-primary-600 rounded-xl font-black text-xs">1</span>
                        <h2 class="text-lg font-black text-slate-900">Venue Profile</h2>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Restaurant Name</label>
                        <input type="text" name="name" value="{{ old('name', $restaurant->name) }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-primary-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Address</label>
                        <textarea name="address" rows="4" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-primary-500 transition-all">{{ old('address', $restaurant->address) }}</textarea>
                    </div>
                </div>

                <!-- Right: Owner Account -->
                <div class="flex-1 space-y-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="p-2 bg-amber-100 text-amber-600 rounded-xl font-black text-xs">2</span>
                        <h2 class="text-lg font-black text-slate-900">Owner Access</h2>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Name</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name', $owner->name) }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-amber-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Email (Username)</label>
                        <input type="email" name="owner_email" value="{{ old('owner_email', $owner->email) }}" required class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold focus:ring-2 focus:ring-amber-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Reset Password</label>
                        <input type="password" name="owner_password" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-amber-500 transition-all" placeholder="Leave blank to keep current">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="px-12 py-5 bg-slate-900 text-white font-black text-sm rounded-2xl hover:bg-black transition-all shadow-2xl active:scale-95">
                    Sync All Changes
                </button>
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
