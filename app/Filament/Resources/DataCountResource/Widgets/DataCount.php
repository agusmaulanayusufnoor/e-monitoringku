<?php

namespace App\Filament\Resources\DataCountResource\Widgets;

use App\Models\User;
use App\Models\Kantor;
use App\Models\Kunjungannasabah;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DataCount extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('User', User::count())
                ->description('User yang terdaftar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Kantor', Kantor::count())
                ->description('Kantor yang terdaftar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),
            Stat::make('Form Nasabah', Kunjungannasabah::where('kantor_id',auth()->user()->kantor_id)->count())
                ->description('Form Nasabah Kantor Cabang')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
            Stat::make('Jumlah Form Nasabah', Kunjungannasabah::count())
                ->description('Form Nasabah Semua Kantor')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger'),
        ];
    }
}
