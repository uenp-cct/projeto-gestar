<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <h3 class="mb-4 text-sm font-medium text-gray-900 dark:text-white">
                Evolução da PA (mmHg)
            </h3>
            
            <div class="h-64 flex items-center justify-center text-gray-500">
                @php
                    $gestanteId = $getRecord()?->gestante_id;
                @endphp
                
                @if(filled($gestanteId))
                    @livewire(\App\Filament\Resources\AtendimentoResource\Widgets\PressaoArterialChart::class, ['gestante_id' => $gestanteId])
                @else
                    <p class="text-sm text-center">
                        Selecione uma gestante e salve o atendimento para visualizar o gráfico de evolução da PA.
                    </p>
                @endif
            </div>
        </div>
    </div>
</x-dynamic-component>
