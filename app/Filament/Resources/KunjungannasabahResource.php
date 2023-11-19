<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Kantor;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Kunjungannasabah;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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
    
    protected static ?string $modelLabel = 'Form Kunjungan Nasabah';

    protected static ?int $navigationSort = 11;

 
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Form Kunjungan Nasabah')
                ->schema([
                    DatePicker::make('tgl_kunjungan')->required()
                    ->label('Tanggal Kunjungan'),
                    TextInput::make('no_rekening')->required()
                    ->label('No. Rekening')
                    ->autocapitalize(),
                    TextInput::make('nama_nasabah')->required()
                    ->label('Nama Nasabah'), 
                    Select::make('kolektibilitas')
                    ->options([
                        'L' => 'L',
                        'DPK' => 'DPK',
                        'KL' => 'KL',
                        'D' => 'D',
                        'M' => 'M',
                    ])->native(false),
                    TextInput::make('no_tlp_nasabah')->required()
                    ->label('No. Telepon Nasabah'),
                    TextInput::make('lokasi')->required()
                    ->label('Peta Lokasi')
                    ->placeholder('Contoh: -6.678209, 107.687488'),
                    Textarea::make('hasil')->required()
                    ->label('Hasil/Keterangan'),
                    FileUpload::make('poto')->directory('potokunjungan')
                    ->preserveFilenames(),
                    Hidden::make('user_id')                    
                    ->default(auth()->user()->id),
                    Hidden::make('kantor_id')                    
                    ->default(auth()->user()->kantor_id)
                ])
                ->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                ->rowIndex(),
                TextColumn::make('kantor.nama_kantor')->sortable()->searchable(),
                TextColumn::make('tgl_kunjungan')->label('Tanggal')->date('d/m/Y')->sortable()->searchable(),
                TextColumn::make('no_rekening')->label('No. Rekening')->sortable()->searchable(),
                TextColumn::make('nama_nasabah')->label('Nama Nasabah')->sortable()->searchable(),
                TextColumn::make('kolektibilitas')->label('Kolek')->sortable()->searchable(),
                TextColumn::make('no_tlp_nasabah')->label('No. Telepon')->searchable(),
                TextColumn::make('hasil')->label('Hasil/Ket.')->searchable(),
                TextColumn::make('lokasi')->label('Peta Lokasi'),
                ImageColumn::make('poto')
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
