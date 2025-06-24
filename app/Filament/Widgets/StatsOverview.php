<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\Plakat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transaksi', Transaction::count())
                ->description('Total semua transaksi')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Produk', Plakat::count())
                ->description('Jumlah produk tersedia')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),
            Stat::make('Pendapatan', function () {
                $total = Transaction::where('status_pembayaran', 'dibayar')
                    ->sum('total_harga');
                return 'Rp ' . number_format($total, 0, ',', '.');
            })
                ->description('Total pendapatan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}