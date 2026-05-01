@php
    $record = $getRecord();
    $gId = $record->id;
@endphp

<div class="gestar-chart-wrapper-hub">
    @livewire(\App\Filament\Resources\AtendimentoResource\Widgets\PressaoArterialChart::class, ['gestante_id' => $gId], key('pa-chart-hub-' . $gId))
</div>
