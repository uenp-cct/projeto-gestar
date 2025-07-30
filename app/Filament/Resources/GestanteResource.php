<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GestanteResource\Pages;
use App\Models\Gestante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\{
    TextInput,
    DatePicker,
    Textarea,
    Toggle,
    Select,
    Section
};
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class GestanteResource extends Resource
{
    protected static ?string $model = Gestante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Gestantes';
    protected static ?string $navigationGroup = 'Gestão';

    public static function form(Form $form): Form
    {
        return $form->schema([

                Section::make('Dados Cadastrais')->schema([
                    TextInput::make('nome')->label('Nome completo')->required(),
                    DatePicker::make('data_nascimento')->label('Data de nascimento'),
                    TextInput::make('endereco')->label('Endereço'),
                    TextInput::make('numero')->label('Número'),
                    TextInput::make('bairro')->label('Bairro'),
                    TextInput::make('fone')->label('Telefone'),
                    TextInput::make('email')->label('E-mail')->email(),
                ]),

                Section::make('Vacinas')->schema([
                    TextInput::make('vacina_dt_dose1')->label('DT - Dose única'),
                    TextInput::make('vacina_dt_dose2')->label('DT - 1ª dose'),
                    TextInput::make('vacina_dt_dose3')->label('DT - 2ª dose'),
                    TextInput::make('vacina_dt_ref')->label('DT - Reforço'),

                    TextInput::make('vacina_hep_b_dose1')->label('Hepatite B - Dose única'),
                    TextInput::make('vacina_hep_b_dose2')->label('Hepatite B - 1ª dose'),
                    TextInput::make('vacina_hep_b_dose3')->label('Hepatite B - 2ª dose'),
                    TextInput::make('vacina_hep_b_ref')->label('Hepatite B - Reforço'),

                    TextInput::make('vacina_dtpa_dose')->label('DTPa - Dose aplicada'),
                    TextInput::make('vacina_influenza')->label('Influenza - Dose aplicada'),
                ]),

                Section::make('Exames Laboratoriais')->schema([
                    Textarea::make('exames_trim1')->label('Exames - 1º Trimestre'),
                    Textarea::make('exames_trim2')->label('Exames - 2º Trimestre'),
                    Textarea::make('exames_trim3')->label('Exames - 3º Trimestre'),
                ]),


                Section::make('Ultrassonografias')->schema([
                    Textarea::make('usg1')->label('1ª USG - Detalhes'),
                    Textarea::make('usg2')->label('2ª USG - Detalhes'),
                    Textarea::make('usg3')->label('3ª USG - Detalhes'),
                ]),

                Section::make('Exames Físicos - Pré-natal')->schema([
                    Textarea::make('consultas_prenatal')->label('Consultas (dados físicos, AU, PA, BCF etc.)'),
                ]),

                Section::make('Exames Físicos - Pré-natal')->schema([
                    Textarea::make('consultas_prenatal')->label('Consultas (dados físicos, AU, PA, BCF etc.)'),
                ]),

                Section::make('Parto e RN')->schema([
                    DatePicker::make('data_nascimento_rn')->label('Nascimento do RN'),
                    Select::make('tipo_parto')->label('Tipo de parto')->options([
                        1 => 'Cesárea', 2 => 'Vaginal'
                    ]),
                    TextInput::make('apgar_1')->label('Apgar - 1º min'),
                    TextInput::make('apgar_5')->label('Apgar - 5º min'),
                    TextInput::make('peso_rn')->label('Peso (g)'),
                    TextInput::make('comprimento_rn')->label('Comprimento (cm)'),
                    TextInput::make('perimetro_cefalico')->label('Perímetro cefálico'),
                    Toggle::make('anomalias')->label('Anomalias congênitas?'),
                    TextInput::make('anomalias_descricao')->label('Descrição')->visible(fn($get) => $get('anomalias')),
                    Toggle::make('aleitamento_maternidade')->label('Aleitamento na maternidade'),
                    Select::make('desfecho_parto')->label('Desfecho')->options([
                        1 => 'Satisfatório', 2 => 'Insatisfatório'
                    ]),
                    Textarea::make('observacoes_parto')->label('Observações adicionais'),
                ]),

                Section::make('1ª Semana do RN')->schema([
                    TextInput::make('nome_crianca')->label('Nome da criança'),
                    TextInput::make('peso_rn_semana1')->label('Peso'),
                    Toggle::make('aleitamento_exclusivo_semana1')->label('Aleitamento exclusivo?'),
                    Textarea::make('consulta_semana1')->label('Consulta - Observações'),
                ]),

                Section::make('Período Neonatal')->schema([
                    DatePicker::make('data_visita_neonatal')->label('Data da consulta/visita'),
                    TextInput::make('idade_crianca_dias')->label('Idade da criança (dias)'),
                    TextInput::make('peso_neonatal')->label('Peso (g)'),
                    TextInput::make('comprimento_neonatal')->label('Comprimento (cm)'),
                    Toggle::make('aleitamento_exclusivo_neonatal')->label('Aleitamento exclusivo?'),
                    Textarea::make('intercorrencias_neonatal')->label('Intercorrências'),
                    Textarea::make('consulta_neonatal')->label('Observações da consulta'),
                    Select::make('desfecho_neonatal')->label('Desfecho')->options([
                        1 => 'Satisfatório', 2 => 'Insatisfatório'
                    ]),
                ]),

                Section::make('Anotações e Plano de Cuidados')->schema([
                Textarea::make('anotacoes_consultas')->label('Anotações das consultas'),
                Textarea::make('anotacoes_visitas')->label('Visitas domiciliares e contatos'),
                Textarea::make('acoes_educativas')->label('Ações educativas'),
                Textarea::make('plano_cuidado')->label('Plano de cuidado'),
            ]),
        ]);
        }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nome')->label('Nome')->searchable()->sortable(),
                TextColumn::make('data_nascimento')->label('Nascimento')->date(),
                TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
