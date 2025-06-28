<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;
    
    protected string $pollingInterval = '5s';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        // Cache counts for better performance during polling
        $allCount = Transaction::count();
        $menungguCount = Transaction::where('status_pembayaran', 'menunggu_pembayaran')->count();
        $verifikasiCount = Transaction::where('status_pembayaran', 'menunggu_verifikasi')->count();
        $dibayarCount = Transaction::where('status_pembayaran', 'dibayar')->count();
        $diprosesCount = Transaction::where('status_pembayaran', 'diproses')->count();
        $selesaiCount = Transaction::where('status_pembayaran', 'selesai')->count();
        
        return [
            'all' => Tab::make('Semua Transaksi')
                ->badge($allCount)
                ->badgeColor('primary')
                ->icon('heroicon-o-list-bullet'),
                
            'menunggu_pembayaran' => Tab::make('Menunggu Pembayaran')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'menunggu_pembayaran'))
                ->badge($menungguCount)
                ->badgeColor($menungguCount > 0 ? 'warning' : 'gray')
                ->icon('heroicon-o-clock'),
                
            'menunggu_verifikasi' => Tab::make('Menunggu Verifikasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'menunggu_verifikasi'))
                ->badge($verifikasiCount)
                ->badgeColor($verifikasiCount > 0 ? 'info' : 'gray')
                ->icon('heroicon-o-document-magnifying-glass'),
                
            'dibayar' => Tab::make('Dibayar')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'dibayar'))
                ->badge($dibayarCount)
                ->badgeColor($dibayarCount > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-check-circle'),
                
            'diproses' => Tab::make('Di Proses')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'diproses'))
                ->badge($diprosesCount)
                ->badgeColor($diprosesCount > 0 ? 'primary' : 'gray')
                ->icon('heroicon-o-cog-6-tooth'),
                
            'selesai' => Tab::make('Selesai')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'selesai'))
                ->badge($selesaiCount)
                ->badgeColor($selesaiCount > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-check-badge'),
        ];
    }
    
    protected function getTablePollingInterval(): ?string
    {
        return '5s';
    }
}
