<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\ViewEntry;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Status Tracking')
                    ->schema([
                        ViewEntry::make('status_timeline')
                            ->view('filament.components.status-timeline')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),
                    
                Section::make('Informasi Pesanan')
                    ->schema([
                        TextEntry::make('invoice_number')
                            ->label('Nomor Invoice'),
                        TextEntry::make('plakat.nama')
                            ->label('Produk Plakat'),
                        TextEntry::make('total_harga')
                            ->money('IDR')
                            ->label('Total Harga'),
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->label('Tanggal Pemesanan'),
                    ])
                    ->columns(2),
                    
                Section::make('Informasi Pembeli')
                    ->schema([
                        TextEntry::make('nama_pembeli')
                            ->label('Nama Lengkap'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('no_telepon')
                            ->label('No. Telepon'),
                        TextEntry::make('alamat')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Section::make('Informasi Design')
                    ->schema([
                        ImageEntry::make('design_file')
                            ->disk('public')
                            ->label('File Design'),
                        TextEntry::make('catatan_design')
                            ->label('Catatan Design'),
                    ])
                    ->columns(2),
                    
                Section::make('Informasi Pembayaran')
                    ->schema([
                        TextEntry::make('metode_pembayaran')
                            ->label('Metode Pembayaran'),
                        TextEntry::make('bank')
                            ->label('Bank')
                            ->visible(fn ($record) => $record->metode_pembayaran === 'transfer_bank'),
                        TextEntry::make('ewallet')
                            ->label('E-Wallet')
                            ->visible(fn ($record) => $record->metode_pembayaran === 'e_wallet'),
                        ImageEntry::make('bukti_pembayaran')
                            ->disk('public')
                            ->label('Bukti Pembayaran'),
                        TextEntry::make('status_pembayaran')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'menunggu_pembayaran' => 'warning',
                                'menunggu_verifikasi' => 'info',
                                'dibayar' => 'success',
                                'diproses' => 'primary',
                                'selesai' => 'success',
                                'ditolak' => 'danger',
                                default => 'gray',
                            })
                            ->label('Status Pembayaran'),
                    ])
                    ->columns(2),
            ])
            ->columns(3);
    }
}