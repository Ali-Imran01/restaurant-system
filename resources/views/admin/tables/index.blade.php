@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50 overflow-hidden font-sans">
    @include('admin.partials.sidebar')


    <div class="flex-1 flex flex-col overflow-hidden">
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
                    <h1 class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">Tables & QR</h1>
                    <p class="text-slate-500 text-[10px] md:text-xs font-bold uppercase tracking-widest mt-0.5">Physical Infrastructure</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('tables.create') }}" class="bg-primary-500 text-white p-2.5 md:px-6 md:py-3 rounded-2xl font-black text-sm hover:bg-primary-600 shadow-lg shadow-primary-500/20 transition-all flex items-center">
                    <svg class="w-5 h-5 md:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="hidden md:inline">New Table</span>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-6 md:p-8 bg-slate-50/50 pb-8">
            <div class="max-w-7xl mx-auto">
                @if(session('success'))
                    <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-[24px] flex items-center shadow-sm">
                        <svg class="w-5 h-5 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @forelse($tables as $table)
                        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden flex flex-col group hover:shadow-2xl hover:shadow-primary-500/10 transition-all duration-500">
                            {{-- Table Info Header --}}
                            <div class="p-8 pb-4 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-3xl mx-auto flex items-center justify-center mb-4 group-hover:bg-primary-50 transition-colors">
                                    <span class="text-2xl font-black text-slate-900 group-hover:text-primary-500 transition-colors">{{ $table->table_number }}</span>
                                </div>
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Quick Label</h4>
                                <p class="text-sm font-bold text-slate-900">Table {{ $table->table_number }}</p>
                            </div>

                            {{-- QR Preview --}}
                            <div class="px-8 flex-1 flex flex-col items-center justify-center py-4 bg-slate-50/50">
                                <div class="p-4 bg-white rounded-3xl shadow-sm border border-slate-100 relative group-hover:scale-105 transition-transform duration-500 cursor-pointer" onclick="openQRModal('{{ route('tables.downloadQR', $table) }}', '{{ route('order.show', ['token' => $table->qr_token]) }}', '{{ $table->table_number }}')">
                                    <img src="https://quickchart.io/qr?text={{ urlencode(route('order.show', ['token' => $table->qr_token])) }}&size=200" class="w-28 h-28 rounded-xl" alt="QR Code">
                                    <div class="absolute inset-0 bg-primary-500/10 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 rounded-3xl transition-opacity flex items-center justify-center">
                                        <svg class="w-8 h-8 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <p class="mt-4 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Click to Preview</p>
                            </div>

                            {{-- Actions Footer --}}
                            <div class="p-8 grid grid-cols-2 gap-3 border-t border-slate-100">
                                <a href="{{ route('tables.downloadQR', $table) }}" class="flex items-center justify-center p-3.5 bg-primary-50 text-primary-600 rounded-2xl text-[9px] font-black uppercase tracking-widest hover:bg-primary-500 hover:text-white transition-all">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Save
                                </a>
                                <form action="{{ route('tables.destroy', $table) }}" method="POST" class="w-full" onsubmit="return confirm('Attention: Deleting this table will invalidate its QR code instantly. Proceed?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full flex items-center justify-center p-3.5 bg-slate-50 text-slate-400 rounded-2xl text-[9px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Drop
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-20 bg-white rounded-[40px] shadow-sm border border-slate-100 text-center flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight">Floor is Empty</h3>
                            <p class="text-slate-400 text-sm font-medium mt-1">Start by adding your first table above.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>

{{-- QR Preview Modal --}}
@push('scripts')
<div id="qr-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-md transition-opacity" onclick="closeQRModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4" onclick="closeQRModal()">
        <div class="bg-white rounded-[40px] shadow-2xl p-8 max-w-sm w-full text-center transform transition-all scale-95 opacity-0" id="qr-modal-content" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-black text-slate-900 tracking-tight" id="modal-table-label">Table QR Code</h3>
                <button onclick="closeQRModal()" class="w-10 h-10 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 hover:text-slate-900 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="bg-slate-50/50 rounded-3xl p-6 mb-8 border border-slate-100">
                <img id="modal-qr-image" src="" class="w-full aspect-square rounded-2xl shadow-sm" alt="Large QR Code">
            </div>

            <div class="grid grid-cols-1 gap-4">
                <a id="modal-download-link" href="#" download class="w-full flex items-center justify-center h-16 bg-primary-500 text-white rounded-2xl font-black text-sm shadow-xl shadow-primary-500/20 hover:bg-primary-600 transition-all">
                    Download for Printing
                </a>
                <button onclick="window.print()" class="w-full flex items-center justify-center h-16 bg-slate-100 text-slate-600 rounded-2xl font-black text-sm hover:bg-slate-200 transition-all">
                    Print Direct
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openQRModal(downloadUrl, displayUrl, tableNumber) {
        const modal = document.getElementById('qr-modal');
        const content = document.getElementById('qr-modal-content');
        const qrImg = document.getElementById('modal-qr-image');
        const downloadLink = document.getElementById('modal-download-link');
        const label = document.getElementById('modal-table-label');

        const qrUrl = `https://quickchart.io/qr?text=${encodeURIComponent(displayUrl)}&size=500&format=jpg`;
        
        qrImg.src = qrUrl;
        downloadLink.href = downloadUrl;
        label.innerText = `Table ${tableNumber} QR Code`;

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeQRModal() {
        const modal = document.getElementById('qr-modal');
        const content = document.getElementById('qr-modal-content');
        
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endpush
