<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Book a Table - {{ $restaurant->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        }
                    },
                    fontFamily: { sans: ['Outfit', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="font-sans text-slate-900 antialiased selection:bg-primary-100">
    <div class="min-h-screen flex flex-col items-center justify-start px-4 py-8 md:py-12 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px]">
        
        <div class="w-full max-w-md">
            {{-- Logo & Brand --}}
            <div class="text-center mb-8">
                @if($restaurant->logo)
                    <img src="{{ asset('storage/' . $restaurant->logo) }}" class="h-16 w-auto mx-auto mb-4 rounded-2xl shadow-lg border-2 border-white" alt="Logo">
                @else
                    <div class="w-16 h-16 bg-primary-500 rounded-3xl mx-auto mb-4 flex items-center justify-center shadow-xl shadow-primary-500/20 transform -rotate-6">
                        <span class="text-white text-3xl font-black italic">R</span>
                    </div>
                @endif
                <h1 class="text-3xl font-black tracking-tight text-slate-900">{{ $restaurant->name }}</h1>
                <p class="text-slate-500 font-medium mt-1">Reserve your table experience</p>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-[2rem] mb-8 shadow-sm animate-fade-in flex items-center">
                    <svg class="w-6 h-6 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="bg-white/80 backdrop-blur-xl border border-white shadow-2xl shadow-slate-200/50 rounded-[2.5rem] p-8 md:p-10">
                <form action="{{ route('public.reservation.store', $restaurant->slug ?? $restaurant->id) }}" method="POST" class="space-y-6">
                    @csrf
                    
                    {{-- Name --}}
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Your Name</label>
                        <input type="text" name="customer_name" required 
                               class="w-full px-5 py-4 bg-slate-50 border-transparent focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 rounded-2xl transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" 
                               placeholder="e.g. John Doe">
                        @error('customer_name') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Phone Number</label>
                        <input type="tel" name="customer_phone" required 
                               class="w-full px-5 py-4 bg-slate-50 border-transparent focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 rounded-2xl transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300" 
                               placeholder="+1 (555) 000-0000">
                        @error('customer_phone') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Date & Time --}}
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Date & Time</label>
                            <input type="datetime-local" name="reservation_datetime" required 
                                   class="w-full px-5 py-4 bg-slate-50 border-transparent focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 rounded-2xl transition-all duration-300 font-bold text-slate-700" 
                                   min="{{ date('Y-m-d\TH:i') }}">
                            @error('reservation_datetime') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Guests --}}
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Guests</label>
                            <select name="guest_count" required 
                                    class="w-full px-5 py-4 bg-slate-50 border-transparent focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 rounded-2xl transition-all duration-300 font-bold text-slate-700">
                                @for($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ Str::plural('Guest', $i) }}</option>
                                @endfor
                            </select>
                            @error('guest_count') <p class="mt-1 text-xs text-red-500 font-bold ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Special Requests</label>
                        <textarea name="notes" rows="3" 
                                  class="w-full px-5 py-4 bg-slate-50 border-transparent focus:border-primary-500 focus:bg-white focus:ring-4 focus:ring-primary-500/10 rounded-2xl transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300"
                                  placeholder="e.g. Birthday celebration, window seat..."></textarea>
                    </div>

                    {{-- Submit --}}
                    <button type="submit" 
                            class="w-full py-5 bg-primary-500 hover:bg-primary-600 text-white font-black uppercase tracking-widest rounded-3xl shadow-xl shadow-primary-500/30 active:scale-[0.98] transition-all duration-300 flex items-center justify-center space-x-2">
                        <span>Confirm Booking</span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor font-black"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </button>
                </form>
            </div>

            {{-- Footer Links --}}
            <div class="text-center mt-10 space-y-4">
                @if($restaurant->external_website_url)
                    <a href="{{ $restaurant->external_website_url }}" class="text-sm font-black text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-widest flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c0-5.051-4.049-9-9-9" /></svg>
                        <span>Visit Website</span>
                    </a>
                @endif
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Powered by RestoQR</p>
            </div>
        </div>
    </div>
</body>
</html>
