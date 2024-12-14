<?php

namespace App\Filament\Resources\KunjungannasabahResource\Pages;

use Filament\Actions;
use App\Models\Kunjungannasabah;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\KunjungannasabahResource;
use Illuminate\Support\Carbon;

class ListKunjungannasabahs extends ListRecords
{
    //use HasRoles;
    protected static string $resource = KunjungannasabahResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {

        // Start with the base query

        $query = Kunjungannasabah::query();

        // Apply conditions based on user roles

        if (Auth::user()->hasRole('adminpanel')) {

            $query->where('kantor_id', Auth::user()->kantor_id)->limit(10);
        } elseif (Auth::user()->hasRole('userao')) {

            $query->where('user_id', Auth::user()->id)->limit(10);
        } elseif (Auth::user()->hasRole('admin')) {

            // For admin, you can limit the results

            // Note: You can also remove the limit if you want to return all records

            $query->limit(10);
        }
        return $query;
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua Data'),
            'Data Hari ini' => Tab::make('Data Hari ini')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tgl_kunjungan', '=', Carbon::now()->format('Y-m-d'))),
            'Data Minggu ini' => Tab::make('Data Minggu ini')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tgl_kunjungan', '>=', Carbon::now()->subWeek()->format('Y-m-d'))),
            'Data Bulan ini' => Tab::make('Data Bulan ini')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tgl_kunjungan', '>=', Carbon::now()->subMonth()->format('Y-m-d'))),
            'Data Tahun ini' => Tab::make('Data Tahun ini')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('tgl_kunjungan', '>=', Carbon::now()->subYear()->format('Y-m-d'))),
        ];
    }
}
