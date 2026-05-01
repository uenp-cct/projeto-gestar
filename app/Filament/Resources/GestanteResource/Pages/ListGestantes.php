<?php

namespace App\Filament\Resources\GestanteResource\Pages;

use App\Filament\Resources\GestanteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGestantes extends ListRecords
{
    protected static string $resource = GestanteResource::class;

    public function getTitle(): string
    {
        return 'Pacientes';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nova paciente'),
        ];
    }
}
