@php
    $user = auth()->user();
    $unidade = $user?->unidade;
    $profissionalNome = $user?->name;
    $papel = $user?->papel;
@endphp

<x-filament-panels::page>
    <form wire:submit="create">
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
        <span>Data: {{ now()->format('d/m/Y H:i') }}</span>
    </div>
</x-filament-panels::page>
