@php
    $user = auth()->user();
    $unread = $user ? $user->unreadNotifications()->count() : 0;
    $papel = $user?->papel;
    $unidade = $user?->unidade;
    $iniciais = $user?->name
        ? collect(preg_split('/\s+/', trim($user->name)))
            ->filter()
            ->take(2)
            ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))
            ->implode('')
        : '';
@endphp

<div class="flex items-center gap-4">
    <button type="button" class="gestar-topbar-bell" aria-label="Notificações" title="Notificações">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
            <path d="M10 21a2 2 0 0 0 4 0" />
        </svg>
        @if ($unread > 0)
            <span class="gestar-topbar-badge">{{ $unread > 99 ? '99+' : $unread }}</span>
        @endif
    </button>

    <div class="gestar-topbar-profile">
        <div class="gestar-topbar-profile-avatar">
            {{ $iniciais ?: '?' }}
        </div>
        <div class="gestar-topbar-profile-text">
            @if ($papel)
                <strong>{{ $papel }}</strong>
            @elseif ($user?->name)
                <strong>{{ $user->name }}</strong>
            @endif
            @if ($unidade)
                <span>{{ $unidade }}</span>
            @endif
        </div>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <polyline points="6 9 12 15 18 9" />
        </svg>
    </div>
</div>
