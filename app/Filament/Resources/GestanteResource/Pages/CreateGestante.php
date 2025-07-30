<?php

namespace App\Filament\Resources\GestanteResource\Pages;

use App\Filament\Resources\GestanteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGestante extends CreateRecord
{
    protected static string $resource = GestanteResource::class;

    public function getTitle(): string
    {
        return 'Cadastrar nova gestante';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Salvar'),
            $this->getCancelFormAction()->label('Cancelar'),
        ];
    }
}
