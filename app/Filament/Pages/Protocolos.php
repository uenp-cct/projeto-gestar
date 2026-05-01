<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\IsPlaceholderPage;
use Filament\Pages\Page;

class Protocolos extends Page
{
    use IsPlaceholderPage;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Protocolos';
    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament.pages.em-breve';
    protected static ?string $slug = 'protocolos';

    protected static ?string $placeholderSubtitle = 'Protocolos clínicos e fluxos';
    protected static ?string $placeholderDescription = 'Biblioteca de protocolos do pré-natal, fluxos por estratificação de risco e checklists obrigatórios por trimestre.';

    /** @var array<int, string> */
    protected static array $placeholderHighlights = [
        'Protocolo de risco habitual / intermediário / alto',
        'Checklists por trimestre',
        'Fluxos de encaminhamento',
        'Versionamento por publicação',
    ];
}
