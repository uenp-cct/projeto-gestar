<div
    class="gestar-topbar-search"
    x-data="{ q: '' }"
    @keydown.enter="if (q.trim().length) { window.location = @js(\App\Filament\Resources\GestanteResource::getUrl('index')) + '?tableSearch=' + encodeURIComponent(q) }"
>
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="11" cy="11" r="7" />
        <line x1="21" y1="21" x2="16.65" y2="16.65" />
    </svg>
    <input
        type="text"
        x-model="q"
        placeholder="Buscar gestante (nome, SUS...)"
        aria-label="Buscar gestante"
    />
</div>
