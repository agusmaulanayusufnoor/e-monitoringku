<?php

namespace App\Filament\Resources\KunjungannasabahResource\Pages;

use App\Filament\Resources\KunjungannasabahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKunjungannasabahs extends ListRecords
{
    protected static string $resource = KunjungannasabahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
