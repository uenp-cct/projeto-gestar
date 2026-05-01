<?php

namespace App\Filament\Pages;

use App\Filament\Pages\Concerns\IsPlaceholderPage;
use Filament\Pages\Page;

class Agenda extends Page
{
    use IsPlaceholderPage;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationLabel = 'Agenda';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.em-breve';
    protected static ?string $slug = 'agenda';

    protected static ?string $placeholderSubtitle = 'Agendamento de consultas e visitas';
    protected static ?string $placeholderDescription = 'Aqui você poderá agendar consultas e visitas domiciliares, visualizar a semana em calendário e enviar lembretes para gestantes.';

    /** @var array<int, string> */
    protected static array $placeholderHighlights = [
        'Calendário semanal e mensal por profissional',
        'Agendamento por gestante e por unidade',
        'Status de consulta: agendada, confirmada, realizada, faltou',
        'Lembretes automáticos por canal preferido',
    ];
}
