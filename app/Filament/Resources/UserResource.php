<?php

namespace App\Filament\Resources;

use livewire;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Kantor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Pages\Actions\EditAction;
use Spatie\Permission\Traits\HasRoles;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Testing\Fluent\Concerns\Has;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    use HasRoles;
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'User';

    protected static ?string $navigationGroup = 'Setting';

    protected static ?int $navigationSort = 21;

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();
        if ($user->hasRole('userao')) {

            return false;
        } else {

            return true;
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('User')
                    ->icon('heroicon-m-user')
                    ->schema([
                        TextInput::make('name')
                            ->Label('Nama')->required(),
                        TextInput::make('username')
                            ->Label('Username')->required(),
                        TextInput::make('email')
                            ->Label('Email')->required(),
                        TextInput::make('password')->Label('Password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            //->required(fn (Page $livewire): bool => $livewire instanceof CreateRecord) // Adds validation to ensure the field is required
                            ->required(fn (string $context): bool => $context === 'create')
                            ->markAsRequired(false),
                        Select::make('kantor_id')
                            ->label('Kantor')
                            ->options(Kantor::all()->pluck('nama_kantor', 'id'))
                            ->searchable(),
                        Select::make('roles')
                            ->multiple()
                            ->relationship('roles', 'name')->preload(),

                    ])
                    ->columns(3),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex(),
                TextColumn::make('name')->label('Nama User')->sortable()->searchable(),
                TextColumn::make('username')->label('Username')->sortable()->searchable(),
                TextColumn::make('email')->label('Email')->sortable()->searchable(),
                TextColumn::make('kantor.nama_kantor')->label('Kantor')->sortable()->searchable(),
                TextColumn::make('roles.name')->label('Roles')->sortable()->searchable()
            ])
            ->filters([
                SelectFilter::make('kantor_id')
                    ->label('Kantor')
                    ->options([
                        '1' => 'Pusat',
                        '2' => 'Cab. Cisalak',
                        '3' => 'Cab. KPO',
                        '4' => 'Cab. Subang',
                        '5' => 'Cab. Purwadadi',
                        '6' => 'Cab. Pamanukan',
                    ]),
                SelectFilter::make('roles')
                    ->label('Roles')
                    ->multiple()
                    ->relationship('roles', 'name')->preload(),

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
            ->striped();
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
