<?php

namespace App\Filament\Resources\AtendimentoResource\Pages;

use App\Filament\Resources\AtendimentoResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAtendimento extends CreateRecord
{
    protected static string $resource = AtendimentoResource::class;

    public function getTitle(): string
    {
        return 'Página de atendimento';
    }

    public function getBreadcrumb(): string
    {
        return 'Novo atendimento';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Salvar'),
            $this->getCreateAnotherFormAction()->label('Salvar e novo'),
            $this->getCancelFormAction()->label('Cancelar'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['user_id'])) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }
}
