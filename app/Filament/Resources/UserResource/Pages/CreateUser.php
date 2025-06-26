<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Handle email verification
        if (isset($data['email_verified']) && $data['email_verified']) {
            $data['email_verified_at'] = now();
        } else {
            $data['email_verified_at'] = null;
        }

        // Remove the email_verified field as it's not in the database
        unset($data['email_verified']);

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Pengguna berhasil dibuat';
    }
}
