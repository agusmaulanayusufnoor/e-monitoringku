<?php

namespace App\Filament\Resources\KunjungannasabahResource\Pages;

use Filament\Actions;
use Illuminate\Support\Carbon;
use App\Models\Kunjungannasabah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Filament\Resources\Components\Tab;
use Spatie\Permission\Traits\HasRoles;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use App\Filament\Resources\KunjungannasabahResource;

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
    protected function paginateTableQuery(Builder $query): Paginator
{
    $perPage = ($this->getTableRecordsPerPage() === 'all') ? 1000 : $this->getTableRecordsPerPage(); // Batasi per halaman

    return $query->fastPaginate($perPage);
}

    protected function getTableQuery(): Builder
    {
            $query = Kunjungannasabah::query();

            // Apply conditions based on user roles
            if (Auth::user()->hasRole('adminpanel')) {
                $query->where('kantor_id', Auth::user()->kantor_id);
            } elseif (Auth::user()->hasRole('userao')) {
                $query->where('user_id', Auth::user()->id);
            } elseif (Auth::user()->hasRole('admin')) {
                // Admin can see all records
            }

            // Ambil hasil query
            return $query; // Mengambil hasil query

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
