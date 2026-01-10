<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-slate-50 scroll-pt-32">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>{{ $restaurant->name }} - Table {{ $table->table_number }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Using CDN + Config for simplicity in this phase) -->
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
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .glass-dark {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .category-tab-active {
            background: linear-gradient(135deg, #FF7E5F 0%, #FEB47B 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 126, 95, 0.3);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .safe-bottom {
            padding-bottom: env(safe-area-inset-bottom);
        }
        .menu-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .menu-card:active {
            transform: scale(0.97);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #f8fafc 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }
        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .flying-item {
            position: fixed;
            pointer-events: none;
            z-index: 100;
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
</head>
<body class="font-sans text-slate-900 antialiased selection:bg-primary-100">

    <!-- Header -->
    <header class="sticky top-0 z-40 glass border-b border-white/20">
        <div class="px-4 h-16 flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-[9px] font-black text-primary-500 uppercase tracking-[0.2em]">{{ $restaurant->name }}</span>
                <div class="flex items-center space-x-2">
                    <span class="text-xl font-black text-slate-900">Table {{ $table->table_number }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('public.reservation', $restaurant->slug ?? $restaurant->id) }}" class="flex items-center space-x-2 bg-primary-50 px-4 py-2 rounded-2xl border border-primary-100 text-primary-600 active:scale-95 transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor font-black"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span class="text-[10px] font-black uppercase tracking-widest hidden sm:block">Reservations</span>
                </a>
                <div class="bg-white/50 backdrop-blur-sm p-2 rounded-2xl border border-white shadow-sm">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="px-4 py-3 flex space-x-2 overflow-x-auto no-scrollbar scroll-smooth" id="category-tabs">
            @foreach($categories as $category)
                <a href="#category-{{ $category->id }}" 
                   id="tab-category-{{ $category->id }}"
                   data-category="{{ $category->id }}"
                   class="category-tab flex-shrink-0 px-5 py-2.5 rounded-2xl text-[13px] font-black uppercase tracking-wider transition-all duration-300 bg-white shadow-sm border border-slate-100 text-slate-500 hover:text-primary-600 active:scale-95">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </header>

    <!-- Menu Content -->
    <main class="pb-32">
        <div class="max-w-screen-md mx-auto">
            <!-- Hero Section -->
            <div class="px-4 pt-6 md:pt-8 pb-4">
                <div class="relative overflow-hidden rounded-[40px] bg-slate-900 aspect-[16/10] sm:aspect-[21/9] p-8 flex flex-col justify-end group shadow-2xl shadow-slate-200">
                    <div class="absolute inset-0">
                        <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=1200&q=80" 
                             class="w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-[2s]" alt="Hero">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    </div>
                    <div class="relative z-10 animate-fade-in translate-y-2 group-hover:translate-y-0 transition-transform duration-700">
                        <div class="inline-flex items-center px-3 py-1 bg-white/10 backdrop-blur-md rounded-full border border-white/20 mb-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                            <span class="text-[9px] font-black text-white uppercase tracking-widest">Kitchen is Open</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white mb-2 leading-tight tracking-tighter">Gourmet Experience,<br>Served Fresh.</h1>
                        <p class="text-slate-300 text-[13px] font-medium opacity-80">Discover meticulously prepared dishes for your table.</p>
                        
                        <div class="mt-6">
                            <a href="{{ route('public.reservation', $restaurant->slug ?? $restaurant->id) }}" class="inline-flex items-center px-6 py-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-slate-900 transition-all duration-300 group">
                                <span>Reserve for Next Time</span>
                                <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor font-black"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @foreach($categories as $category)
                <section id="category-{{ $category->id }}" class="mt-8 px-4 scroll-mt-24">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-black text-slate-900">{{ $category->name }}</h2>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $category->menuItems->count() }} Items</span>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-5">
                        @foreach($category->menuItems as $item)
                            <div class="menu-card bg-white rounded-[24px] p-3 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-50 flex gap-4 relative overflow-hidden {{ !$item->is_available ? 'opacity-75' : '' }}">
                                <div class="w-28 h-28 sm:w-36 sm:h-36 bg-slate-100 rounded-[20px] overflow-hidden flex-shrink-0 relative skeleton" id="skeleton-{{ $item->id }}">
                                    @if($item->image_url)
                                        <img src="{{ $item->image_url }}" 
                                             onload="document.getElementById('skeleton-{{ $item->id }}').classList.remove('skeleton')"
                                             class="w-full h-full object-cover" alt="{{ $item->name }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    @if(!$item->is_available)
                                        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] flex items-center justify-center">
                                            <span class="bg-white text-slate-900 text-[10px] font-black uppercase px-2 py-1 rounded-md">Sold Out</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 flex flex-col justify-between py-1">
                                    <div>
                                        <h3 class="font-black text-slate-900 text-lg leading-tight">{{ $item->name }}</h3>
                                        <p class="text-xs text-slate-500 mt-2 line-clamp-2 font-medium leading-relaxed">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-[#FF7E5F] font-black text-lg">RM {{ number_format($item->price, 2) }}</span>
                                        
                                        @if($item->is_available)
                                            <button onclick="addToCart(event, {{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }})" 
                                                    class="add-to-cart-btn w-10 h-10 flex items-center justify-center bg-slate-900 text-white rounded-2xl shadow-lg active:scale-95 transition-all duration-300 hover:bg-primary-600">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </main>

    <!-- Float Cart Bar -->
    <div id="cart-bar" class="fixed bottom-6 left-0 right-0 px-6 z-50 transition-all duration-500 translate-y-40">
        <div class="max-w-screen-md mx-auto">
            <button onclick="toggleCheckoutModal()" class="w-full glass-dark text-white h-20 rounded-[28px] shadow-[0_20px_50px_rgba(0,0,0,0.3)] flex items-center justify-between px-8 active:scale-[0.98] transition-all border border-white/10 group">
                <div class="flex items-center">
                    <div class="relative">
                        <div class="bg-gradient-to-br from-[#FF7E5F] to-[#FEB47B] p-3 rounded-2xl mr-4 shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <span id="cart-count-badge" class="absolute -top-2 -right-1 bg-white text-slate-900 text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-lg border-2 border-slate-900 hidden animate-bounce">0</span>
                    </div>
                    <div class="flex flex-col items-start text-left">
                        <span id="cart-count" class="text-[10px] uppercase font-black text-slate-400 tracking-[0.1em] mb-1">Total Items: 0</span>
                        <span class="text-xl font-black">View Basket</span>
                    </div>
                </div>
                <div class="text-right">
                    <span id="cart-total" class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-[#FF7E5F] to-[#FEB47B]">RM 0.00</span>
                </div>
            </button>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkout-modal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-md transition-opacity duration-300" onclick="toggleCheckoutModal()"></div>
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-[40px] max-h-[92vh] flex flex-col safe-bottom transition-transform duration-500 translate-y-full" id="modal-content">
            <!-- Modal Handle -->
            <div class="flex justify-center py-4 flex-shrink-0 cursor-pointer" onclick="toggleCheckoutModal()">
                <div class="w-16 h-1.5 bg-slate-200 rounded-full"></div>
            </div>

            <div class="px-8 pb-8 pt-2 overflow-y-auto flex-1">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-3xl font-black text-slate-900">Your Basket</h2>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Review your selections</p>
                    </div>
                    <button onclick="toggleCheckoutModal()" class="p-2 bg-slate-50 text-slate-400 rounded-full hover:bg-slate-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div id="cart-items-list" class="space-y-6 mb-10">
                    <!-- Items injected via JS -->
                </div>

                <div class="bg-slate-50 rounded-[32px] p-8 space-y-4 mb-8">
                    <div class="flex justify-between items-center text-slate-600 font-bold">
                        <span>Subtotal</span>
                        <span id="modal-subtotal" class="text-slate-900">RM 0.00</span>
                    </div>
                    <div class="flex justify-between items-center text-slate-600 font-bold">
                        <span>SST (6%)</span>
                        <span id="modal-tax" class="text-slate-900">RM 0.00</span>
                    </div>
                    <div class="h-px bg-slate-200 my-2"></div>
                    <div class="flex justify-between items-center text-2xl font-black text-slate-900">
                        <span>Grand Total</span>
                        <span id="modal-total" class="text-[#FF7E5F]">RM 0.00</span>
                    </div>
                </div>

                <div class="mb-10">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Preferred Payment</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="group relative flex flex-col items-center justify-center p-6 border-2 border-slate-100 rounded-[28px] cursor-pointer hover:bg-slate-50 transition-all duration-300 overflow-hidden">
                            <input type="radio" name="payment_method_select" value="cash" checked class="sr-only peer" onchange="document.getElementById('payment-input').value = this.value">
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-primary-500 peer-checked:bg-primary-50/30 transition-all duration-300"></div>
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 group-hover:bg-white flex items-center justify-center mb-3 transition-colors peer-checked:bg-primary-500">
                                    <svg class="w-6 h-6 text-slate-400 peer-checked:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-black text-slate-600 peer-checked:text-primary-600">Cash</span>
                            </div>
                        </label>
                        <label class="group relative flex flex-col items-center justify-center p-6 border-2 border-slate-100 rounded-[28px] cursor-pointer hover:bg-slate-50 transition-all duration-300 overflow-hidden">
                            <input type="radio" name="payment_method_select" value="card" class="sr-only peer" onchange="document.getElementById('payment-input').value = this.value">
                            <div class="absolute inset-0 border-2 border-transparent peer-checked:border-primary-500 peer-checked:bg-primary-50/30 transition-all duration-300"></div>
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 group-hover:bg-white flex items-center justify-center mb-3 transition-colors peer-checked:bg-primary-500">
                                    <svg class="w-6 h-6 text-slate-400 peer-checked:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-black text-slate-600 peer-checked:text-primary-600">Card</span>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="mt-4">
                    <form id="checkout-form" action="{{ route('order.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="cart" id="cart-input">
                        <input type="hidden" name="payment_method" id="payment-input" value="cash">
                        
                        <button type="button" onclick="placeOrder()" class="w-full h-20 bg-slate-900 text-white rounded-[28px] font-black text-xl shadow-2xl active:scale-[0.98] transition-all flex items-center justify-center space-x-3 group">
                            <span>Place Your Order</span>
                            <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </button>
                    </form>
                    <p class="text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-6">
                        Table {{ $table->table_number }} • {{ $restaurant->name }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = {};

        function addToCart(event, id, name, price) {
            if (cart[id]) {
                cart[id].quantity += 1;
            } else {
                cart[id] = { name, price, quantity: 1 };
            }
            updateCartUI();
            showCartBar();
            
            if (event) {
                flyToCart(event.currentTarget);
            }

            // Animation for item added
            const badge = document.getElementById('cart-count-badge');
            badge.classList.remove('hidden', 'animate-bounce');
            void badge.offsetWidth; // Trigger reflow
            badge.classList.add('animate-bounce');
        }

        function flyToCart(button) {
            const cartBar = document.getElementById('cart-bar');
            const flyingItem = document.createElement('div');
            
            flyingItem.classList.add('flying-item', 'w-8', 'h-8', 'bg-primary-500', 'rounded-full', 'shadow-lg', 'flex', 'items-center', 'justify-center', 'text-white');
            flyingItem.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>';
            
            const btnRect = button.getBoundingClientRect();
            const cartRect = cartBar.getBoundingClientRect();
            
            flyingItem.style.left = `${btnRect.left}px`;
            flyingItem.style.top = `${btnRect.top}px`;
            
            document.body.appendChild(flyingItem);
            
            // Force reflow
            void flyingItem.offsetWidth;
            
            flyingItem.style.left = `${cartRect.left + cartRect.width / 2}px`;
            flyingItem.style.top = `${cartRect.top}px`;
            flyingItem.style.transform = 'scale(0.1)';
            flyingItem.style.opacity = '0';
            
            setTimeout(() => {
                flyingItem.remove();
            }, 800);
        }

        function updateItemNote(id, note) {
            if (cart[id]) {
                cart[id].notes = note;
                document.getElementById('cart-input').value = JSON.stringify(cart);
            }
        }

        function removeFromCart(id) {
            if (cart[id]) {
                if (cart[id].quantity > 1) {
                    cart[id].quantity -= 1;
                } else {
                    delete cart[id];
                }
            }
            updateCartUI();
            if (Object.keys(cart).length === 0) {
                hideCartBar();
                const modal = document.getElementById('checkout-modal');
                if (!modal.classList.contains('hidden')) {
                    toggleCheckoutModal();
                }
            }
        }

        function updateCartUI() {
            let total = 0;
            let count = 0;
            const itemsList = document.getElementById('cart-items-list');
            itemsList.innerHTML = '';

            for (const id in cart) {
                const item = cart[id];
                const subtotal = item.price * item.quantity;
                total += subtotal;
                count += item.quantity;

                itemsList.innerHTML += `
                    <div class="animate-fade-in">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex-1">
                                <h4 class="font-black text-slate-900">${item.name}</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">RM ${item.price.toFixed(2)} / unit</span>
                            </div>
                            <div class="flex items-center bg-slate-100 rounded-2xl p-1">
                                <button onclick="removeFromCart(${id})" class="w-8 h-8 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-600 active:scale-90 transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4" /></svg>
                                </button>
                                <span class="font-black text-slate-900 w-10 text-center text-sm">${item.quantity}</span>
                                <button onclick="addToCart(${id}, '${item.name.replace(/'/g, "\\'")}', ${item.price})" class="w-8 h-8 rounded-xl bg-slate-900 text-white shadow-sm flex items-center justify-center active:scale-90 transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5" /></svg>
                            </div>
                            <input type="text" 
                                placeholder="Special instructions..." 
                                class="w-full bg-slate-50 border-none text-[11px] font-medium rounded-xl focus:ring-1 focus:ring-primary-400 py-2.5 pl-9 pr-4 transition-all" 
                                value="${item.notes || ''}" 
                                onchange="updateItemNote(${id}, this.value)"
                            >
                        </div>
                    </div>
                `;
            }

            document.getElementById('cart-count').innerText = `Total Items: ${count}`;
            document.getElementById('cart-count-badge').innerText = count;
            document.getElementById('cart-count-badge').classList.toggle('hidden', count === 0);
            
            document.getElementById('cart-total').innerText = `RM ${total.toFixed(2)}`;
            document.getElementById('cart-input').value = JSON.stringify(cart);

            // Update modal totals
            const tax = total * 0.06;
            const grandTotal = total + tax;
            document.getElementById('modal-subtotal').innerText = `RM ${total.toFixed(2)}`;
            document.getElementById('modal-tax').innerText = `RM ${tax.toFixed(2)}`;
            document.getElementById('modal-total').innerText = `RM ${grandTotal.toFixed(2)}`;
        }

        function showCartBar() {
            const bar = document.getElementById('cart-bar');
            bar.classList.remove('translate-y-40');
            bar.classList.add('translate-y-0');
        }

        function hideCartBar() {
            const bar = document.getElementById('cart-bar');
            bar.classList.add('translate-y-40');
            bar.classList.remove('translate-y-0');
        }

        function toggleCheckoutModal() {
            const modal = document.getElementById('checkout-modal');
            const content = document.getElementById('modal-content');
            
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => content.classList.remove('translate-y-full'), 10);
            } else {
                content.classList.add('translate-y-full');
                setTimeout(() => modal.classList.add('hidden'), 500);
            }
        }

        function placeOrder() {
            const btn = document.querySelector('button[onclick="placeOrder()"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="animate-pulse">Processing Order...</span>';
            document.getElementById('checkout-form').submit();
        }

        // Category Highlighting Logic
        const sections = document.querySelectorAll('section[id^="category-"]');
        const tabs = document.querySelectorAll('.category-tab');
        const tabContainer = document.getElementById('category-tabs');

        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -70% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.id.replace('category-', '');
                    activateTab(id);
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));

        function activateTab(id) {
            tabs.forEach(tab => {
                if (tab.dataset.category === id) {
                    tab.classList.add('category-tab-active');
                    tab.classList.remove('bg-white', 'text-slate-500', 'border-slate-100');
                    
                    const offsetLeft = tab.offsetLeft - 20;
                    tabContainer.scrollTo({
                        left: offsetLeft,
                        behavior: 'smooth'
                    });
                } else {
                    tab.classList.remove('category-tab-active');
                    tab.classList.add('bg-white', 'text-slate-500', 'border-slate-100');
                }
            });
        }
    </script>

</body>
</html>
