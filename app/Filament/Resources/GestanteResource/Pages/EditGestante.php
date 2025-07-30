<?php

namespace App\Filament\Resources\GestanteResource\Pages;

use App\Filament\Resources\GestanteResource;
use Filament\Resources\Pages\EditRecord;

class EditGestante extends EditRecord
{
    protected static string $resource = GestanteResource::class;

    public function getTitle(): string
    {
        return 'Editar cadastro da gestante';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label('Salvar alterações'),
            $this->getCancelFormAction()->label('Cancelar'),
            $this->getDeleteFormAction()->label('Excluir'),
        ];
    }
}
