<?php

namespace Tests\Feature;

use App\Filament\Resources\AtendimentoResource;
use App\Filament\Resources\AtendimentoResource\Widgets\PressaoArterialChart;
use App\Filament\Resources\GestanteResource;
use App\Models\Atendimento;
use App\Models\Gestante;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtendimentoResourceBootTest extends TestCase
{
    use RefreshDatabase;

    public function test_atendimento_resource_is_configured(): void
    {
        $this->assertSame(Atendimento::class, AtendimentoResource::getModel());

        $pages = AtendimentoResource::getPages();
        $this->assertArrayHasKey('index', $pages);
        $this->assertArrayHasKey('create', $pages);
        $this->assertArrayHasKey('edit', $pages);

        $this->assertContains(PressaoArterialChart::class, AtendimentoResource::getWidgets());
    }

    public function test_gestante_resource_lists_atendimento_count(): void
    {
        $gestante = Gestante::factory()->create();
        Atendimento::factory()->for($gestante)->count(2)->create();

        $this->assertSame(2, $gestante->atendimentos()->count());
        $this->assertSame(Gestante::class, GestanteResource::getModel());
    }

    public function test_pressure_chart_widget_returns_data_for_record(): void
    {
        $gestante = Gestante::factory()->create();
        Atendimento::factory()->for($gestante)->create([
            'data_atendimento' => '2026-02-10',
            'pa_sistolica' => 118,
            'pa_diastolica' => 76,
        ]);
        $atendimento = Atendimento::factory()->for($gestante)->create([
            'data_atendimento' => '2026-04-12',
            'pa_sistolica' => 142,
            'pa_diastolica' => 92,
        ]);

        $widget = new PressaoArterialChart();
        $widget->record = $atendimento->fresh(['gestante']);

        $reflection = new \ReflectionMethod($widget, 'getData');
        $reflection->setAccessible(true);
        $data = $reflection->invoke($widget);

        $this->assertSame(['10/02/2026', '12/04/2026'], $data['labels']);
        $this->assertSame([118, 142], $data['datasets'][0]['data']);
        $this->assertSame([76, 92], $data['datasets'][1]['data']);
    }

    public function test_pressure_chart_widget_returns_empty_for_no_record(): void
    {
        $widget = new PressaoArterialChart();
        $widget->record = null;

        $reflection = new \ReflectionMethod($widget, 'getData');
        $reflection->setAccessible(true);
        $data = $reflection->invoke($widget);

        $this->assertSame([], $data['labels']);
        $this->assertSame([], $data['datasets'][0]['data']);
    }
}
