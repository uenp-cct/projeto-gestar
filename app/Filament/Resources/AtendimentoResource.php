<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AtendimentoResource\Pages;
use App\Filament\Resources\AtendimentoResource\Widgets\PressaoArterialChart;
use App\Models\Atendimento;
use App\Models\Gestante;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
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
    protected static ?string $navigationGroup = 'Gestão';
    protected static ?string $modelLabel = 'Atendimento';
    protected static ?string $pluralModelLabel = 'Atendimentos';
    protected static ?int $navigationSort = 2;

    protected const VACINAS = [
        'hepatite_b' => 'Hepatite B',
        'influenza' => 'Influenza',
        'dtpa' => 'dTpa',
        'covid_19' => 'Covid-19',
        'outras' => 'Outras',
    ];

    protected const EXAMES = [
        'hemograma' => 'Hemograma',
        'glicemia' => 'Glicemia',
        'urina_eas' => 'Urina (EAS)',
        'vdrl' => 'VDRL',
        'hiv' => 'HIV',
        'ultrassonografia' => 'Ultrassonografia',
    ];

    public static function form(Form $form): Form
    {
        return $form->schema([

            Section::make('1. Identificação')
                ->description('Selecione a gestante para iniciar o atendimento.')
                ->columns(2)
                ->schema([
                    Select::make('gestante_id')
                        ->label('Gestante')
                        ->relationship(
                            name: 'gestante',
                            titleAttribute: 'nome',
                        )
                        ->getOptionLabelFromRecordUsing(fn (Gestante $record) => trim(
                            $record->nome.($record->numero_sus ? ' — SUS '.$record->numero_sus : '')
                        ))
                        ->searchable(['nome', 'numero_sus'])
                        ->preload()
                        ->required()
                        ->live()
                        ->columnSpan(2),

                    DatePicker::make('data_atendimento')
                        ->label('Data do atendimento')
                        ->default(now())
                        ->required(),

                    Select::make('tipo_atendimento')
                        ->label('Tipo de atendimento')
                        ->options(Atendimento::TIPOS_ATENDIMENTO)
                        ->default(Atendimento::TIPO_CONSULTA),

                    Select::make('user_id')
                        ->label('Profissional responsável')
                        ->relationship('profissional', 'name')
                        ->searchable()
                        ->preload()
                        ->default(fn () => auth()->id())
                        ->columnSpan(2),

                    Group::make()
                        ->columnSpan(2)
                        ->schema(static::identificacaoContextoFields()),
                ]),

            Section::make('2. Antecedentes e histórico')
                ->description('Informações estáveis vindas do cadastro da gestante.')
                ->visible(fn (Get $get) => filled($get('gestante_id')))
                ->collapsed()
                ->schema(static::historicoGestanteFields()),

            Section::make('3. Hábitos de vida')
                ->columns(2)
                ->schema([
                    Radio::make('tabagismo')
                        ->label('Tabagismo')
                        ->options([
                            1 => 'Não',
                            2 => 'Sim',
                            3 => 'Ex-tabagista',
                        ])
                        ->inline(),

                    Radio::make('alcool')
                        ->label('Álcool')
                        ->options([
                            1 => 'Não',
                            2 => 'Sim',
                            3 => 'Socialmente',
                        ])
                        ->inline(),
                ]),

            Section::make('4. Situação atual')
                ->schema([
                    Textarea::make('situacao_atual')
                        ->label('Descreva a situação atual da paciente')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),

            Section::make('5. Estratificação de risco')
                ->schema([
                    Radio::make('estratificacao_risco')
                        ->label('Risco')
                        ->options([
                            Atendimento::RISCO_HABITUAL => 'Habitual',
                            Atendimento::RISCO_INTERMEDIARIO => 'Intermediário',
                            Atendimento::RISCO_ALTO => 'Alto risco',
                        ])
                        ->descriptions([
                            Atendimento::RISCO_HABITUAL => 'Risco habitual',
                            Atendimento::RISCO_INTERMEDIARIO => 'Risco intermediário',
                            Atendimento::RISCO_ALTO => 'Alto risco',
                        ])
                        ->required(),

                    Textarea::make('estratificacao_observacao')
                        ->label('Observações sobre a estratificação')
                        ->rows(2)
                        ->columnSpanFull(),
                ]),

            Section::make('6. Vacinas')
                ->columns(2)
                ->schema(static::vacinasFields()),

            Section::make('7. Exames lab e imagens')
                ->columns(['md' => 2])
                ->schema(static::examesFields()),

            Section::make('8. Exame físico')
                ->columns(4)
                ->schema([
                    TextInput::make('pa_sistolica')
                        ->label('PA sistólica (mmHg)')
                        ->numeric()
                        ->minValue(40)
                        ->maxValue(260)
                        ->placeholder('Ex.: 120'),

                    TextInput::make('pa_diastolica')
                        ->label('PA diastólica (mmHg)')
                        ->numeric()
                        ->minValue(30)
                        ->maxValue(180)
                        ->placeholder('Ex.: 80'),

                    TextInput::make('altura_uterina')
                        ->label('AU (cm)')
                        ->numeric()
                        ->step('0.1')
                        ->placeholder('Ex.: 24'),

                    Select::make('edema')
                        ->label('Edema')
                        ->options([
                            0 => 'Ausente',
                            1 => '+',
                            2 => '++',
                            3 => '+++',
                        ]),

                    Textarea::make('exame_fisico_observacoes')
                        ->label('Observações do exame físico')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('9. Dados do parto e RN')
                ->columns(3)
                ->schema([
                    DatePicker::make('data_parto')->label('Data do parto'),
                    Select::make('tipo_parto')->label('Tipo de parto')->options([
                        1 => 'Vaginal',
                        2 => 'Cesárea',
                    ]),
                    TextInput::make('local_parto')->label('Local do parto'),

                    Select::make('sexo_rn')->label('Sexo do RN')->options([
                        1 => 'Feminino',
                        2 => 'Masculino',
                    ]),
                    TextInput::make('peso_rn')->label('Peso (g)')->numeric()->placeholder('Ex.: 3200'),
                    Group::make()
                        ->columns(2)
                        ->schema([
                            TextInput::make('apgar_1')->label('Apgar 1º min')->numeric()->minValue(0)->maxValue(10),
                            TextInput::make('apgar_5')->label('Apgar 5º min')->numeric()->minValue(0)->maxValue(10),
                        ]),

                    Textarea::make('parto_observacoes')
                        ->label('Observações sobre o parto e RN')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('10. Anotações do gestor')
                ->schema(static::anotacoesGestorFields()),
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

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected static function identificacaoContextoFields(): array
    {
        return [
            Placeholder::make('gestante_resumo')
                ->label('Gestante selecionada')
                ->columnSpanFull()
                ->content(function (Get $get) {
                    $id = $get('gestante_id');
                    if (! $id) {
                        return new \Illuminate\Support\HtmlString(
                            '<span class="text-sm text-gray-500">Selecione uma gestante para ver os dados de identificação.</span>'
                        );
                    }
                    $g = Gestante::with(['gestor', 'medico'])->find($id);
                    if (! $g) {
                        return '—';
                    }
                    $linhas = [
                        'Nome: '.($g->nome ?: '—'),
                        'SUS: '.($g->numero_sus ?: '—'),
                        'Gestor(a): '.($g->gestor?->name ?: '—'),
                        'Médico(a): '.($g->medico?->name ?: '—'),
                        'Nascimento: '.($g->data_nascimento?->format('d/m/Y') ?: '—'),
                    ];

                    return new \Illuminate\Support\HtmlString(
                        '<div class="space-y-1 text-sm">'
                            .collect($linhas)->map(fn ($l) => '<div>'.e($l).'</div>')->implode('')
                            .'</div>'
                    );
                }),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected static function historicoGestanteFields(): array
    {
        $textoOuTraco = fn (Get $get, string $campo) => function () use ($get, $campo) {
            $id = $get('gestante_id');
            if (! $id) {
                return '—';
            }
            $g = Gestante::find($id);

            return $g?->{$campo} ?: '—';
        };

        return [
            Placeholder::make('historico_resumo')
                ->label('')
                ->columnSpanFull()
                ->content(function (Get $get) {
                    $id = $get('gestante_id');
                    if (! $id) {
                        return '—';
                    }
                    $g = Gestante::find($id);
                    if (! $g) {
                        return '—';
                    }
                    $blocos = [
                        'Antecedentes pessoais' => collect($g->problemas_saude_pessoais ?? [])->filter()->implode(', ')
                            ?: ($g->alergia_qual ?: ''),
                        'Antecedentes familiares' => collect($g->problemas_saude_familia ?? [])->filter()->implode(', '),
                        'Antecedentes ginecológicos' => $g->qual_ist ?: ($g->qual_anticoncepcional ?: ''),
                        'Antecedentes obstétricos' => trim(
                            collect([
                                $g->numero_gestacoes ? 'G '.$g->numero_gestacoes : null,
                                $g->partos_normal ? 'PN '.$g->partos_normal : null,
                                $g->partos_cesaria ? 'PC '.$g->partos_cesaria : null,
                                $g->numero_abortos ? 'A '.$g->numero_abortos : null,
                            ])->filter()->implode(' • ')
                        ),
                    ];

                    $html = '<div class="grid gap-2 text-sm md:grid-cols-2">';
                    foreach ($blocos as $titulo => $valor) {
                        $valor = $valor !== '' ? $valor : '—';
                        $html .= '<div><div class="font-medium text-gray-700">'.e($titulo).'</div>'
                            .'<div class="text-gray-600">'.e($valor).'</div></div>';
                    }
                    $html .= '</div>';

                    return new \Illuminate\Support\HtmlString($html);
                }),
        ];
    }

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected static function vacinasFields(): array
    {
        $statusOptions = [
            'pendente' => 'Pendente',
            'aplicada' => 'Aplicada',
            'nao_aplica' => 'Não se aplica',
        ];

        $fields = [];
        foreach (self::VACINAS as $key => $label) {
            $fields[] = Group::make()
                ->columns(2)
                ->schema([
                    Toggle::make("vacinas.{$key}.aplicada")
                        ->label($label)
                        ->inline(false),

                    Select::make("vacinas.{$key}.status")
                        ->label('Status')
                        ->options($statusOptions)
                        ->default('pendente'),
                ]);
        }

        $fields[] = Textarea::make('vacinas.observacoes')
            ->label('Observações sobre vacinas')
            ->rows(2)
            ->columnSpanFull();

        return $fields;
    }

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected static function examesFields(): array
    {
        $rows = [];
        foreach (self::EXAMES as $key => $label) {
            $rows[] = Group::make()
                ->columns(['default' => 1, 'md' => 4])
                ->columnSpan(['md' => 2])
                ->schema([
                    Placeholder::make("exames_label_{$key}")
                        ->label('')
                        ->content($label),

                    Toggle::make("exames.{$key}.t1")->label('1º Trimestre')->inline(false),
                    Toggle::make("exames.{$key}.t2")->label('2º Trimestre')->inline(false),
                    Toggle::make("exames.{$key}.t3")->label('3º Trimestre')->inline(false),
                ]);
        }

        $rows[] = Textarea::make('exames_referencia')
            ->label('Referência de resultados / observações')
            ->rows(3)
            ->columnSpanFull();

        return $rows;
    }

    /**
     * @return array<int, \Filament\Forms\Components\Component>
     */
    protected static function anotacoesGestorFields(): array
    {
        $itens = [
            ['anot_consulta_realizada', 'anot_consulta', 'Consulta', 'Descrever consulta realizada'],
            ['anot_visita_realizada', 'anot_visita', 'Visita domiciliar', 'Descrever visita domiciliar'],
            ['anot_acoes_realizada', 'anot_acoes', 'Ações educativas', 'Descrever ações educativas'],
            ['anot_plano_realizado', 'anot_plano', 'Plano de cuidado', 'Descrever plano de cuidado'],
        ];

        $fields = [];
        foreach ($itens as [$flag, $texto, $titulo, $placeholder]) {
            $fields[] = Group::make()
                ->columns(['default' => 1, 'md' => 4])
                ->schema([
                    Toggle::make($flag)->label($titulo)->inline(false)->columnSpan(1),
                    Textarea::make($texto)
                        ->label('Anotações')
                        ->placeholder($placeholder)
                        ->rows(2)
                        ->columnSpan(3),
                ]);
        }

        return $fields;
    }
}
