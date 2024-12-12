<?php

namespace App\Filament\Resources\KunjungannasabahResource\Pages;

use Filament\Actions;
use App\Models\Kunjungannasabah;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
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
}
