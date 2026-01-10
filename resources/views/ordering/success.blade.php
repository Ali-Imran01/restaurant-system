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

    <div class="max-w-md w-full bg-white rounded-[32px] shadow-2xl shadow-slate-200 overflow-hidden text-center p-8">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-slate-900 mb-2">Order Confirmed!</h1>
        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 mb-6">
            <p class="text-amber-800 font-bold text-lg mb-1">Please pay at the counter</p>
            <p class="text-amber-600 text-sm italic">Show your order ID #{{ $order->id }} to the cashier</p>
        </div>
        <p class="text-slate-500 mb-8 font-medium">We've received your order for Table {{ $order->table->table_number }}. Please wait while we prepare your food.</p>

        <div class="bg-slate-50 rounded-2xl p-6 text-left mb-8">
            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4">Order Summary #{{ $order->id }}</h3>
            <ul class="space-y-3">
                @foreach($order->items as $item)
                    <li class="flex justify-between text-sm">
                        <span class="text-slate-600 font-medium">{{ $item->quantity }}x {{ $item->menuItem->name }}</span>
                        <span class="text-slate-900 font-bold">RM {{ number_format($item->subtotal, 2) }}</span>
                    </li>
                @endforeach
            </ul>
            <div class="border-t border-slate-200 mt-4 pt-4 flex justify-between items-center text-sm text-slate-500 mb-2">
                <span>Payment Method</span>
                <span class="font-bold uppercase">{{ $order->payment_method }}</span>
            </div>
            <div class="flex justify-between items-center text-lg font-bold text-primary-600">
                <span>Total Paid</span>
                <span>RM {{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <a href="{{ route('order.show', ['token' => $order->table->qr_token]) }}" class="inline-flex items-center justify-center w-full h-14 bg-slate-900 text-white rounded-2xl font-bold hover:bg-slate-800 transition-all">
            Order More Items
        </a>
    </div>

</body>
</html>
