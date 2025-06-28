@php
    $statuses = [
        'menunggu_pembayaran' => [
            'label' => 'Menunggu Pembayaran',
            'icon' => 'heroicon-o-clock',
            'color' => 'warning'
        ],
        'menunggu_verifikasi' => [
            'label' => 'Menunggu Verifikasi',
            'icon' => 'heroicon-o-document-magnifying-glass',
            'color' => 'info'
        ],
        'dibayar' => [
            'label' => 'Dibayar',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success'
        ],
        'diproses' => [
            'label' => 'Di Proses',
            'icon' => 'heroicon-o-cog-6-tooth',
            'color' => 'primary'
        ],
        'selesai' => [
            'label' => 'Selesai',
            'icon' => 'heroicon-o-check-badge',
            'color' => 'success'
        ]
    ];
    
    $currentStatusIndex = array_search($record->status_pembayaran, array_keys($statuses));
@endphp

<div class="bg-white rounded-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Tracking Pesanan</h3>
    
    <div class="relative">
        @foreach($statuses as $statusKey => $status)
            @php
                $statusIndex = array_search($statusKey, array_keys($statuses));
                $isCompleted = $statusIndex <= $currentStatusIndex;
                $isCurrent = $statusKey === $record->status_pembayaran;
                $isSkipped = $record->status_pembayaran === 'ditolak' && $statusIndex > 0;
            @endphp
            
            <div class="flex items-center mb-4 {{ !$loop->last ? 'pb-4' : '' }}">
                <!-- Status Icon -->
                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $isCompleted ? 'bg-' . $status['color'] . '-100 text-' . $status['color'] . '-600' : 'bg-gray-100 text-gray-400' }} {{ $isCurrent ? 'ring-2 ring-' . $status['color'] . '-500 ring-offset-2' : '' }}">
                    @if($isCompleted)
                        @if($statusKey === 'selesai' && $isCurrent)
                            <x-heroicon-o-check-badge class="w-5 h-5" />
                        @elseif($statusKey === 'diproses' && $isCurrent)
                            <x-heroicon-o-cog-6-tooth class="w-5 h-5" />
                        @elseif($statusKey === 'dibayar' && $isCurrent)
                            <x-heroicon-o-check-circle class="w-5 h-5" />
                        @elseif($statusKey === 'menunggu_verifikasi' && $isCurrent)
                            <x-heroicon-o-document-magnifying-glass class="w-5 h-5" />
                        @elseif($statusKey === 'menunggu_pembayaran' && $isCurrent)
                            <x-heroicon-o-clock class="w-5 h-5" />
                        @else
                            <x-heroicon-o-check class="w-5 h-5" />
                        @endif
                    @else
                        <x-heroicon-o-clock class="w-5 h-5" />
                    @endif
                </div>
                
                <!-- Status Content -->
                <div class="ml-4 flex-1">
                    <h4 class="text-sm font-medium {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }}">
                        {{ $status['label'] }}
                    </h4>
                    @if($isCurrent)
                        <p class="text-xs text-{{ $status['color'] }}-600 font-medium">Status Saat Ini</p>
                    @elseif($isCompleted && !$isCurrent)
                        <p class="text-xs text-gray-500">Selesai</p>
                    @else
                        <p class="text-xs text-gray-400">Menunggu</p>
                    @endif
                </div>
                
                <!-- Connecting Line -->
                @if(!$loop->last)
                    <div class="absolute left-5 mt-10 w-0.5 h-4 {{ $isCompleted && $statusIndex < $currentStatusIndex ? 'bg-' . $status['color'] . '-300' : 'bg-gray-200' }}"></div>
                @endif
            </div>
        @endforeach
    </div>
    
    @if($record->admin_notes)
        <div class="mt-6 pt-4 border-t border-gray-200">
            <h4 class="text-sm font-medium text-gray-900 mb-2">Catatan Admin:</h4>
            <div class="text-sm text-gray-600 whitespace-pre-line bg-gray-50 p-3 rounded-md">
                {{ $record->admin_notes }}
            </div>
        </div>
    @endif
</div>