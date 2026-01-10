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
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Platform Team</h1>
                    <p class="text-slate-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-0.5">Master Access</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50 pb-8">
            <div class="max-w-7xl mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            <!-- Team List -->
            <div class="lg:col-span-2 space-y-6">
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 font-bold rounded-2xl text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-red-50 border border-red-100 text-red-700 font-bold rounded-2xl text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-center">
                        <thead class="bg-slate-50 text-center">
                            <tr>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest leading-10">Administrator</th>
                                <th class="px-8 py-5 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest leading-10">Role</th>
                                <th class="px-8 py-5 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest leading-10">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-700 font-black text-sm mr-4">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="text-left">
                                            <div class="text-sm font-bold text-slate-900">{{ $user->name }}</div>
                                            <div class="text-xs font-medium text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-left">
                                    @if($user->email === 'admin@restoqr.com')
                                        <span class="bg-purple-100 text-purple-700 text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-tight">Primary Owner</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-600 text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-tight">Super Admin</span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right">
                                    @if($user->email !== 'admin@restoqr.com' && $user->id !== auth()->id())
                                    <form action="{{ route('super_admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Remove this administrator? They will lose all access to the platform.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Add Member Form -->
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 h-fit sticky top-10">
                <h2 class="text-xl font-black text-slate-900 tracking-tight mb-6">Add Team Member</h2>
                
                <form action="{{ route('super_admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Full Name</label>
                        <input type="text" name="name" required class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-primary-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Email Address</label>
                        <input type="email" name="email" required class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-primary-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Initial Password</label>
                        <input type="password" name="password" required class="w-full px-5 py-3.5 bg-slate-50 border-none rounded-2xl text-slate-900 font-bold placeholder-slate-300 focus:ring-2 focus:ring-primary-500 transition-all">
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary-600 text-white font-black text-sm rounded-2xl hover:bg-primary-700 transition-all shadow-lg shadow-primary-500/20 active:scale-95">
                        Grant Master Access
                    </button>
                </form>

                @if($errors->any())
                    <div class="mt-6 p-4 bg-red-50 rounded-2xl">
                        <ul class="text-[10px] font-bold text-red-600 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
