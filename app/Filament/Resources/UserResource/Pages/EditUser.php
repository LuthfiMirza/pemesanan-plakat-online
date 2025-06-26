<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Lihat'),
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->requiresConfirmation()
                ->modalHeading('Hapus Pengguna')
                ->modalDescription('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Set email_verified based on email_verified_at
        $data['email_verified'] = !is_null($data['email_verified_at']);
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Handle email verification
        if (isset($data['email_verified']) && $data['email_verified']) {
            $data['email_verified_at'] = $data['email_verified_at'] ?? now();
        } else {
            $data['email_verified_at'] = null;
        }

        // Remove the email_verified field as it's not in the database
        unset($data['email_verified']);

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Pengguna berhasil diperbarui';
    }
}
