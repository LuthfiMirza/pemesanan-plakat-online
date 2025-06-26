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

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Transaksi')
                ->badge(Transaction::count())
                ->badgeColor('primary'),
                
            'menunggu_pembayaran' => Tab::make('Menunggu Pembayaran')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pembayaran', 'menunggu_pembayaran'))
                ->badge(Transaction::where('status_pembayaran', 'menunggu_pembayaran')->count())
                ->badgeColor('warning')
                ->icon('heroicon-o-clock'),
                
            'dibayar' => Tab::make('Dibayar')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereIn('status_pembayaran', ['dibayar', 'menunggu_verifikasi']))
                ->badge(Transaction::whereIn('status_pembayaran', ['dibayar', 'menunggu_verifikasi'])->count())
                ->badgeColor('success')
                ->icon('heroicon-o-check-circle'),
        ];
    }
}
