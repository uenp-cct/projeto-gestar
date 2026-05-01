<?php

namespace App\Filament\Resources\AtendimentoResource\Pages;

use App\Filament\Resources\AtendimentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAtendimentos extends ListRecords
{
    protected static string $resource = AtendimentoResource::class;

    public function getTitle(): string
    {
        return 'Atendimentos';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Novo atendimento'),
        ];
    }
}
