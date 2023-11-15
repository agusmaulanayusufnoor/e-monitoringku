<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Kunjungannasabah;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KunjungannasabahResource\Pages;
use App\Filament\Resources\KunjungannasabahResource\RelationManagers;

class KunjungannasabahResource extends Resource
{
    protected static ?string $model = Kunjungannasabah::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Form Kunjungan Nasabah';

    protected static ?string $navigationGroup = 'Monitoring Bisnis';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Form Kunjungan Nasabah')
                ->schema([
                    DatePicker::make('tgl_kunjungan')
                    ->label('Tanggal Kunjungan'),
                    TextInput::make('no_rekening')
                    ->label('No. Rekening'),
                    TextInput::make('nama_nasabah')
                    ->label('Nama Nasabah')  // ...
                ])
                ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKunjungannasabahs::route('/'),
            'create' => Pages\CreateKunjungannasabah::route('/create'),
            'edit' => Pages\EditKunjungannasabah::route('/{record}/edit'),
        ];
    }
}
