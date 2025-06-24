<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ProductCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Kategori Produk Terlaris';
    protected static ?int $sort = 2;
    
    // Ubah columnSpan untuk menyesuaikan dengan TransactionsChart
    protected function getColumnSpanConfig(): int | string | array
    {
        return [
            'default' => 'full',
            'sm' => 'full',
            'md' => '6',
            'xl' => '6',
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => true,
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                ],
            ],
        ];
    }

    protected function getData(): array
    {
        $data = Transaction::select('plakats.kategori', DB::raw('count(*) as total'))
            ->join('plakats', 'transactions.plakat_id', '=', 'plakats.id')
            ->where('transactions.status_pembayaran', 'dibayar')
            ->groupBy('plakats.kategori')
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $data->pluck('total')->toArray(),
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                    ],
                ],
            ],
            'labels' => $data->pluck('kategori')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}