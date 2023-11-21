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

        if (Auth::user()->hasRole('adminpanel')){
            return Kunjungannasabah::where('kantor_id',Auth::user()->kantor_id);
        }
       else if (Auth::user()->hasRole('userao')){
        return Kunjungannasabah::where('user_id',Auth::user()->id);
       }else{
        $kunjungannasabah = Kunjungannasabah::where('id', '>', 0);
          return $kunjungannasabah;
       }
        //return Kunjungannasabah::where('user_id',Auth::user()->id);

    }
}
