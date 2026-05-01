<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\IsPlaceholderPage;
use Filament\Pages\Page;

class Cadastros extends Page
{
    use IsPlaceholderPage;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Cadastros';
    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.em-breve';
    protected static ?string $slug = 'cadastros';

    protected static ?string $placeholderSubtitle = 'Cadastros de apoio do sistema';
    protected static ?string $placeholderDescription = 'Manutenção de tabelas auxiliares: unidades de saúde, profissionais, vacinas, exames de referência e listas clínicas.';

    /** @var array<int, string> */
    protected static array $placeholderHighlights = [
        'Unidades básicas e equipes',
        'Profissionais (gestores, médicos, enfermagem)',
        'Catálogo de vacinas e exames',
        'Listas clínicas (alergias, medicamentos)',
    ];
}
