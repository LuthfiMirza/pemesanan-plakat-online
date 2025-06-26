<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Pengguna')
                ->icon('heroicon-o-plus'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Pengguna')
                ->badge(fn () => \App\Models\User::count()),
            
            'users' => Tab::make('User')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'user'))
                ->badge(fn () => \App\Models\User::where('role', 'user')->count()),
            
            'admins' => Tab::make('Admin')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'admin'))
                ->badge(fn () => \App\Models\User::where('role', 'admin')->count()),
            
            'verified' => Tab::make('Terverifikasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('email_verified_at'))
                ->badge(fn () => \App\Models\User::whereNotNull('email_verified_at')->count()),
            
            'unverified' => Tab::make('Belum Terverifikasi')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereNull('email_verified_at'))
                ->badge(fn () => \App\Models\User::whereNull('email_verified_at')->count()),
        ];
    }
}
