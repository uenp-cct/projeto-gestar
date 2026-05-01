<?php

namespace App\Filament\Resources\AtendimentoResource\Pages;

use App\Filament\Resources\AtendimentoResource;
use App\Models\Atendimento;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateAtendimento extends CreateRecord
{
    protected static string $resource = AtendimentoResource::class;

    protected static string $view = 'filament.resources.atendimento-resource.pages.create-atendimento';

    public function getTitle(): string
    {
        return 'Página de atendimento';
    }

    public function getHeading(): string
    {
        return 'Página de atendimento';
    }

    public function getBreadcrumb(): string
    {
        return 'Novo atendimento';
    }

    public function getBreadcrumbs(): array
    {
        return [
            AtendimentoResource::getUrl('index') => 'Atendimentos',
            'Novo atendimento',
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('cancelar')
                ->label('Cancelar')
                ->color('gray')
                ->outlined()
                ->url(fn () => AtendimentoResource::getUrl('index')),

            Action::make('salvarRascunho')
                ->label('Salvar rascunho')
                ->color('primary')
                ->outlined()
                ->action(function () {
                    $this->data['status'] = Atendimento::STATUS_RASCUNHO;
                    $this->create();
                }),

            Action::make('salvar')
                ->label('Salvar')
                ->color('primary')
                ->action(fn () => $this->create()),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }
        if (empty($data['data_atendimento'])) {
            $data['data_atendimento'] = now()->toDateString();
        }
        if (empty($data['status'])) {
            $data['status'] = Atendimento::STATUS_FINALIZADO;
        }

        return $data;
    }
}
