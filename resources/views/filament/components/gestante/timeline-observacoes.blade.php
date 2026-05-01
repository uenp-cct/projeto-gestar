@php
    $record = $getRecord();
    $atendimentosList = $record->atendimentos()->with('profissional')->orderByDesc('data_atendimento')->get();

    // Campos de observações a exibir na timeline
    $camposObs = [
        'situacao_atual' => 'Situação atual',
        'exame_fisico_observacoes' => 'Exame físico',
        'anot_consulta' => 'Consulta',
        'anot_visita' => 'Visita domiciliar',
        'anot_acoes' => 'Ações educativas',
        'anot_plano' => 'Plano de cuidado',
        'parto_observacoes' => 'Observações do parto',
    ];
@endphp

<div class="gestar-timeline">
    <h3 class="gestar-timeline-title">
        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        Linha do tempo — Observações por atendimento
    </h3>

    @if ($atendimentosList->isEmpty())
        <div class="flex items-center justify-center py-8 text-sm text-gray-500">
            Nenhum atendimento registrado.
        </div>
    @else
        <div class="gestar-timeline-list">
            @foreach ($atendimentosList as $atendimento)
                @php
                    // Coleta observações preenchidas
                    $obs = collect($camposObs)
                        ->filter(fn ($label, $campo) => ! empty($atendimento->{$campo}))
                        ->map(fn ($label, $campo) => ['label' => $label, 'text' => $atendimento->{$campo}]);

                    // Vacinas observações (campo JSON)
                    $vacinas = $atendimento->vacinas;
                    if (is_array($vacinas) && ! empty($vacinas['observacoes'])) {
                        $obs->put('vacinas_obs', ['label' => 'Vacinas (obs.)', 'text' => $vacinas['observacoes']]);
                    }

                    $riscoModifier = match ((int) $atendimento->estratificacao_risco) {
                        \App\Models\Atendimento::RISCO_HABITUAL => 'gestar-timeline-item--habitual',
                        \App\Models\Atendimento::RISCO_INTERMEDIARIO => 'gestar-timeline-item--intermediario',
                        \App\Models\Atendimento::RISCO_ALTO => 'gestar-timeline-item--alto',
                        default => 'gestar-timeline-item--default',
                    };
                @endphp

                <article class="gestar-timeline-item {{ $riscoModifier }}">
                    <div class="gestar-timeline-dot"></div>
                    <div class="gestar-timeline-content">
                        <div class="gestar-timeline-header">
                            <div class="gestar-timeline-meta">
                                <span class="gestar-timeline-id">#{{ $atendimento->id }}</span>
                                <span class="gestar-timeline-date">{{ optional($atendimento->data_atendimento)->format('d/m/Y') }}</span>
                                @if ($atendimento->pa_sistolica && $atendimento->pa_diastolica)
                                    <span class="gestar-timeline-pa">PA {{ $atendimento->pa_sistolica }}/{{ $atendimento->pa_diastolica }}</span>
                                @endif
                            </div>
                            <div class="gestar-timeline-prof">
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                {{ $atendimento->profissional?->name ?? 'Profissional não informado' }}
                            </div>
                        </div>

                        @if ($obs->isNotEmpty())
                            <div class="gestar-timeline-body">
                                <dl class="gestar-timeline-dl">
                                    @foreach ($obs as $item)
                                        <div class="gestar-timeline-obs">
                                            <dt class="gestar-timeline-obs-label">{{ $item['label'] }}</dt>
                                            <dd class="gestar-timeline-obs-text">{{ $item['text'] }}</dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </div>
                        @else
                            <div class="gestar-timeline-body gestar-timeline-body--empty">
                                <span class="text-xs text-gray-400 italic">Sem observações registradas neste atendimento.</span>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
