<?php

namespace App\Filament\Resources\AtendimentoResource\Widgets;

use App\Models\Atendimento;
use App\Models\Gestante;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class PressaoArterialChart extends ChartWidget
{
    protected static ?string $heading = '11. Gráfico — Evolução da PA (mmHg)';

    protected static ?string $maxHeight = '260px';

    protected int | string | array $columnSpan = 'full';

    public ?Atendimento $record = null;

    /** @var array<string, mixed> */
    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
            ],
        ],
        'scales' => [
            'y' => [
                'beginAtZero' => false,
                'suggestedMin' => 60,
                'suggestedMax' => 180,
            ],
        ],
    ];

    public function getDescription(): string | Htmlable | null
    {
        $gestante = $this->resolveGestante();

        if (! $gestante) {
            return new HtmlString('Selecione uma gestante para visualizar a evolução da pressão arterial.');
        }

        if ($this->getCachedData()['datasets'][0]['data'] === []) {
            return new HtmlString('Sem registros de pressão arterial para esta gestante.');
        }

        return null;
    }

    protected function getData(): array
    {
        $gestante = $this->resolveGestante();

        if (! $gestante) {
            return [
                'labels' => [],
                'datasets' => [
                    ['label' => 'Sistólica', 'data' => []],
                    ['label' => 'Diastólica', 'data' => []],
                ],
            ];
        }

        $atendimentos = $gestante->atendimentos()
            ->reorder('data_atendimento', 'asc')
            ->whereNotNull('pa_sistolica')
            ->whereNotNull('pa_diastolica')
            ->get(['data_atendimento', 'pa_sistolica', 'pa_diastolica']);

        return [
            'labels' => $atendimentos->map(fn ($a) => optional($a->data_atendimento)->format('d/m/Y'))->all(),
            'datasets' => [
                [
                    'label' => 'Sistólica',
                    'data' => $atendimentos->pluck('pa_sistolica')->all(),
                    'borderColor' => '#2563eb',
                    'backgroundColor' => 'rgba(37, 99, 235, 0.15)',
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Diastólica',
                    'data' => $atendimentos->pluck('pa_diastolica')->all(),
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.15)',
                    'tension' => 0.3,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function resolveGestante(): ?Gestante
    {
        return $this->record?->gestante;
    }
}
