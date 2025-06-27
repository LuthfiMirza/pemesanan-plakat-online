<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Notifications\Notification;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Support\Colors\Color;
use Filament\Resources\Components\Tab;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    protected static ?string $navigationLabel = 'Kelola Transaksi';
    
    protected static ?string $modelLabel = 'Transaksi';
    
    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Produk')
                    ->schema([
                        Forms\Components\TextInput::make('invoice_number')
                            ->label('Nomor Invoice')
                            ->disabled()
                            ->dehydrated(false),

                        Forms\Components\Select::make('plakat_id')
                            ->relationship('plakat', 'nama')
                            ->preload()
                            ->required()
                            ->label('Produk Plakat')
                            ->searchable()
                            ->disabled(),

                        Forms\Components\TextInput::make('total_harga')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Total Harga')
                            ->disabled(),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Informasi Pembeli')
                    ->schema([
                        Forms\Components\TextInput::make('nama_pembeli')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap')
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->label('Email')
                            ->disabled(),

                        Forms\Components\TextInput::make('no_telepon')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->label('No. Telepon')
                            ->disabled(),

                        Forms\Components\Textarea::make('alamat')
                            ->required()
                            ->label('Alamat Lengkap')
                            ->columnSpanFull()
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Design')
                    ->schema([
                        Forms\Components\FileUpload::make('design_file')
                            ->image()
                            ->directory('design-files')
                            ->disk('public')
                            ->label('File Design')
                            ->downloadable()
                            ->openable()
                            ->disabled(),

                        Forms\Components\Textarea::make('catatan_design')
                            ->label('Catatan Design')
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Forms\Components\Select::make('metode_pembayaran')
                            ->options([
                                'transfer_bank' => 'Transfer Bank',
                                'e_wallet' => 'E-Wallet',
                                'cod' => 'Cash on Delivery'
                            ])
                            ->required()
                            ->label('Metode Pembayaran')
                            ->disabled(),

                        Forms\Components\Select::make('bank')
                            ->options([
                                'BCA' => 'BCA',
                                'BNI' => 'BNI',
                                'BRI' => 'BRI',
                                'Mandiri' => 'Mandiri',
                                'CIMB' => 'CIMB'
                            ])
                            ->visible(fn (callable $get) => $get('metode_pembayaran') === 'transfer_bank')
                            ->label('Bank')
                            ->disabled(),

                        Forms\Components\Select::make('ewallet')
                            ->options([
                                'DANA' => 'DANA',
                                'OVO' => 'OVO',
                                'GoPay' => 'GoPay',
                                'ShopeePay' => 'ShopeePay'
                            ])
                            ->visible(fn (callable $get) => $get('metode_pembayaran') === 'e_wallet')
                            ->label('E-Wallet')
                            ->disabled(),

                        Forms\Components\FileUpload::make('bukti_pembayaran')
                            ->image()
                            ->directory('bukti-pembayaran')
                            ->disk('public')
                            ->label('Bukti Pembayaran')
                            ->downloadable()
                            ->openable()
                            ->disabled(),

                        Forms\Components\Select::make('status_pembayaran')
                            ->options([
                                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                'dibayar' => 'Dibayar',
                                'ditolak' => 'Ditolak'
                            ])
                            ->required()
                            ->label('Status Pembayaran')
                            ->native(false),

                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Catatan Admin')
                            ->placeholder('Tambahkan catatan untuk transaksi ini...')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('5s')
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
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Tanggal Pemesanan'),
            ])
            ->filters([
                SelectFilter::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->options([
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                        'dibayar' => 'Dibayar',
                        'ditolak' => 'Ditolak',
                    ])
                    ->native(false),

                SelectFilter::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->options([
                        'transfer_bank' => 'Transfer Bank',
                        'e_wallet' => 'E-Wallet',
                        'cod' => 'Cash on Delivery',
                    ])
                    ->native(false),

                SelectFilter::make('plakat_id')
                    ->label('Produk Plakat')
                    ->relationship('plakat', 'nama')
                    ->searchable()
                    ->preload()
                    ->native(false),

                Filter::make('total_harga')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('harga_dari')
                                    ->label('Harga Dari')
                                    ->numeric()
                                    ->prefix('Rp'),
                                Forms\Components\TextInput::make('harga_sampai')
                                    ->label('Harga Sampai')
                                    ->numeric()
                                    ->prefix('Rp'),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['harga_dari'],
                                fn (Builder $query, $price): Builder => $query->where('total_harga', '>=', $price),
                            )
                            ->when(
                                $data['harga_sampai'],
                                fn (Builder $query, $price): Builder => $query->where('total_harga', '<=', $price),
                            );
                    })
                    ->label('Filter Harga'),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->label('Filter Tanggal'),

                TernaryFilter::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->placeholder('Semua Transaksi')
                    ->trueLabel('Ada Bukti Pembayaran')
                    ->falseLabel('Belum Ada Bukti')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('bukti_pembayaran'),
                        false: fn (Builder $query) => $query->whereNull('bukti_pembayaran'),
                    )
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat Detail')
                    ->icon('heroicon-o-eye')
                    ->color('info'),
                    
                Action::make('view_payment_proof')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('primary')
                    ->visible(fn ($record) => $record->bukti_pembayaran)
                    ->modalHeading('Bukti Pembayaran')
                    ->modalContent(function ($record) {
                        return view('filament.modals.payment-proof', ['record' => $record]);
                    })
                    ->modalWidth(MaxWidth::Large),
                    
                Action::make('approve_payment')
                    ->label('Terima Pembayaran')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => $record->status_pembayaran === 'menunggu_verifikasi')
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pembayaran')
                    ->modalDescription('Apakah Anda yakin ingin menerima pembayaran ini? Pesanan akan diproses.')
                    ->modalSubmitActionLabel('Ya, Terima Pembayaran')
                    ->action(function ($record) {
                        $record->update([
                            'status_pembayaran' => 'dibayar',
                            'admin_notes' => ($record->admin_notes ?? '') . "\n[" . now()->format('d/m/Y H:i') . "] Pembayaran diterima oleh admin."
                        ]);
                        
                        Notification::make()
                            ->title('Pembayaran Diterima')
                            ->body('Pembayaran untuk pesanan ' . $record->invoice_number . ' telah diterima.')
                            ->success()
                            ->send();
                    }),
                    
                Action::make('reject_payment')
                    ->label('Tolak Pembayaran')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status_pembayaran === 'menunggu_verifikasi')
                    ->form([
                        Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->placeholder('Masukkan alasan penolakan pembayaran...')
                            ->rows(3)
                    ])
                    ->modalHeading('Tolak Pembayaran')
                    ->modalDescription('Berikan alasan penolakan pembayaran ini.')
                    ->modalSubmitActionLabel('Ya, Tolak Pembayaran')
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status_pembayaran' => 'ditolak',
                            'admin_notes' => ($record->admin_notes ?? '') . "\n[" . now()->format('d/m/Y H:i') . "] Pembayaran ditolak: " . $data['rejection_reason']
                        ]);
                        
                        Notification::make()
                            ->title('Pembayaran Ditolak')
                            ->body('Pembayaran untuk pesanan ' . $record->invoice_number . ' telah ditolak.')
                            ->warning()
                            ->send();
                    }),
                    
                Tables\Actions\EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Bulk actions removed for security
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
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $pendingCount = static::getModel()::where('status_pembayaran', 'menunggu_verifikasi')->count();
        
        if ($pendingCount > 0) {
            return (string) $pendingCount;
        }
        
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $pendingCount = static::getModel()::where('status_pembayaran', 'menunggu_verifikasi')->count();
        
        if ($pendingCount > 0) {
            return 'warning';
        }
        
        return 'primary';
    }
    
    public static function getNavigationBadgeTooltip(): ?string
    {
        $pendingCount = static::getModel()::where('status_pembayaran', 'menunggu_verifikasi')->count();
        $totalCount = static::getModel()::count();
        
        if ($pendingCount > 0) {
            return "{$pendingCount} transaksi menunggu verifikasi dari {$totalCount} total transaksi";
        }
        
        return "{$totalCount} total transaksi";
    }

    }