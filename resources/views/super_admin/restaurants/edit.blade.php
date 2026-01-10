@extends('layouts.app')

@section('content')
<div class="flex bg-slate-50 min-h-screen pl-64">
    @include('super_admin.partials.sidebar')

    <div class="flex-1 p-10">
        <header class="mb-12">
            <a href="{{ route('super_admin.restaurants') }}" class="text-primary-600 text-sm font-bold flex items-center hover:text-primary-700 mb-4 transition-all">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to List
            </a>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Manage Venue</h1>
            <p class="text-slate-500 font-medium mt-1">Configure restaurant profiles and security credentials.</p>
        </header>

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
