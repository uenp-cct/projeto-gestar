<?php

namespace App\Filament\Resources\GestanteResource\Pages;

use App\Filament\Resources\AtendimentoResource;
use App\Filament\Resources\GestanteResource;
use App\Models\Atendimento;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewGestante extends ViewRecord
{
    protected static string $resource = GestanteResource::class;

    public function getTitle(): string
    {
        return $this->record->nome ?? 'Paciente';
    }

    public function getHeading(): string
    {
        return $this->record->nome ?? 'Paciente';
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Editar cadastro')
                ->icon('heroicon-o-pencil-square'),

            Action::make('novoAtendimento')
                ->label('Novo atendimento')
                ->icon('heroicon-o-document-plus')
                ->color('primary')
                ->url(fn() => AtendimentoResource::getUrl('create', [
                    'tableFilters[gestante_id][value]' => $this->record->id,
                ])),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('hub')
                    ->tabs([
                        $this->tabVisaoGeral(),
                        $this->tabAtendimentos(),
                        $this->tabGestacaoAtual(),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    /* ------------------------------------------------------------------ */
    /* Aba 1 – Visão geral                                                 */
    /* ------------------------------------------------------------------ */
    protected function tabVisaoGeral(): Tab
    {
        return Tab::make('Visão geral')
            ->icon('heroicon-o-user')
            ->schema([
                Section::make('Identificação')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('nome')->label('Nome completo'),
                        TextEntry::make('numero_sus')->label('Cartão SUS')->default('—'),
                        TextEntry::make('data_nascimento')->label('Data de nascimento')->date('d/m/Y')->placeholder('—'),
                        TextEntry::make('gestor.name')->label('Gestor(a)')->default('—'),
                        TextEntry::make('medico.name')->label('Médico(a)')->default('—'),
                        TextEntry::make('fone')->label('Telefone')->default('—'),
                    ]),

                Section::make('Gestação atual')
                    ->columns(3)
                    ->schema([
                        TextEntry::make('dum')->label('DUM')->date('d/m/Y')->placeholder('—'),
                        TextEntry::make('dpp_dum')->label('DPP (DUM)')->date('d/m/Y')->placeholder('—'),
                        TextEntry::make('dpp_usg')->label('DPP (USG)')->date('d/m/Y')->placeholder('—'),
                        TextEntry::make('estratificacao_risco')
                            ->label('Risco inicial')
                            ->formatStateUsing(fn($state) => Atendimento::RISCOS[$state] ?? '—')
                            ->badge()
                            ->color(fn($state) => match ((int) $state) {
                                Atendimento::RISCO_HABITUAL => 'success',
                                Atendimento::RISCO_INTERMEDIARIO => 'warning',
                                Atendimento::RISCO_ALTO => 'danger',
                                default => 'gray',
                            }),
                        TextEntry::make('gestacao_planejada')
                            ->label('Gestação planejada')
                            ->formatStateUsing(fn($state) => $state ? 'Sim' : 'Não')
                            ->default('—'),
                        TextEntry::make('atendimentos_count')
                            ->label('Total de atendimentos')
                            ->state(fn($record) => $record->atendimentos()->count()),
                    ]),

                Section::make('Contato e endereço')
                    ->columns(3)
                    ->collapsed()
                    ->schema([
                        TextEntry::make('endereco')->label('Endereço')->default('—'),
                        TextEntry::make('numero')->label('Número')->default('—'),
                        TextEntry::make('bairro')->label('Bairro')->default('—'),
                        TextEntry::make('email')->label('E-mail')->default('—'),
                    ]),
            ]);
    }

    /* ------------------------------------------------------------------ */
    /* Aba 2 – Atendimentos passados                                       */
    /* ------------------------------------------------------------------ */
    protected function tabAtendimentos(): Tab
    {
        return Tab::make('Atendimentos')
            ->icon('heroicon-o-clipboard-document-list')
            ->schema([
                ViewEntry::make('atendimentos_table')
                    ->view('filament.components.gestante.atendimentos-table', [
                        'atendimentos' => fn($record) => $record
                            ->atendimentos()
                            ->with('profissional')
                            ->orderByDesc('data_atendimento')
                            ->get(),
                    ]),
            ]);
    }

    /* ------------------------------------------------------------------ */
    /* Aba 3 – Gestação atual (gráfico PA + timeline)                      */
    /* ------------------------------------------------------------------ */
    protected function tabGestacaoAtual(): Tab
    {
        return Tab::make('Gestação atual')
            ->icon('heroicon-o-heart')
            ->schema([
                ViewEntry::make('grafico_pa')
                    ->view('filament.components.gestante.grafico-pa', [
                        'gestanteId' => fn($record) => $record->id,
                    ]),

                ViewEntry::make('timeline_observacoes')
                    ->view('filament.components.gestante.timeline-observacoes', [
                        'atendimentos' => fn($record) => $record
                            ->atendimentos()
                            ->with('profissional')
                            ->orderByDesc('data_atendimento')
                            ->get(),
                    ]),
            ]);
    }
}
