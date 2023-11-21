<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Kantor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Section;
use Spatie\Permission\Traits\HasRoles;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\KantorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KantorResource\RelationManagers;

class KantorResource extends Resource
{
    use HasRoles;
    protected static ?string $model = Kantor::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Kantor';

    protected static ?string $navigationGroup = 'Setting';

    protected static ?int $navigationSort = 32;
    //protected static bool $shouldRegisterNavigation = false;


    // public static function shouldRegisterNavigation():bool
    // {
    //     $user = auth()->user();
    //     if ($user->hasRole('userao')){
    //         echo "userao";
    //     return true;
    //     }

    //     else {
    //         echo "bukanao";
    //         return false;
    //     }


    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('kode_kantor'),
                    TextInput::make('nama_kantor')  // ...
                ])
                ->columns(2),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                ->rowIndex(),
                TextColumn::make('kode_kantor'),
                TextColumn::make('nama_kantor')
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
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {

        return [
            'index' => Pages\ManageKantors::route('/'),
        ];
    }
}
