<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Carbon;
use App\Models\Monitoringdana;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
// use Filament\Support\Facades\FilamentAsset;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
// use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Filament\Resources\MonitoringdanaResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
// use App\Filament\Resources\MonitoringdanaResource\RelationManagers;
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

        return $form
            ->schema([
                Section::make('Form Kunjungan Nasabah Dana')
                    ->schema([
                        DatePicker::make('tgl_kunjungan')->required()
                            ->label('Tanggal Kunjungan'),
                        TextInput::make('jml_noa')->required()
                            ->default(0)
                            ->label('Jumlah NOA'),
                        TextInput::make('jml_setoran')->required()
                            ->label('Jumlah Setoran')
                            ->default(0)
                            ->id('jml_setoran')
                            ->prefix('Rp'),
                        TextInput::make('jml_noa_baru')->required()
                            ->label('Jumlah NOA Baru')
                            ->default(0),
                        TextInput::make('jml_setoran_baru')->required()
                            ->label('Jumlah Setoran Baru')
                            ->id('jml_setoran_baru')
                            ->default(0)
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
                // TextColumn::make('No.')
                // ->rowIndex(),
                // TextColumn::make('No.')->state(
                //     static function (HasTable $livewire, stdClass $rowLoop): string {
                //         return (string) (
                //             $rowLoop->iteration +
                //             ($livewire->getTableRecordsPerPage() * (
                //                 $livewire->getTablePage() - 1
                //             ))
                //         );
                //     }
                // ),
                // TextColumn::make('index'),
                TextColumn::make('kantor.nama_kantor')->sortable()->searchable(),
                TextColumn::make('user.name')->label('Nama AO')->sortable()->searchable(),
                TextColumn::make('tgl_kunjungan')->label('Tanggal')->date('d/m/Y')->sortable()->searchable(),
                TextColumn::make('jml_noa')->label('Jmlah NoA')->sortable()->searchable(),
                TextColumn::make('jml_setoran')->label('Jumlah Setoran')->sortable()->searchable(),
                TextColumn::make('jml_noa_baru')->label('Jmlah NoA')->sortable()->searchable(),
                TextColumn::make('jml_setoran_baru')->label('Jumlah Setoran Baru')->sortable()->searchable(),

            ])
            ->defaultSort('id', 'desc')

            ->filters([
                Filter::make('tgl_kunjungan')
                    ->form([
                        DatePicker::make('dari_tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('sampai_tanggal')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                 
                        if ($data['dari_tanggal'] ?? null) {
                            $indicators[] = Indicator::make('Dari Tanggal ' . Carbon::parse($data['dari_tanggal'])->toFormattedDateString())
                                ->removeField('dari_tanggal');
                        }
                 
                        if ($data['sampai_tanggal'] ?? null) {
                            $indicators[] = Indicator::make('Sampai Tanggal ' . Carbon::parse($data['sampai_tanggal'])->toFormattedDateString())
                                ->removeField('sampai_tanggal');
                        }
                 
                        return $indicators;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_kunjungan', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_kunjungan', '<=', $date),
                            );
                    }),
                SelectFilter::make('kantor_id')
                    ->label('Kantor')
                    ->options([
                        '1' => 'Pusat',
                        '2' => 'Cab. Cisalak',
                        '3' => 'Cab. KPO',
                        '4' => 'Cab. Subang',
                        '5' => 'Cab. Purwadadi',
                        '6' => 'Cab. Pamanukan',
                    ])
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    // ExportAction::make()->exports([
                    //     ExcelExport::make('table')->fromTable()->askForFilename(),
                    //     ExcelExport::make('form')->fromForm(),
                    // ])->label('Ekspor Excel')
                ]),
                // Tables\Actions\ViewAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()->exports([
                        ExcelExport::make('table')->fromTable()
                            ->askForFilename()
                            ->withWriterType(Excel::XLSX),
                        //ExcelExport::make('form')->fromForm(),
                    ])->label('Ekspor Excel'),

                    Tables\Actions\DeleteBulkAction::make(),
                ]),

                // Tables\Actions\BulkActionGroup::make([
                //     ExportBulkAction::make()->label("Export Excel"),
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])
            ->striped()
            ->paginated([10, 25, 50, 100, 'all']);
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

