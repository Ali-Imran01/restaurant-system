@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-slate-50">
    @include('admin.partials.sidebar')

    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <main class="flex-1 relative overflow-y-auto focus:outline-none py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-slate-900">Tables & QR Codes</h1>
                    <a href="{{ route('tables.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200">
                        Add Table
                    </a>
                </div>

                @if(session('success'))
                    <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="mt-8 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-slate-200 sm:rounded-2xl bg-white">
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Table Number
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                QR Code
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Ordering URL
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        @forelse($tables as $table)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                                    Table {{ $table->table_number }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center space-x-3">
                                                        <div class="relative group cursor-pointer" onclick="openQRModal('{{ route('order.show', $table->qr_token) }}', '{{ $table->table_number }}')">
                                                            <img src="https://quickchart.io/qr?text={{ urlencode(route('order.show', $table->qr_token)) }}&size=100" class="w-16 h-16 rounded-lg border border-slate-100 group-hover:opacity-75 transition-opacity" alt="QR Code">
                                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900/10 rounded-lg">
                                                                <svg class="w-6 h-6 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-col space-y-1">
                                                            <span class="font-mono text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-500">{{ $table->qr_token }}</span>
                                                            <a href="https://quickchart.io/qr?text={{ urlencode(route('order.show', $table->qr_token)) }}&size=500&format=png" download="Table_{{ $table->table_number }}_QR.png" class="text-[10px] text-primary-600 hover:underline flex items-center">
                                                                <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                                Download PNG
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-600">
                                                    <div class="flex flex-col">
                                                        <a href="{{ route('order.show', $table->qr_token) }}" target="_blank" class="hover:underline font-bold">View Menu</a>
                                                        <span class="text-[10px] text-slate-400 truncate max-w-[150px]">{{ route('order.show', $table->qr_token) }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <form action="{{ route('tables.regenerate', $table) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <button type="submit" class="text-amber-600 hover:text-amber-900 mr-4" title="Regenerate QR Token">Regenerate</button>
                                                    </form>
                                                    <a href="{{ route('tables.edit', $table) }}" class="text-primary-600 hover:text-primary-900 mr-4">Edit</a>
                                                    <form action="{{ route('tables.destroy', $table) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-500">
                                                    No tables found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<div id="qr-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeQRModal()"></div>
    <div class="absolute inset-0 flex items-center justify-center p-4" onclick="closeQRModal()">
        <div class="bg-white rounded-[32px] shadow-2xl p-8 max-w-sm w-full text-center transform transition-all scale-95 opacity-0" id="qr-modal-content" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-slate-900" id="modal-table-label">Table QR Code</h3>
                <button onclick="closeQRModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="bg-slate-50 rounded-2xl p-4 mb-6">
                <img id="modal-qr-image" src="" class="w-full aspect-square rounded-xl shadow-inner" alt="Large QR Code">
            </div>

            <div class="space-y-3">
                <a id="modal-download-link" href="#" download class="w-full flex items-center justify-center h-14 bg-primary-600 text-white rounded-2xl font-bold shadow-lg shadow-primary-200 hover:bg-primary-700 transition-all">
                    Download PNG
                </a>
                <button onclick="window.print()" class="w-full flex items-center justify-center h-14 bg-slate-100 text-slate-600 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                    Print Code
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openQRModal(url, tableNumber) {
        const modal = document.getElementById('qr-modal');
        const content = document.getElementById('qr-modal-content');
        const qrImg = document.getElementById('modal-qr-image');
        const downloadLink = document.getElementById('modal-download-link');
        const label = document.getElementById('modal-table-label');

        const qrUrl = `https://quickchart.io/qr?text=${encodeURIComponent(url)}&size=500&format=png`;
        
        qrImg.src = qrUrl;
        downloadLink.href = qrUrl;
        downloadLink.download = `Table_${tableNumber}_QR.png`;
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
