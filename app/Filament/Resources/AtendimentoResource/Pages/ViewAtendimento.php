<?php

namespace App\Filament\Resources\AtendimentoResource\Pages;

use App\Filament\Resources\AtendimentoResource;
use App\Models\Atendimento;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewAtendimento extends ViewRecord
{
    protected static string $resource = AtendimentoResource::class;

    public function getTitle(): string
    {
        $data = optional($this->record->data_atendimento)->format('d/m/Y');
        $nome = $this->record->gestante?->nome;

        return trim(($nome ?? 'Atendimento') . " — {$data}");
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Editar atendimento')
                ->icon('heroicon-o-pencil-square'),

            Action::make('voltar')
                ->label('Voltar')
                ->color('gray')
                ->outlined()
                ->url(fn() => AtendimentoResource::getUrl('index')),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Identificação')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('gestante.nome')->label('Gestante'),
                        TextEntry::make('gestante.numero_sus')->label('SUS')->default('—'),
                        TextEntry::make('data_atendimento')->label('Data')->date('d/m/Y'),
                        TextEntry::make('profissional.name')->label('Profissional')->default('—'),
                        TextEntry::make('tipo_atendimento')
                            ->label('Tipo')
                            ->formatStateUsing(fn($state) => Atendimento::TIPOS_ATENDIMENTO[$state] ?? '—'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn($state) => Atendimento::STATUSES[$state] ?? '—')
                            ->color(fn($state) => match ($state) {
                                Atendimento::STATUS_FINALIZADO => 'success',
                                Atendimento::STATUS_RASCUNHO => 'gray',
                                default => 'gray',
                            }),
                    ]),

                Section::make('Estratificação de risco')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('estratificacao_risco')
                            ->label('Risco')
                            ->badge()
                            ->formatStateUsing(fn($state) => Atendimento::RISCOS[$state] ?? '—')
                            ->color(fn($state) => match ((int) $state) {
                                Atendimento::RISCO_HABITUAL => 'success',
                                Atendimento::RISCO_INTERMEDIARIO => 'warning',
                                Atendimento::RISCO_ALTO => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('situacao_atual')->label('Situação atual')->default('—'),
                    ]),

                Section::make('Exame físico')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('pa_display')
                            ->label('PA (mmHg)')
                            ->state(fn(Atendimento $record) => $record->pa_sistolica && $record->pa_diastolica
                                ? "{$record->pa_sistolica}/{$record->pa_diastolica}"
                                : '—'),
                        TextEntry::make('altura_uterina')->label('AU (cm)')->default('—'),
                        TextEntry::make('edema')
                            ->label('Edema')
                            ->formatStateUsing(fn($state) => match ((int) $state) {
                                0 => 'Ausente',
                                1 => '+',
                                2 => '++',
                                3 => '+++',
                                default => '—',
                            }),
                        TextEntry::make('exame_fisico_observacoes')->label('Observações')->default('—'),
                    ]),

                Section::make('Anotações do gestor')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('anot_consulta')->label('Consulta')->default('—'),
                        TextEntry::make('anot_visita')->label('Visita domiciliar')->default('—'),
                        TextEntry::make('anot_acoes')->label('Ações educativas')->default('—'),
                        TextEntry::make('anot_plano')->label('Plano de cuidado')->default('—'),
                    ]),

                Section::make('Dados do parto e RN')
                    ->columns(4)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('data_parto')->label('Data do parto')->date('d/m/Y')->placeholder('—'),
                        TextEntry::make('tipo_parto')
                            ->label('Tipo de parto')
                            ->formatStateUsing(fn($state) => match ((int) $state) {
                                1 => 'Vaginal',
                                2 => 'Cesárea',
                                default => '—',
                            }),
                        TextEntry::make('local_parto')->label('Local do parto')->default('—'),
                        TextEntry::make('sexo_rn')
                            ->label('Sexo do RN')
                            ->formatStateUsing(fn($state) => match ((int) $state) {
                                1 => 'Feminino',
                                2 => 'Masculino',
                                default => '—',
                            }),
                        TextEntry::make('peso_rn')->label('Peso (g)')->default('—'),
                        TextEntry::make('apgar_1')->label('Apgar 1º min')->default('—'),
                        TextEntry::make('apgar_5')->label('Apgar 5º min')->default('—'),
                        TextEntry::make('parto_observacoes')->label('Observações')->default('—'),
                    ]),

                Section::make('Gráfico — Evolução da PA')
                    ->schema([
                        ViewEntry::make('grafico_pa')
                            ->view('filament.components.gestante.grafico-pa', [
                                'gestanteId' => fn($record) => $record->gestante_id,
                            ]),
                    ]),
            ]);
    }
}
