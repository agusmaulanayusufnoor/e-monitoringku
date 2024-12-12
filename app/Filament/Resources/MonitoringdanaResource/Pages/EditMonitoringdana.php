<?php

namespace App\Filament\Resources\MonitoringdanaResource\Pages;

use App\Filament\Resources\MonitoringdanaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonitoringdana extends EditRecord
{
    protected static string $resource = MonitoringdanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
