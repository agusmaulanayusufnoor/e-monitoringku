<?php

namespace App\Filament\Resources\MonitoringdanaResource\Pages;

use App\Filament\Resources\MonitoringdanaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonitoringdanas extends ListRecords
{
    protected static string $resource = MonitoringdanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
