<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Monitoringdana;
use Filament\Facades\Filament;
use Filament\Support\Assets\Js;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Facades\FilamentAsset;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MonitoringdanaResource\Pages;
use App\Filament\Resources\MonitoringdanaResource\RelationManagers;
use App\Filament\Resources\MonitoringdanaResource\Pages\EditMonitoringdana;
use App\Filament\Resources\MonitoringdanaResource\Pages\ListMonitoringdanas;
use App\Filament\Resources\MonitoringdanaResource\Pages\CreateMonitoringdana;

class MonitoringdanaResource extends Resource
{
    protected static ?string $model = Monitoringdana::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationLabel = 'Kunjungan Nasabah Dana';

    protected static ?string $navigationGroup = 'Monitoring Bisnis';

    protected static ?string $modelLabel = 'Form Kunjungan Nasabah Dana';

    protected static ?int $navigationSort = 12;


    public static function form(Form $form): Form
    {
        FilamentAsset::register([
            Js::make('custom-script', __DIR__ . '/../../resources/js/textinput.js'),
        ]);
        return $form
            ->schema([
                Section::make('Form Kunjungan Nasabah Dana')
                    ->schema([
                        DatePicker::make('tgl_kunjungan')->required()
                            ->label('Tanggal Kunjungan'),
                        TextInput::make('jml_noa')->required()
                            ->label('Jumlah NOA'),
                        TextInput::make('jml_setoran')->required()
                            ->label('Jumlah Setoran')
                            ->id('jml_setoran')
                            ->prefix('Rp'),
                        TextInput::make('jml_noa_baru')->required()
                            ->label('Jumlah NOA Baru'),
                        TextInput::make('jml_setoran_baru')->required()
                            ->label('Jumlah Setoran Baru')
                            ->prefix('Rp'),
                        Hidden::make('user_id')
                            ->default(auth()->user()->id),
                        Hidden::make('kantor_id')
                            ->default(auth()->user()->kantor_id)
                    ])->columns(3),
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
            'index' => Pages\ListMonitoringdanas::route('/'),
            'create' => Pages\CreateMonitoringdana::route('/create'),
            'edit' => Pages\EditMonitoringdana::route('/{record}/edit'),
        ];
    }
}

