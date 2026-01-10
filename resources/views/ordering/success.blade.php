<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>Order Confirmed - {{ $order->table->restaurant->name }}</title>
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
<body class="h-full font-sans text-slate-900 antialiased flex flex-col items-center justify-center p-6">

    <div class="max-w-md w-full bg-white rounded-[40px] shadow-[0_20px_60px_rgb(0,0,0,0.08)] overflow-hidden text-center p-8 border border-slate-100 flex flex-col relative">
        {{-- Decorative Circles --}}
        <div class="absolute top-1/2 -left-3 w-6 h-6 bg-slate-50 rounded-full"></div>
        <div class="absolute top-1/2 -right-3 w-6 h-6 bg-slate-50 rounded-full"></div>

        <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl font-black text-slate-900 mb-2 tracking-tighter">Order Sent!</h1>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em] mb-8">Table {{ $order->table->table_number }} • #{{ $order->id }}</p>
        
        <div class="flex-1 border-t-2 border-dashed border-slate-100 py-8 text-left">
            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Order Details</h3>
            <ul class="space-y-4 mb-8">
                @foreach($order->items as $item)
                    <li class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-800">{{ $item->menuItem->name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $item->quantity }}x @ RM {{ number_format($item->price_at_order, 2) }}</p>
                        </div>
                        <span class="text-sm font-black text-slate-900">RM {{ number_format($item->subtotal, 2) }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="space-y-3 pt-6 border-t border-slate-100">
                <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <span>Subtotal</span>
                    <span class="text-slate-600">RM {{ number_format($order->total_amount / 1.06, 2) }}</span>
                </div>
                <div class="flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    <span>SST (6%)</span>
                    <span class="text-slate-600">RM {{ number_format($order->total_amount - ($order->total_amount / 1.06), 2) }}</span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-lg font-black text-slate-900">Total</span>
                    <span class="text-2xl font-black text-primary-500">RM {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="mt-8 space-y-4">
            <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6 text-center">
                <p class="text-[10px] font-black text-amber-500 uppercase tracking-[0.2em] mb-2 text-center">Payment Required</p>
                <p class="text-amber-900 font-black text-lg">Please Proceed to Counter</p>
            </div>

            <a href="{{ route('order.show', ['token' => $order->table->qr_token]) }}" class="group flex items-center justify-center w-full h-16 bg-slate-900 text-white rounded-[24px] font-black uppercase tracking-widest active:scale-95 transition-all shadow-xl shadow-slate-200">
                <span>Order More Items</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
    </div>

</body>
</html>
