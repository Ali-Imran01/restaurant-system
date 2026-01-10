<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ $restaurant->name }} - Brand Hub</title>
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
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        @keyframes slideUp {
            from { transform: translateY(40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-up { animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
    </style>
</head>
<body class="font-sans text-slate-900 antialiased selection:bg-primary-100 overflow-x-hidden">
    
    {{-- Hero Section --}}
    <section class="relative min-h-[90vh] flex flex-col items-center justify-center px-4 overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 bg-slate-50">
            <div class="absolute inset-0 bg-[radial-gradient(#f97316_1px,transparent_1px)] [background-size:32px_32px] opacity-[0.05]"></div>
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary-200/20 rounded-full blur-[120px]"></div>
            <div class="absolute -bottom-[10%] -right-[10%] w-[50%] h-[50%] bg-primary-100/30 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative w-full max-w-4xl mx-auto text-center space-y-12 py-20">
            {{-- Branding --}}
            <div class="space-y-6 animate-slide-up" style="animation-delay: 0.1s">
                @if($restaurant->logo)
                    <img src="{{ asset('storage/' . $restaurant->logo) }}" class="h-24 w-auto mx-auto mb-8 rounded-[2rem] shadow-2xl border-4 border-white rotate-3" alt="Logo">
                @else
                    <div class="w-24 h-24 bg-primary-500 rounded-[2rem] mx-auto mb-8 flex items-center justify-center shadow-2xl shadow-primary-500/30 -rotate-3">
                        <span class="text-white text-5xl font-black italic">R</span>
                    </div>
                @endif
                <h1 class="text-5xl md:text-7xl font-black tracking-tight text-slate-950 leading-[1.1]">
                    Experience <span class="text-primary-500 italic">{{ $restaurant->name }}</span>
                </h1>
                <p class="text-lg md:text-xl font-medium text-slate-500 max-w-xl mx-auto leading-relaxed">
                    {{ $restaurant->address ?? 'Welcome to an exquisite dining journey. Book your table or explore our digital menu today.' }}
                </p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 animate-slide-up" style="animation-delay: 0.3s">
                <a href="{{ route('public.reservation', $restaurant->slug ?? $restaurant->id) }}" 
                   class="w-full sm:w-auto px-10 py-5 bg-slate-950 text-white font-black uppercase tracking-widest rounded-3xl shadow-2xl shadow-slate-900/20 hover:scale-105 active:scale-95 transition-all duration-300 flex items-center justify-center space-x-3 group">
                    <span>Book a Table</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor font-black"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </a>
                
                <a href="#" class="w-full sm:w-auto px-10 py-5 bg-white text-slate-950 font-black uppercase tracking-widest rounded-3xl shadow-xl shadow-slate-200 border border-slate-100 hover:bg-slate-50 active:scale-95 transition-all duration-300">
                    Browse Menu
                </a>
            </div>
            
            @if($restaurant->external_website_url)
                <div class="animate-slide-up" style="animation-delay: 0.5s">
                    <a href="{{ $restaurant->external_website_url }}" class="text-sm font-black text-slate-400 hover:text-primary-500 transition-colors uppercase tracking-[0.2em] flex items-center justify-center space-x-2">
                        <span>Visit Main Website</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-12 px-6 border-t border-slate-100 text-center">
        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">Powered by RestoQR Protocol</p>
    </footer>

</body>
</html>
