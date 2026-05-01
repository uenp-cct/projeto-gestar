<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\IsPlaceholderPage;
use Filament\Pages\Page;

class Indicadores extends Page
{
    use IsPlaceholderPage;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Indicadores';
    protected static ?int $navigationSort = 7;

    protected static string $view = 'filament.pages.em-breve';
    protected static ?string $slug = 'indicadores';

    protected static ?string $placeholderSubtitle = 'Painel de indicadores de pré-natal';
    protected static ?string $placeholderDescription = 'Indicadores em tempo real de adesão ao pré-natal, cobertura vacinal, exames realizados e desfechos perinatais.';

    /** @var array<int, string> */
    protected static array $placeholderHighlights = [
        'Cobertura de consultas por trimestre',
        'Cobertura vacinal por gestante',
        'Pressão arterial e ganho de peso',
        'Desfechos perinatais',
    ];
}
