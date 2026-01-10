@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-950">
    @include('staff.partials.sidebar')

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <h1 class="text-2xl font-bold text-white">Menu Availability</h1>
                <p class="text-slate-400 mt-1 text-sm">Quickly toggle items as available or sold out.</p>

                @if(session('success'))
                    <div class="mt-4 bg-green-900/30 border border-green-800 text-green-400 px-4 py-3 rounded-xl relative" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mt-8 overflow-hidden shadow ring-1 ring-slate-800 sm:rounded-2xl bg-slate-900">
                    <table class="min-w-full divide-y divide-slate-800">
                        <thead class="bg-slate-800/50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-white sm:pl-6">Item</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Category</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-white">Status</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 text-right">
                                    <span class="sr-only">Toggle</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 bg-slate-900">
                            @foreach($menuItems as $item)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0 bg-slate-800 rounded-lg flex items-center justify-center overflow-hidden">
                                                @if($item->image_url)
                                                    <img class="h-10 w-10 object-cover" src="{{ $item->image_url }}" alt="">
                                                @else
                                                    <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="ml-4 font-medium text-white">{{ $item->name }}</div>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-400">
                                        {{ $item->category->name }}
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $item->is_available ? 'bg-green-900 text-green-300' : 'bg-red-900 text-red-300' }}">
                                            {{ $item->is_available ? 'Available' : 'Sold Out' }}
                                        </span>
                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <form action="{{ route('staff.menu.toggle', $item) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="{{ $item->is_available ? 'text-red-400 hover:text-red-300' : 'text-green-400 hover:text-green-300' }}">
                                                Mark as {{ $item->is_available ? 'Sold Out' : 'Available' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
