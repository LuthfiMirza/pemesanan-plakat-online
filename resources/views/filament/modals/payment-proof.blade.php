<div class="space-y-6">
    <!-- Transaction Info -->
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Invoice:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $record->invoice_number }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Nama Pembeli:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $record->nama_pembeli }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Total Harga:</span>
                <span class="text-gray-900 dark:text-gray-100">Rp {{ number_format($record->total_harga, 0, ',', '.') }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Metode Pembayaran:</span>
                <span class="text-gray-900 dark:text-gray-100">
                    {{ ucwords(str_replace('_', ' ', $record->metode_pembayaran)) }}
                    @if($record->bank)
                        - {{ $record->bank }}
                    @endif
                    @if($record->ewallet)
                        - {{ $record->ewallet }}
                    @endif
                </span>
            </div>
        </div>
    </div>

    <!-- Payment Proof Image -->
    @if($record->bukti_pembayaran)
        <div class="text-center">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Bukti Pembayaran</h3>
            <div class="inline-block border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-lg">
                <img 
                    src="{{ asset('storage/bukti-pembayaran/' . $record->bukti_pembayaran) }}" 
                    alt="Bukti Pembayaran {{ $record->invoice_number }}"
                    class="max-w-full max-h-96 object-contain"
                    style="max-height: 500px;"
                >
            </div>
            <div class="mt-4">
                <a 
                    href="{{ asset('storage/bukti-pembayaran/' . $record->bukti_pembayaran) }}" 
                    target="_blank"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-200"
                >
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Buka di Tab Baru
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-8">
            <div class="text-gray-400 dark:text-gray-600">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <p class="text-lg font-medium">Belum Ada Bukti Pembayaran</p>
                <p class="text-sm">Pelanggan belum mengupload bukti pembayaran</p>
            </div>
        </div>
    @endif

    <!-- Status and Notes -->
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
        <div class="grid grid-cols-1 gap-4">
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Status Saat Ini:</span>
                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($record->status_pembayaran === 'menunggu_verifikasi') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                    @elseif($record->status_pembayaran === 'dibayar') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                    @elseif($record->status_pembayaran === 'ditolak') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                    @endif">
                    {{ ucwords(str_replace('_', ' ', $record->status_pembayaran)) }}
                </span>
            </div>
            
            @if($record->admin_notes)
                <div>
                    <span class="font-medium text-gray-700 dark:text-gray-300">Catatan Admin:</span>
                    <div class="mt-1 p-3 bg-gray-100 dark:bg-gray-700 rounded-md">
                        <p class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $record->admin_notes }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Date -->
    <div class="text-xs text-gray-500 dark:text-gray-400 text-center border-t border-gray-200 dark:border-gray-700 pt-4">
        Pesanan dibuat: {{ $record->created_at->format('d/m/Y H:i') }} WIB
        @if($record->updated_at != $record->created_at)
            <br>Terakhir diupdate: {{ $record->updated_at->format('d/m/Y H:i') }} WIB
        @endif
    </div>
</div>