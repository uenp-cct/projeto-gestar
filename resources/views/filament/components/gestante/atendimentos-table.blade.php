@php
    $record = $getRecord();
    $atendimentosList = $record->atendimentos()->with('profissional')->orderByDesc('data_atendimento')->get();
@endphp

<div class="gestar-atendimentos-table">
    @if ($atendimentosList->isEmpty())
        <div class="flex items-center justify-center py-8 text-sm text-gray-500">
            Nenhum atendimento registrado para esta paciente.
        </div>
    @else
        <div class="overflow-x-auto rounded-lg border" style="border-color: var(--gestar-card-border);">
            <table class="w-full text-sm">
                <thead>
                    <tr style="background: var(--gestar-active-bg);">
                        <th class="px-4 py-3 text-left font-semibold" style="color: var(--gestar-card-title);">#</th>
                        <th class="px-4 py-3 text-left font-semibold" style="color: var(--gestar-card-title);">Data</th>
                        <th class="px-4 py-3 text-left font-semibold" style="color: var(--gestar-card-title);">Tipo</th>
                        <th class="px-4 py-3 text-left font-semibold" style="color: var(--gestar-card-title);">Status</th>
                        <th class="px-4 py-3 text-left font-semibold" style="color: var(--gestar-card-title);">PA</th>
                        <th class="px-4 py-3 text-left font-semibold" style="color: var(--gestar-card-title);">Risco</th>
                        <th class="px-4 py-3 text-left font-semibold" style="color: var(--gestar-card-title);">Profissional</th>
                        <th class="px-4 py-3 text-center font-semibold" style="color: var(--gestar-card-title);">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($atendimentosList as $atendimento)
                        <tr class="border-t transition-colors hover:bg-gray-50" style="border-color: var(--gestar-card-border-light);">
                            <td class="px-4 py-3 font-medium" style="color: var(--gestar-primary);">#{{ $atendimento->id }}</td>
                            <td class="px-4 py-3" style="color: var(--gestar-text);">{{ optional($atendimento->data_atendimento)->format('d/m/Y') ?? '—' }}</td>
                            <td class="px-4 py-3" style="color: var(--gestar-text);">{{ \App\Models\Atendimento::TIPOS_ATENDIMENTO[$atendimento->tipo_atendimento] ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $statusColor = match($atendimento->status) {
                                        'finalizado' => 'bg-green-100 text-green-800',
                                        'rascunho' => 'bg-gray-100 text-gray-600',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusColor }}">
                                    {{ \App\Models\Atendimento::STATUSES[$atendimento->status] ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-3" style="color: var(--gestar-text);">
                                {{ $atendimento->pa_sistolica && $atendimento->pa_diastolica ? "{$atendimento->pa_sistolica}/{$atendimento->pa_diastolica}" : '—' }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $riscoColor = match((int) $atendimento->estratificacao_risco) {
                                        \App\Models\Atendimento::RISCO_HABITUAL => 'bg-green-100 text-green-800',
                                        \App\Models\Atendimento::RISCO_INTERMEDIARIO => 'bg-yellow-100 text-yellow-800',
                                        \App\Models\Atendimento::RISCO_ALTO => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $riscoColor }}">
                                    {{ \App\Models\Atendimento::RISCOS[$atendimento->estratificacao_risco] ?? '—' }}
                                </span>
                            </td>
                            <td class="px-4 py-3" style="color: var(--gestar-text);">{{ $atendimento->profissional?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ \App\Filament\Resources\AtendimentoResource::getUrl('view', ['record' => $atendimento]) }}"
                                   class="inline-flex items-center gap-1 rounded-md px-3 py-1.5 text-xs font-semibold transition-colors"
                                   style="background: var(--gestar-active-bg); color: var(--gestar-primary);">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
