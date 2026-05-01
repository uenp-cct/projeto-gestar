<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GestanteResource\Pages;
use App\Models\Atendimento;
use App\Models\Gestante;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GestanteResource extends Resource
{
    protected static ?string $model = Gestante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Pacientes';
    protected static ?string $modelLabel = 'Paciente';
    protected static ?string $pluralModelLabel = 'Pacientes';
    protected static ?int $navigationSort = 2;

    public static function getGloballySearchableAttributes(): array
    {
        return ['nome', 'numero_sus'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'SUS' => $record->numero_sus ?: '—',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('Identificação')
                ->columns(2)
                ->schema([
                    TextInput::make('nome')->label('Nome completo')->required()->columnSpan(2),
                    TextInput::make('numero_sus')->label('Cartão SUS')->maxLength(20),
                    DatePicker::make('data_nascimento')->label('Data de nascimento'),
                    Select::make('gestor_id')
                        ->label('Gestor(a)')
                        ->relationship('gestor', 'name')
                        ->searchable()
                        ->preload(),
                    Select::make('medico_id')
                        ->label('Médico(a)')
                        ->relationship('medico', 'name')
                        ->searchable()
                        ->preload(),
                ]),

            Section::make('Contato e endereço')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextInput::make('endereco')->label('Endereço'),
                    TextInput::make('numero')->label('Número'),
                    TextInput::make('bairro')->label('Bairro'),
                    TextInput::make('fone')->label('Telefone'),
                    TextInput::make('email')->label('E-mail')->email()->columnSpan(2),
                ]),

            Section::make('Antecedentes pessoais e familiares')
                ->collapsed()
                ->schema([
                    Forms\Components\CheckboxList::make('problemas_saude_pessoais')
                        ->label('Problemas de saúde pessoais')
                        ->options([
                            'hipertensao' => 'Hipertensão',
                            'diabetes' => 'Diabetes',
                            'cardiopatia' => 'Cardiopatia',
                            'doenca_renal' => 'Doença renal',
                            'tireoide' => 'Tireoide',
                            'outras' => 'Outras',
                        ])
                        ->columns(2),
                    Toggle::make('alergia')->label('Possui alergia?'),
                    TextInput::make('alergia_qual')->label('Quais alergias?')->visible(fn ($get) => $get('alergia')),
                    Toggle::make('medicamento_diario')->label('Usa medicamento diário?'),
                    TextInput::make('medicamento_qual')->label('Qual?')->visible(fn ($get) => $get('medicamento_diario')),
                    Forms\Components\CheckboxList::make('problemas_saude_familia')
                        ->label('Problemas de saúde na família')
                        ->options([
                            'hipertensao' => 'Hipertensão',
                            'diabetes' => 'Diabetes',
                            'cardiopatia' => 'Cardiopatia',
                            'cancer' => 'Câncer',
                            'outras' => 'Outras',
                        ])
                        ->columns(2),
                ]),

            Section::make('Histórico ginecológico e obstétrico')
                ->columns(2)
                ->collapsed()
                ->schema([
                    TextInput::make('numero_gestacoes')->label('Número de gestações')->numeric(),
                    TextInput::make('partos_normal')->label('Partos normais')->numeric(),
                    TextInput::make('partos_cesaria')->label('Partos cesárea')->numeric(),
                    TextInput::make('numero_abortos')->label('Abortos')->numeric(),
                    Textarea::make('qual_intercorrencia_gestacao')->label('Intercorrências em gestações anteriores')->columnSpanFull(),
                ]),

            Section::make('Gestação atual')
                ->columns(2)
                ->collapsed()
                ->schema([
                    DatePicker::make('dum')->label('DUM'),
                    DatePicker::make('dpp_dum')->label('DPP (DUM)'),
                    DatePicker::make('dpp_usg')->label('DPP (USG)'),
                    Toggle::make('gestacao_planejada')->label('Gestação planejada?'),
                    Select::make('estratificacao_risco')
                        ->label('Estratificação de risco inicial')
                        ->options(Atendimento::RISCOS),
                    Textarea::make('condicao_risco')->label('Condições/observações de risco')->columnSpanFull(),
                    Textarea::make('sinais_sintomas')->label('Sinais e sintomas relevantes')->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')->label('Nome')->searchable()->sortable(),
                TextColumn::make('numero_sus')->label('SUS')->searchable()->toggleable(),
                TextColumn::make('data_nascimento')->label('Nascimento')->date('d/m/Y')->sortable(),
                TextColumn::make('gestor.name')->label('Gestor(a)')->toggleable(),
                BadgeColumn::make('estratificacao_risco')
                    ->label('Risco inicial')
                    ->formatStateUsing(fn ($state) => Atendimento::RISCOS[$state] ?? '—')
                    ->colors([
                        'success' => Atendimento::RISCO_HABITUAL,
                        'warning' => Atendimento::RISCO_INTERMEDIARIO,
                        'danger' => Atendimento::RISCO_ALTO,
                    ]),
                TextColumn::make('atendimentos_count')
                    ->counts('atendimentos')
                    ->label('Atendimentos'),
                TextColumn::make('created_at')->label('Cadastrado em')->dateTime('d/m/Y H:i')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('atendimento')
                    ->label('Novo atendimento')
                    ->icon('heroicon-o-document-plus')
                    ->url(fn (Gestante $record): string => AtendimentoResource::getUrl('create', [
                        'tableFilters[gestante_id][value]' => $record->id,
                    ])),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGestantes::route('/'),
            'create' => Pages\CreateGestante::route('/create'),
            'edit' => Pages\EditGestante::route('/{record}/edit'),
        ];
    }
}
