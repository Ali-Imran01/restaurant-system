@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('admin.partials.sidebar')


    <div class="flex-1 flex flex-col overflow-hidden min-h-0">
        {{-- Header --}}
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 md:px-8 shrink-0">
            <div class="flex items-center space-x-4">
                {{-- Hamburger Button (Mobile) --}}
                <button @click="mobileSidebarOpen = true" class="md:hidden w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20 text-white flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <a href="{{ route('admin.dashboard') }}" class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400 hover:bg-primary-500 hover:text-white transition-all shadow-sm">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Identity Suite</h1>
                    <p class="text-slate-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-0.5">Restaurant Profile</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50 pb-8">
            <div class="max-w-7xl mx-auto">

                @if(session('success'))
                    <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
                    <!-- Settings Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 overflow-hidden">
                            <form action="{{ route('admin.customisation.update') }}" method="POST" class="p-8 space-y-6">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700">Restaurant Name</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" value="{{ old('name', $restaurant->name) }}" required class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-3 border">
                                    </div>
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="slug" class="block text-sm font-medium text-slate-700">URL Slug</label>
                                        <div class="mt-1 flex rounded-xl shadow-sm">
                                            <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-slate-200 bg-slate-50 text-slate-500 text-xs font-bold">restoqr.com/v/</span>
                                            <input type="text" name="slug" id="slug" value="{{ old('slug', $restaurant->slug) }}" class="flex-1 block w-full rounded-none rounded-r-xl border-slate-200 focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-3 border">
                                        </div>
                                        <p class="mt-1 text-[10px] text-slate-400">Used for your public Brand Hub and Booking link.</p>
                                        @error('slug') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <div>
                                        <label for="external_website_url" class="block text-sm font-medium text-slate-700">External Website URL</label>
                                        <div class="mt-1">
                                            <input type="url" name="external_website_url" id="external_website_url" value="{{ old('external_website_url', $restaurant->external_website_url) }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-3 border" placeholder="https://yourwebsite.com">
                                        </div>
                                        @error('external_website_url') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                <hr class="border-slate-100">

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-sm font-bold text-slate-900 leading-none">Public Brand Hub</h3>
                                            <p class="text-xs text-slate-500 mt-1">Enable a beautiful landing page for your restaurant.</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="show_public_profile" value="1" {{ old('show_public_profile', $restaurant->show_public_profile) ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-slate-700">Address</label>
                                    <div class="mt-1">
                                        <textarea id="address" name="address" rows="3" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-3 border">{{ old('address', $restaurant->address) }}</textarea>
                                    </div>
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="logo" class="block text-sm font-medium text-slate-700">Logo URL</label>
                                    <div class="mt-1">
                                        <input type="url" name="logo" id="logo" value="{{ old('logo', $restaurant->logo) }}" class="block w-full rounded-xl border-slate-200 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm p-3 border" placeholder="https://example.com/logo.png">
                                    </div>
                                    @error('logo')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full inline-flex justify-center py-4 px-4 border border-transparent shadow-sm text-sm font-black uppercase tracking-widest rounded-xl text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                                        Save All Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Preview Card -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-xl shadow-slate-200/50 rounded-2xl border border-slate-100 p-6 flex flex-col items-center text-center">
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Logo Preview</h3>
                            <div class="w-32 h-32 bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden mb-4">
                                @if($restaurant->logo)
                                    <img src="{{ $restaurant->logo }}" class="w-full h-full object-contain" alt="Logo Preview">
                                @else
                                    <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                            <p class="text-sm text-slate-500">This logo will appear on the customer's mobile menu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
