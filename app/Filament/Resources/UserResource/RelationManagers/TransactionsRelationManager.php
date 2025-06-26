<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $title = 'Riwayat Transaksi';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice_number')
                    ->label('Nomor Invoice')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('invoice_number')
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('plakat.nama')
                    ->label('Produk')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(function ($state, $record) {
                        return match($state) {
                            'transfer_bank' => 'Transfer Bank (' . $record->bank . ')',
                            'e_wallet' => 'E-Wallet (' . $record->ewallet . ')',
                            'cod' => 'Cash on Delivery',
                            default => $state
                        };
                    })
                    ->colors([
                        'primary' => 'transfer_bank',
                        'success' => 'e_wallet',
                        'warning' => 'cod',
                    ]),

                Tables\Columns\BadgeColumn::make('status_pembayaran')
                    ->label('Status')
                    ->colors([
                        'warning' => ['pending', 'menunggu_pembayaran', 'menunggu_verifikasi'],
                        'success' => 'confirmed',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'pending' => 'Pending',
                            'menunggu_pembayaran' => 'Menunggu Pembayaran',
                            'menunggu_verifikasi' => 'Menunggu Verifikasi',
                            'confirmed' => 'Dikonfirmasi',
                            'rejected' => 'Ditolak',
                            default => $state
                        };
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pembayaran')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'confirmed' => 'Dikonfirmasi',
                        'rejected' => 'Ditolak',
                    ])
                    ->native(false),

                Tables\Filters\SelectFilter::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->options([
                        'transfer_bank' => 'Transfer Bank',
                        'e_wallet' => 'E-Wallet',
                        'cod' => 'Cash on Delivery',
                    ])
                    ->native(false),
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat')
                    ->url(fn ($record) => route('admin.transactions.show', $record)),
                Tables\Actions\EditAction::make()
                    ->label('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}