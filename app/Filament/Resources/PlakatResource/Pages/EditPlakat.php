<?php

namespace App\Filament\Resources\PlakatResource\Pages;

use App\Filament\Resources\PlakatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlakat extends EditRecord
{
    protected static string $resource = PlakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
