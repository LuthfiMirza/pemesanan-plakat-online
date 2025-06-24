<?php

namespace App\Filament\Resources\PlakatResource\Pages;

use App\Filament\Resources\PlakatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlakats extends ListRecords
{
    protected static string $resource = PlakatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
