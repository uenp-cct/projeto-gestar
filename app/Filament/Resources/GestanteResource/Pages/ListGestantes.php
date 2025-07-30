<?php

namespace App\Filament\Resources\GestanteResource\Pages;

use App\Filament\Resources\GestanteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class ListGestantes extends ListRecords
{
    protected static string $resource = GestanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nova gestante'),
        ];
    }

    public function getTitle(): string
    {

        return 'Gestantes cadastradas';
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()->label('Editar'),
            DeleteAction::make()->label('Excluir'),
        ];
    }
}
