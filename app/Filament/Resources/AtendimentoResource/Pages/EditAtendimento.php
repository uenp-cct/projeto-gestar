<?php

namespace App\Filament\Resources\AtendimentoResource\Pages;

use App\Filament\Resources\AtendimentoResource;
use App\Filament\Resources\AtendimentoResource\Widgets\PressaoArterialChart;
use Filament\Resources\Pages\EditRecord;

class EditAtendimento extends EditRecord
{
    protected static string $resource = AtendimentoResource::class;

    public function getTitle(): string
    {
        return 'Página de atendimento';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label('Salvar alterações'),
            $this->getCancelFormAction()->label('Cancelar'),
            $this->getDeleteFormAction()->label('Excluir'),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            PressaoArterialChart::class,
        ];
    }

    public function getFooterWidgetsColumns(): int | string | array
    {
        return 1;
    }
}
