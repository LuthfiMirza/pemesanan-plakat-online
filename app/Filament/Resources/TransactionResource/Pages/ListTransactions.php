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
        $dibayarCount = Transaction::whereIn('status_pembayaran', ['dibayar', 'menunggu_verifikasi'])->count();
        
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
                
            'dibayar' => Tab::make('Dibayar')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status_pembayaran', ['dibayar', 'menunggu_verifikasi']))
                ->badge($dibayarCount)
                ->badgeColor($dibayarCount > 0 ? 'success' : 'gray')
                ->icon('heroicon-o-check-circle'),
        ];
    }
    
    protected function getTablePollingInterval(): ?string
    {
        return '5s';
    }
}
