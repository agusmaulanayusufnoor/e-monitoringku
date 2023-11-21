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
use Spatie\Permission\Traits\HasRoles;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Pages\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
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

    protected static ?int $navigationSort = 31;

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
                            ->relationship('roles','name'),

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
                TextColumn::make('name')->label('Nama User'),
                TextColumn::make('username')->label('Username'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('kantor.nama_kantor')->label('Kantor'),
                TextColumn::make('roles.name')->label('Roles')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
