@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50">
    @include('admin.partials.sidebar')

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-slate-900 sm:truncate">Restaurant Customisation</h2>
                    </div>
                </div>

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
                                    <button type="submit" class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-sm font-medium rounded-xl text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                                        Save Changes
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
