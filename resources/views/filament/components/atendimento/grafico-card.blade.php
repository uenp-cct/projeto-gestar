@php
    $livewire = $this ?? null;
    $record = $livewire?->record ?? null;
@endphp

<div class="gestar-chart-wrapper">
    @if ($record && $record->exists)
        @livewire(\App\Filament\Resources\AtendimentoResource\Widgets\PressaoArterialChart::class, ['record' => $record], key('pa-chart-'.$record->getKey()))
    @else
        <div class="flex h-full items-center justify-center text-center text-xs text-gray-500">
            Salve o atendimento para visualizar a evolução da pressão arterial.
        </div>
    @endif
</div>
