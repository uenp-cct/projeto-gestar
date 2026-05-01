@php
    $record = $this->record;
    $unidade = $record?->profissional?->unidade ?? auth()->user()?->unidade;
    $profissionalNome = $record?->profissional?->name ?? auth()->user()?->name;
    $papel = $record?->profissional?->papel ?? auth()->user()?->papel;
    $dataAtendimento = $record?->data_atendimento?->format('d/m/Y') ?? now()->format('d/m/Y');
@endphp

<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </form>

    <div class="gestar-page-footer">
        @if ($unidade)
            <span>Unidade: {{ $unidade }}</span>
        @endif
        @if ($profissionalNome)
            <span>Profissional: {{ $papel ? $papel.' — '.$profissionalNome : $profissionalNome }}</span>
        @endif
        <span>Data: {{ $dataAtendimento }}</span>
    </div>
</x-filament-panels::page>
