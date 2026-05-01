<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\IsPlaceholderPage;
use Filament\Pages\Page;

class Relatorios extends Page
{
    use IsPlaceholderPage;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Relatórios';
    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.em-breve';
    protected static ?string $slug = 'relatorios';

    protected static ?string $placeholderSubtitle = 'Relatórios consolidados de pré-natal';
    protected static ?string $placeholderDescription = 'Geração de relatórios de cobertura, aderência ao pré-natal, intercorrências e desfechos por unidade e período.';

    /** @var array<int, string> */
    protected static array $placeholderHighlights = [
        'Cobertura de pré-natal por unidade',
        'Aderência ao calendário de consultas',
        'Distribuição de risco e intercorrências',
        'Exportação em PDF e CSV',
    ];
}
