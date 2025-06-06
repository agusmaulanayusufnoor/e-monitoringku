<?php

namespace App\Filament\Resources;

use stdClass;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Kantor;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Carbon;
use App\Models\Kunjungannasabah;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\Indicator;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\Summarizers\Sum;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\KunjungannasabahResource\Pages;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Filament\Resources\KunjungannasabahResource\RelationManagers;

class KunjungannasabahResource extends Resource
{

    protected static ?string $model = Kunjungannasabah::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Kunjungan Nasabah Kredit';

    protected static ?string $navigationGroup = 'Monitoring Bisnis';

    protected static ?string $modelLabel = 'Form Kunjungan Nasabah Kredit';

    protected static ?int $navigationSort = 11;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Form Kunjungan Nasabah Kredit')
                    ->schema([
                        DatePicker::make('tgl_kunjungan')->required()
                            ->label('Tanggal Kunjungan'),
                        TextInput::make('no_rekening')->required()
                            ->label('No. Rekening')
                            ->autocapitalize()
                            ->rules(['required', 'min:12', 'max:14'])
                            ->validationMessages([
                                'min' => 'no rekening tidak boleh kurang dari 12 digit',
                                'max' => 'no rekening tidak boleh lebih dari 14 digit',
                            ]),
                        TextInput::make('nama_nasabah')->required()
                            ->label('Nama Nasabah'),
                        Select::make('kolektibilitas')->required()
                            ->validationMessages([
                                'required' => 'Kolek belum dipilih',
                            ])
                            ->options([
                                'L' => 'L',
                                'DPK' => 'DPK',
                                'KL' => 'KL',
                                'D' => 'D',
                                'M' => 'M',
                                'HB' => 'HB',
                            ])->native(false),
                        TextInput::make('no_tlp_nasabah')->required()
                            ->label('No. Telepon Nasabah'),
                        TextInput::make('lokasi')->required()
                            ->label('Peta Lokasi')
                            ->placeholder('Contoh: -6.678209, 107.687488'),
                        Textarea::make('hasil')->required()
                            ->label('Hasil/Keterangan'),
                        FileUpload::make('poto')
                            ->required()
                            ->validationMessages([
                                'required' => 'Poto belum diupload',
                            ])
                            ->label('Poto Kunjungan')
                            ->image()
                            ->downloadable()
                            ->directory('potokunjungan')
                            ->preserveFilenames(false)  // Menonaktifkan penggunaan nama asli file
                            ->getUploadedFileNameForStorageUsing(
                                fn(TemporaryUploadedFile $file): string => (string) str(uniqid('kunjungan_', true) . '.' . $file->getClientOriginalName())
                                    ->prepend('poto-'),
                            ),
                            TextInput::make('jml_setor')->required()
                            ->label('Jumlah Setoran')
                            ->numeric()
                            ->rules(['required', 'min:0'])
                            ->placeholder('Masukkan hanya angka')
                            ->helperText('Jumlah setoran dalam IDR')
                            ->columnSpanFull()
                            ->extraInputAttributes(['autocomplete' => 'off'])
                            ->extraInputAttributes(['inputmode' => 'numeric'])
                            ->extraInputAttributes(['pattern' => '[0-9]*'])
                            ->extraInputAttributes(['oninput' => 'this.value = this.value.replace(/[^0-9]/g, "")'])
                            ->extraInputAttributes(['onkeydown' => 'if(event.keyCode == 69 || event.keyCode == 189 || event.keyCode == 190) return false;'])
                            ->extraInputAttributes(['onpaste' => 'return false'])
                            ->extraInputAttributes(['oncopy' => 'return false'])
                            ->extraInputAttributes(['oncut' => 'return false'])
                            ->extraInputAttributes(['onblur' => 'if(this.value == "") this.value = "0";'])
                            ->extraInputAttributes(['onfocus' => 'if(this.value == "0") this.value = "";'])
                            ->extraInputAttributes(['onkeyup' => 'this.value = this.value.replace(/[^0-9]/g, "")'])
                            ->extraInputAttributes(['autocomplete' => 'off'])
                            ->extraInputAttributes(['inputmode' => 'numeric'])
                            ->extraInputAttributes(['pattern' => '[0-9]*'])
                            ->extraInputAttributes(['oninput' => 'this.value = this.value.replace(/[^0-9]/g, "")'])
                            ->extraInputAttributes(['onkeydown' => 'if(event.keyCode == 69 || event.keyCode == 189 || event.keyCode == 190) return false;'])
                            ->extraInputAttributes(['onpaste' => 'return false'])
                            ->extraInputAttributes(['oncopy' => 'return false'])
                            ->extraInputAttributes(['oncut' => 'return false'])
                            ->extraInputAttributes(['onblur' => 'if(this.value == "") this.value = "0";'])
                            ->extraInputAttributes(['onfocus' => 'if(this.value == "0") this.value = "";'])
                            ->extraInputAttributes(['onkeyup' => 'this.value = this.value.replace(/[^0-9]/g, "")'])
                            ->minValue(0)
                            ->maxValue(999999999999)
                            ->step(1000)
                            ->default(0)
                            ->id('jml_setor')
                            ->prefix('Rp'),

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
                TextColumn::make('no')
                    ->label('No.')
                    ->rowIndex(),
                TextColumn::make('kantor.nama_kantor')->sortable()->searchable(),
                TextColumn::make('user.name')->label('Nama AO')->sortable()->searchable(),
                TextColumn::make('tgl_kunjungan')->label('Tanggal')->date('d/m/Y')->sortable()->searchable(),
                TextColumn::make('no_rekening')->label('No. Rekening')->sortable()->searchable(),
                TextColumn::make('nama_nasabah')->label('Nama Nasabah')->sortable()->searchable(),
                TextColumn::make('kolektibilitas')->label('Kolek')->sortable()->searchable(),
                TextColumn::make('no_tlp_nasabah')->label('No. Telepon')->searchable(),
                TextColumn::make('hasil')->label('Hasil/Ket.')->searchable(),
                TextColumn::make('lokasi')->label('Peta Lokasi'),
                //ImageColumn::make('poto'),
                TextColumn::make('jml_setor')->label('Jumlah Setoran')
                ->money('IDR', locale: 'id')
                ->summarize(Sum::make()->label('Total Setoran'))
                ->sortable()->searchable(),
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
                    ->options(Kantor::orderBy('id', 'asc')->pluck('nama_kantor', 'id')->toArray()),
                    // ->options([
                    //     '1' => 'Pusat',
                    //     '2' => 'Cab. Cisalak',
                    //     '3' => 'Cab. KPO',
                    //     '4' => 'Cab. Subang',
                    //     '5' => 'Cab. Purwadadi',
                    //     '6' => 'Cab. Pamanukan',
                    // ]),
                SelectFilter::make('kolektibilitas')
                    ->options([
                        'L' => 'L',
                        'DPK' => 'DPK',
                        'KL' => 'KL',
                        'D' => 'D',
                        'M' => 'M',
                        'HB' => 'HB',
                    ])
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make()
                        ->action(function ($record) {
                            // Menghapus file gambar sebelum menghapus data secara permanen
                            $filePath = 'potokunjungan/' . $record->poto;
                            if (Storage::disk('public')->exists($filePath)) {
                                Storage::disk('public')->delete($filePath);
                            }

                            // Menghapus data secara permanen menggunakan forceDelete
                            $record->forceDelete();
                        }),
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
                            ->withWriterType(Excel::XLSX)
                            ->only(
                                [
                                    'kantor.nama_kantor',
                                    'user.name',
                                    'tgl_kunjungan',
                                    'no_rekening',
                                    'nama_nasabah',
                                    'kolektibilitas',
                                    'no_tlp_nasabah',
                                    'hasil',
                                    'lokasi',
                                    'jml_setor',
                                ]
                            ),

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
    /**
     * Get the row number for the table.
     *
     * @param  HasTable  $table
     * @return int
     */
   
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
