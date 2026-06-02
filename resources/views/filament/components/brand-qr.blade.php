<div class="flex flex-col items-center justify-center p-6 text-center">
    <!-- QR Code Card -->
    <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm mb-4 dark:bg-gray-800 dark:border-gray-700">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($url) }}" alt="QR Code - {{ $record->name }}" class="w-48 h-48 rounded" />
    </div>

    <!-- Info Text -->
    <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">{{ $record->name }}</h4>
    <p class="text-xs text-gray-500 mb-4">Pindai QR Code ini untuk langsung memfilter katalog brand ini di jaringan lokal.</p>

    <!-- Mono URL -->
    <div class="w-full max-w-sm px-3 py-2 bg-gray-50 border border-gray-100 rounded-lg text-xs font-mono text-gray-600 select-all break-all dark:bg-gray-900 dark:border-gray-800 dark:text-gray-400 mb-5">
        {{ $url }}
    </div>

    <!-- Download/Open Button -->
    <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode($url) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 transition duration-150 active:scale-95 shadow-sm">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
        </svg>
        Buka Gambar QR Code Besar
    </a>
</div>
