<?php

namespace App\Filament\Resources\GestanteResource\Pages;

use App\Filament\Resources\GestanteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGestante extends EditRecord
{
    protected static string $resource = GestanteResource::class;

    public function getTitle(): string
    {
        return 'Editar paciente';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->label('Excluir'),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label('Salvar alterações'),
            $this->getCancelFormAction()->label('Cancelar'),
        ];
    }
}
