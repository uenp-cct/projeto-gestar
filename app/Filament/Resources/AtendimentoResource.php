<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtendimentoResource\Pages;
use App\Filament\Resources\AtendimentoResource\Widgets\PressaoArterialChart;
use App\Models\Atendimento;
use App\Models\Gestante;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\View;
use Illuminate\Support\HtmlString;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AtendimentoResource extends Resource
{
    protected static ?string $model = Atendimento::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Atendimentos';
    protected static ?string $modelLabel = 'Atendimento';
    protected static ?string $pluralModelLabel = 'Atendimentos';
    protected static ?int $navigationSort = 1;

    public const VACINAS = [
        'hepatite_b' => 'Hepatite B',
        'influenza' => 'Influenza',
        'dtpa' => 'dTpa',
        'covid_19' => 'Covid-19',
        'outras' => 'Outras',
    ];

    public const EXAMES = [
        'hemograma' => 'Hemograma',
        'glicemia' => 'Glicemia',
        'urina_eas' => 'Urina (EAS)',
        'vdrl' => 'VDRL',
        'hiv' => 'HIV',
        'ultrassonografia' => 'Ultrassonografia',
    ];

    public static function form(Form $form): Form
    {
        return $form
            ->columns([
                'default' => 12,
                'lg' => 12,
            ])
            ->schema([
                Hidden::make('status')->default(Atendimento::STATUS_FINALIZADO),
                Hidden::make('user_id')->default(fn () => auth()->id()),
                Hidden::make('data_atendimento')->default(fn () => now()->toDateString()),

                static::cardIdentificacao()->columnSpan(['default' => 12, 'md' => 6, 'xl' => 2]),
                static::cardAntecedentes()->columnSpan(['default' => 12, 'md' => 6, 'xl' => 2]),
                static::cardHabitos()->columnSpan(['default' => 12, 'md' => 4, 'xl' => 4]),
                static::cardSituacao()->columnSpan(['default' => 12, 'md' => 4, 'xl' => 2]),
                static::cardRisco()->columnSpan(['default' => 12, 'md' => 4, 'xl' => 2]),

                static::cardVacinas()->columnSpan(['default' => 12, 'md' => 6, 'xl' => 4]),
                static::cardExames()->columnSpan(['default' => 12, 'md' => 12, 'xl' => 5]),
                static::cardExameFisico()->columnSpan(['default' => 12, 'md' => 6, 'xl' => 3]),

                static::cardParto()->columnSpan(['default' => 12, 'xl' => 5]),
                static::cardAnotacoes()->columnSpan(['default' => 12, 'xl' => 4]),
                static::cardGrafico()->columnSpan(['default' => 12, 'xl' => 3]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('data_atendimento', 'desc')
            ->columns([
                TextColumn::make('data_atendimento')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('gestante.nome')
                    ->label('Gestante')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gestante.numero_sus')
                    ->label('SUS')
                    ->toggleable()
                    ->searchable(),

                TextColumn::make('tipo_atendimento')
                    ->label('Tipo')
                    ->formatStateUsing(fn ($state) => Atendimento::TIPOS_ATENDIMENTO[$state] ?? '—'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => Atendimento::STATUSES[$state] ?? '—')
                    ->colors([
                        'gray' => Atendimento::STATUS_RASCUNHO,
                        'success' => Atendimento::STATUS_FINALIZADO,
                    ]),

                BadgeColumn::make('estratificacao_risco')
                    ->label('Risco')
                    ->formatStateUsing(fn ($state) => Atendimento::RISCOS[$state] ?? '—')
                    ->colors([
                        'success' => Atendimento::RISCO_HABITUAL,
                        'warning' => Atendimento::RISCO_INTERMEDIARIO,
                        'danger' => Atendimento::RISCO_ALTO,
                    ]),

                TextColumn::make('pa_sistolica')
                    ->label('PA')
                    ->formatStateUsing(fn (Atendimento $record) => $record->pa_sistolica && $record->pa_diastolica
                        ? "{$record->pa_sistolica}/{$record->pa_diastolica}"
                        : '—'),

                TextColumn::make('profissional.name')
                    ->label('Profissional')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('gestante_id')
                    ->label('Gestante')
                    ->relationship('gestante', 'nome')
                    ->searchable()
                    ->preload(),

                SelectFilter::make('estratificacao_risco')
                    ->label('Risco')
                    ->options(Atendimento::RISCOS),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options(Atendimento::STATUSES),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Abrir'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('Nenhum atendimento registrado')
            ->emptyStateDescription('Registre o primeiro atendimento de uma gestante para começar o acompanhamento.');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['gestante', 'profissional']);
    }

    public static function getRecordTitle(?Model $record): ?string
    {
        if (! $record instanceof Atendimento) {
            return null;
        }

        $data = optional($record->data_atendimento)->format('d/m/Y');
        $nome = $record->gestante?->nome;

        return trim(($nome ?? 'Atendimento')." — {$data}");
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAtendimentos::route('/'),
            'create' => Pages\CreateAtendimento::route('/create'),
            'edit' => Pages\EditAtendimento::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            PressaoArterialChart::class,
        ];
    }

    /* ================================================================ */
    /* Cards                                                              */
    /* ================================================================ */

    protected static function cardIdentificacao(): Section
    {
        return Section::make('1. Identificação')
            ->extraAttributes(['class' => 'card-identificacao'])
            ->schema([
                Select::make('gestante_id')
                    ->label('Nome')
                    ->placeholder('Digite o nome da gestante')
                    ->relationship('gestante', 'nome')
                    ->getOptionLabelFromRecordUsing(fn (Gestante $record) => trim(
                        $record->nome.($record->numero_sus ? ' — SUS '.$record->numero_sus : '')
                    ))
                    ->searchable(['nome', 'numero_sus'])
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        $g = $state ? Gestante::with(['gestor', 'medico'])->find($state) : null;
                        $set('_ident_sus', $g?->numero_sus);
                        $set('_ident_gestor', $g?->gestor?->name);
                        $set('_ident_medico', $g?->medico?->name);
                        $set('_ant_pessoais', static::buildAntPessoais($g));
                        $set('_ant_familiares', static::buildAntFamiliares($g));
                        $set('_ant_ginecologicos', static::buildAntGinecologicos($g));
                        $set('_ant_obstetricos', static::buildAntObstetricos($g));
                    })
                    ->afterStateHydrated(function (Set $set, ?string $state) {
                        $g = $state ? Gestante::with(['gestor', 'medico'])->find($state) : null;
                        $set('_ident_sus', $g?->numero_sus);
                        $set('_ident_gestor', $g?->gestor?->name);
                        $set('_ident_medico', $g?->medico?->name);
                        $set('_ant_pessoais', static::buildAntPessoais($g));
                        $set('_ant_familiares', static::buildAntFamiliares($g));
                        $set('_ant_ginecologicos', static::buildAntGinecologicos($g));
                        $set('_ant_obstetricos', static::buildAntObstetricos($g));
                    })
                    ->dehydrated(true),

                TextInput::make('_ident_sus')
                    ->label('SUS')
                    ->placeholder('000 0000 0000 0000')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('_ident_gestor')
                    ->label('Gestor')
                    ->placeholder('—')
                    ->disabled()
                    ->dehydrated(false),

                TextInput::make('_ident_medico')
                    ->label('Médico')
                    ->placeholder('—')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    protected static function cardAntecedentes(): Section
    {
        return Section::make('2. Antecedentes')
            ->extraAttributes(['class' => 'card-antecedentes'])
            ->schema([
                Textarea::make('_ant_pessoais')
                    ->label('Ant. pessoais')
                    ->placeholder('Descreva os antecedentes pessoais')
                    ->rows(2)
                    ->disabled()
                    ->dehydrated(false),

                Textarea::make('_ant_familiares')
                    ->label('Ant. familiares')
                    ->placeholder('Descreva os antecedentes familiares')
                    ->rows(2)
                    ->disabled()
                    ->dehydrated(false),

                Textarea::make('_ant_ginecologicos')
                    ->label('Ant. ginecol.')
                    ->placeholder('Descreva os antecedentes ginecológicos')
                    ->rows(2)
                    ->disabled()
                    ->dehydrated(false),

                Textarea::make('_ant_obstetricos')
                    ->label('Ant. obstétricos')
                    ->placeholder('Descreva os antecedentes obstétricos')
                    ->rows(2)
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    protected static function cardHabitos(): Section
    {
        return Section::make('3. Hábitos de vida')
            ->extraAttributes(['class' => 'card-habitos'])
            ->schema([
                ToggleButtons::make('tabagismo')
                    ->label('Tabagismo')
                    ->options([
                        1 => 'Não',
                        2 => 'Sim',
                        3 => 'Ex-tabagista',
                    ])
                    ->inline()
                    ->grouped(),

                ToggleButtons::make('alcool')
                    ->label('Álcool')
                    ->options([
                        1 => 'Não',
                        2 => 'Sim',
                        3 => 'Socialmente',
                    ])
                    ->inline()
                    ->grouped(),
            ]);
    }

    protected static function cardSituacao(): Section
    {
        return Section::make('4. Situação atual')
            ->extraAttributes(['class' => 'card-situacao'])
            ->schema([
                Textarea::make('situacao_atual')
                    ->label('')
                    ->placeholder('Descreva a situação atual da paciente')
                    ->rows(8),
            ]);
    }

    protected static function cardRisco(): Section
    {
        return Section::make('5. Estratificação de risco')
            ->extraAttributes(['class' => 'card-risco'])
            ->schema([
                Radio::make('estratificacao_risco')
                    ->label('')
                    ->options([
                        Atendimento::RISCO_HABITUAL => 'Habitual',
                        Atendimento::RISCO_INTERMEDIARIO => 'Intermediário',
                        Atendimento::RISCO_ALTO => 'Alto risco',
                    ])
                    ->descriptions([
                        Atendimento::RISCO_HABITUAL => 'Risco habitual',
                        Atendimento::RISCO_INTERMEDIARIO => 'Risco intermediário',
                        Atendimento::RISCO_ALTO => 'Alto risco',
                    ]),
            ]);
    }

    protected static function cardVacinas(): Section
    {
        $statusOptions = [
            'pendente' => 'Pendente',
            'aplicada' => 'Aplicada',
            'nao_aplica' => 'Não se aplica',
        ];

        $rows = [];
        foreach (self::VACINAS as $key => $label) {
            $rows[] = Grid::make(['default' => 12])
                ->extraAttributes(['class' => 'gestar-vacina-row'])
                ->schema([
                    Checkbox::make("vacinas.{$key}.aplicada")
                        ->label(new HtmlString("<span class='gestar-vacina-label'>{$label}</span>"))
                        ->columnSpan(7),
                    Select::make("vacinas.{$key}.status")
                        ->label('')
                        ->options($statusOptions)
                        ->default('pendente')
                        ->native(true)
                        ->columnSpan(5),
                ]);
        }

        $rows[] = Textarea::make('vacinas.observacoes')
            ->label('Observações')
            ->placeholder('Observações sobre vacinas')
            ->rows(2);

        return Section::make('6. Vacinas')
            ->extraAttributes(['class' => 'card-vacinas'])
            ->schema($rows);
    }

    protected static function cardExames(): Section
    {
        return Section::make('7. Exames lab e imagens')
            ->extraAttributes(['class' => 'card-exames'])
            ->schema([
                View::make('filament.components.atendimento.exames-trimestre-table')
                    ->viewData(['exames' => self::EXAMES]),

                Textarea::make('exames_referencia')
                    ->label('Referência de resultados')
                    ->placeholder('Informe os resultados ou anexos dos exames')
                    ->rows(4),
            ]);
    }

    protected static function cardExameFisico(): Section
    {
        return Section::make('8. Exame físico')
            ->extraAttributes(['class' => 'card-exame-fisico'])
            ->columns(3)
            ->schema([
                TextInput::make('_pa_combinada')
                    ->label('PA (mmHg)')
                    ->placeholder('Ex.: 120/80')
                    ->dehydrated(false)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        if (! $state) {
                            $set('pa_sistolica', null);
                            $set('pa_diastolica', null);
                            return;
                        }
                        if (preg_match('/^\s*(\d{2,3})\s*[\/x×-]\s*(\d{2,3})\s*$/u', $state, $m)) {
                            $set('pa_sistolica', (int) $m[1]);
                            $set('pa_diastolica', (int) $m[2]);
                        }
                    })
                    ->afterStateHydrated(function (Set $set, Get $get, ?string $state) {
                        $sis = $get('pa_sistolica');
                        $dia = $get('pa_diastolica');
                        if ($sis && $dia) {
                            $set('_pa_combinada', "{$sis}/{$dia}");
                        }
                    }),

                TextInput::make('altura_uterina')
                    ->label('AU (cm)')
                    ->placeholder('Ex.: 24')
                    ->numeric()
                    ->step('0.1'),

                Select::make('edema')
                    ->label('Edema')
                    ->placeholder('Selecione')
                    ->options([
                        0 => 'Ausente',
                        1 => '+',
                        2 => '++',
                        3 => '+++',
                    ])
                    ->native(false),

                Hidden::make('pa_sistolica'),
                Hidden::make('pa_diastolica'),

                Textarea::make('exame_fisico_observacoes')
                    ->label('Observações')
                    ->placeholder('Observações do exame físico')
                    ->rows(2)
                    ->columnSpan(3),
            ]);
    }

    protected static function cardParto(): Section
    {
        return Section::make('9. Dados do parto e RN')
            ->extraAttributes(['class' => 'card-parto'])
            ->columns(12)
            ->schema([
                DatePicker::make('data_parto')
                    ->label('Data do parto')
                    ->placeholder('dd/mm/aaaa')
                    ->columnSpan(4),
                Select::make('tipo_parto')
                    ->label('Tipo de parto')
                    ->placeholder('Selecione')
                    ->options([
                        1 => 'Vaginal',
                        2 => 'Cesárea',
                    ])
                    ->native(false)
                    ->columnSpan(4),
                TextInput::make('local_parto')
                    ->label('Local do parto')
                    ->placeholder('Digite o local')
                    ->columnSpan(4),

                Select::make('sexo_rn')
                    ->label('Sexo do RN')
                    ->placeholder('Selecione')
                    ->options([
                        1 => 'Feminino',
                        2 => 'Masculino',
                    ])
                    ->native(false)
                    ->columnSpan(3),
                TextInput::make('peso_rn')
                    ->label('Peso (g)')
                    ->placeholder('Ex.: 3200')
                    ->numeric()
                    ->columnSpan(3),
                TextInput::make('apgar_1')
                    ->label('Apgar 1º min')
                    ->placeholder('Ex.: 8')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->columnSpan(3),
                TextInput::make('apgar_5')
                    ->label('Apgar 5º min')
                    ->placeholder('Ex.: 9')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->columnSpan(3),

                Textarea::make('parto_observacoes')
                    ->label('Observações')
                    ->placeholder('Observações sobre o parto e o RN')
                    ->rows(2)
                    ->columnSpan(12),
            ]);
    }

    protected static function cardAnotacoes(): Section
    {
        $itens = [
            ['anot_consulta_realizada', 'anot_consulta', 'Consulta', 'Descrever consulta realizada'],
            ['anot_visita_realizada', 'anot_visita', 'Visita domiciliar', 'Descrever visita domiciliar'],
            ['anot_acoes_realizada', 'anot_acoes', 'Ações educativas', 'Descrever ações educativas'],
            ['anot_plano_realizado', 'anot_plano', 'Plano de cuidado', 'Descrever plano de cuidado'],
        ];

        $fields = [];
        foreach ($itens as [$flag, $texto, $titulo, $placeholder]) {
            $fields[] = Grid::make(['default' => 12])
                ->extraAttributes(['class' => 'gestar-anot-row'])
                ->schema([
                    Checkbox::make($flag)
                        ->label(new HtmlString("<span class='gestar-anot-label'>{$titulo}</span>"))
                        ->columnSpan(4),
                    Textarea::make($texto)
                        ->label('')
                        ->placeholder($placeholder)
                        ->rows(1)
                        ->columnSpan(8),
                ]);
        }

        return Section::make('10. Anotações do gestor')
            ->extraAttributes(['class' => 'card-anotacoes'])
            ->schema($fields);
    }

    protected static function cardGrafico(): Section
    {
        return Section::make('11. Gráfico')
            ->extraAttributes(['class' => 'card-grafico'])
            ->schema([
                View::make('filament.components.atendimento.grafico-card'),
            ]);
    }

    /* ================================================================ */
    /* Helpers de antecedentes                                            */
    /* ================================================================ */

    protected static function buildAntPessoais(?Gestante $g): ?string
    {
        if (! $g) {
            return null;
        }

        $partes = [];
        $problemas = collect($g->problemas_saude_pessoais ?? [])->filter()->values()->all();
        if ($problemas) {
            $partes[] = implode(', ', $problemas);
        }
        if ($g->alergia_qual) {
            $partes[] = 'Alergias: '.$g->alergia_qual;
        }
        if ($g->medicamento_qual) {
            $partes[] = 'Medicamentos: '.$g->medicamento_qual;
        }

        return $partes ? implode(' • ', $partes) : null;
    }

    protected static function buildAntFamiliares(?Gestante $g): ?string
    {
        if (! $g) {
            return null;
        }
        $itens = collect($g->problemas_saude_familia ?? [])->filter()->values()->all();
        return $itens ? implode(', ', $itens) : null;
    }

    protected static function buildAntGinecologicos(?Gestante $g): ?string
    {
        if (! $g) {
            return null;
        }
        $partes = array_filter([
            $g->qual_ist ? 'IST: '.$g->qual_ist : null,
            $g->qual_anticoncepcional ? 'Contraceptivo: '.$g->qual_anticoncepcional : null,
            $g->qual_patologia_mamas ? 'Mamas: '.$g->qual_patologia_mamas : null,
        ]);
        return $partes ? implode(' • ', $partes) : null;
    }

    protected static function buildAntObstetricos(?Gestante $g): ?string
    {
        if (! $g) {
            return null;
        }
        $partes = array_filter([
            $g->numero_gestacoes ? 'G '.$g->numero_gestacoes : null,
            $g->partos_normal ? 'PN '.$g->partos_normal : null,
            $g->partos_cesaria ? 'PC '.$g->partos_cesaria : null,
            $g->numero_abortos ? 'A '.$g->numero_abortos : null,
        ]);
        return $partes ? implode(' • ', $partes) : null;
    }
}
