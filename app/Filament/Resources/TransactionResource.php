<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('plakat_id')
                    ->relationship('plakat', 'nama')
                    ->preload()
                    ->required()
                    ->label('Nama Plakat')
                    ->searchable()
                    ->disabled(),
                Forms\Components\TextInput::make('plakat.deskripsi')
                    ->label('Deskripsi Produk')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('plakat.harga')
                    ->label('Harga Produk')
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('plakat.kategori')
                    ->label('Kategori')
                    ->disabled()
                    ->dehydrated(false),
                Forms\Components\TextInput::make('nama_pembeli')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Pembeli')
                    ->disabled(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\TextInput::make('no_telepon')
                    ->tel()
                    ->required()
                    ->maxLength(255)
                    ->label('No. Telepon')
                    ->disabled(),
                Forms\Components\Textarea::make('alamat')
                    ->required()
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\FileUpload::make('design_file')
                    ->image()
                    ->directory('design-files')
                    ->disk('public')
                    ->label('Design File')
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\Textarea::make('catatan_design')
                    ->label('Catatan Design')
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\TextInput::make('total_harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->label('Total Harga')
                    ->disabled(),
                Forms\Components\Select::make('metode_pembayaran')
                    ->options([
                        'transfer_bank' => 'Transfer Bank',
                        'e_wallet' => 'E-Wallet'
                    ])
                    ->required()
                    ->disabled(),
                Forms\Components\Select::make('bank')
                    ->options([
                        'bca' => 'BCA',
                        'bni' => 'BNI',
                        'mandiri' => 'Mandiri'
                    ])
                    ->visible(fn (callable $get) => $get('metode_pembayaran') === 'transfer_bank')
                    ->disabled(),
                Forms\Components\Select::make('ewallet')
                    ->options([
                        'dana' => 'DANA',
                        'ovo' => 'OVO',
                        'gopay' => 'GoPay'
                    ])
                    ->visible(fn (callable $get) => $get('metode_pembayaran') === 'e_wallet')
                    ->disabled(),
                Forms\Components\FileUpload::make('bukti_pembayaran')
                    ->image()
                    ->directory('bukti-pembayaran')
                    ->disk('public')
                    ->label('Bukti Pembayaran')
                    ->columnSpanFull()
                    ->disabled(),
                Forms\Components\Select::make('status_pembayaran')
                    ->options([
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'dibayar' => 'Dibayar',
                        'ditolak' => 'Ditolak'
                    ])
                    ->required()
                    ->default('menunggu_pembayaran')
                    ->label('Status Pembayaran'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('plakat.nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Plakat'),
                Tables\Columns\TextColumn::make('nama_pembeli')
                    ->searchable()
                    ->label('Nama Pembeli'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_telepon')
                    ->searchable()
                    ->label('No. Telepon'),
                Tables\Columns\TextColumn::make('alamat')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\ImageColumn::make('design_file')
                    ->disk('public')
                    ->size(100)
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->defaultImageUrl(function ($record) {
                        return $record->design_file
                            ? asset('storage/design-files/' . $record->design_file)
                            : null;
                    })
                    ->label('Design File'),
                Tables\Columns\TextColumn::make('catatan_design')
                    ->limit(30)
                    ->label('Catatan Design'),
                Tables\Columns\TextColumn::make('total_harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('metode_pembayaran'),
                Tables\Columns\TextColumn::make('bank')
                    ->visible(function ($record) {
                        if (!$record) return false;
                        return $record->metode_pembayaran === 'transfer_bank';
                    }),
                Tables\Columns\TextColumn::make('ewallet')
                    ->visible(function ($record) {
                        if (!$record) return false;
                        return $record->metode_pembayaran === 'e_wallet';
                    }),
                Tables\Columns\ImageColumn::make('bukti_pembayaran')
                    ->disk('public')
                    ->size(100)
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->defaultImageUrl(function ($record) {
                        return $record->bukti_pembayaran
                            ? asset('storage/bukti-pembayaran/' . $record->bukti_pembayaran)
                            : null;
                    })
                    ->label('Bukti Pembayaran'),
                Tables\Columns\TextColumn::make('status_pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'menunggu_pembayaran' => 'warning',
                        'menunggu_verifikasi' => 'info',
                        'dibayar' => 'success',
                        'ditolak' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Pemesanan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}