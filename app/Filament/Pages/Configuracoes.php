<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\IsPlaceholderPage;
use Filament\Pages\Page;

class Configuracoes extends Page
{
    use IsPlaceholderPage;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Configurações';
    protected static ?int $navigationSort = 8;

    protected static string $view = 'filament.pages.em-breve';
    protected static ?string $slug = 'configuracoes';

    protected static ?string $placeholderSubtitle = 'Configurações da unidade e do sistema';
    protected static ?string $placeholderDescription = 'Preferências da unidade, papéis de usuário, integrações e parâmetros gerais do ProjetoGestar.';

    /** @var array<int, string> */
    protected static array $placeholderHighlights = [
        'Perfil da unidade básica',
        'Papéis e permissões',
        'Integrações e webhooks',
        'Backup e auditoria',
    ];
}
