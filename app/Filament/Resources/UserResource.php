<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $label = 'Usuário';
    protected static ?string $pluralLabel = 'Usuários';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nome')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('password')
                ->label('Senha')
                ->password()
                ->dehydrated(fn ($state) => filled($state))
                ->required(fn (string $context): bool => $context === 'create')
                ->maxLength(255),

            Select::make('role')
                ->label('Função')
                ->options([
                    'admin' => 'Administrador',
                    'user' => 'Usuário',
                ])
                ->required(),

            Select::make('papel')
                ->label('Papel exibido na topbar')
                ->options([
                    'Gestor(a)' => 'Gestor(a)',
                    'Médico(a)' => 'Médico(a)',
                    'Enfermeiro(a)' => 'Enfermeiro(a)',
                    'Outro' => 'Outro',
                ]),

            TextInput::make('unidade')
                ->label('Unidade de saúde')
                ->placeholder('Ex.: UBS Central')
                ->maxLength(120),

            DatePicker::make('created_at')
                ->label('Criado em')
                ->disabled(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('name')->label('Nome')->sortable()->searchable(),
            TextColumn::make('email')->label('E-mail')->sortable()->searchable(),
            TextColumn::make('papel')->label('Papel')->sortable(),
            TextColumn::make('unidade')->label('Unidade')->sortable(),
            TextColumn::make('role')->label('Função')->sortable(),
            TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y H:i'),
        ]);
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
