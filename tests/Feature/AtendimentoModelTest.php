<?php

namespace Tests\Feature;

use App\Models\Atendimento;
use App\Models\Gestante;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtendimentoModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_atendimento_belongs_to_gestante(): void
    {
        $gestante = Gestante::factory()->create();

        $atendimento = Atendimento::factory()
            ->for($gestante)
            ->create([
                'data_atendimento' => '2026-04-15',
                'pa_sistolica' => 120,
                'pa_diastolica' => 80,
            ]);

        $this->assertSame($gestante->id, $atendimento->gestante_id);
        $this->assertSame($gestante->id, $atendimento->gestante->id);
        $this->assertTrue($gestante->atendimentos->contains($atendimento));
    }

    public function test_gestante_has_many_atendimentos_ordered_desc(): void
    {
        $gestante = Gestante::factory()->create();

        $older = Atendimento::factory()->for($gestante)->create([
            'data_atendimento' => '2026-01-10',
        ]);
        $newer = Atendimento::factory()->for($gestante)->create([
            'data_atendimento' => '2026-04-20',
        ]);

        $ids = $gestante->atendimentos()->pluck('id')->all();
        $this->assertSame([$newer->id, $older->id], $ids);
    }

    public function test_clinical_groups_are_persisted_as_arrays(): void
    {
        $gestante = Gestante::factory()->create();

        $atendimento = Atendimento::factory()->for($gestante)->create([
            'vacinas' => [
                'hepatite_b' => 'pendente',
                'influenza' => 'aplicada',
            ],
            'exames' => [
                'hemograma' => ['t1' => true, 't2' => false, 't3' => false],
                'glicemia' => ['t1' => true, 't2' => true, 't3' => false],
            ],
            'estratificacao_risco' => Atendimento::RISCO_INTERMEDIARIO,
            'anot_consulta_realizada' => true,
            'anot_consulta' => 'Consulta de pré-natal sem intercorrências',
        ]);

        $atendimento->refresh();

        $this->assertSame('aplicada', $atendimento->vacinas['influenza']);
        $this->assertTrue($atendimento->exames['glicemia']['t1']);
        $this->assertSame(Atendimento::RISCO_INTERMEDIARIO, $atendimento->estratificacao_risco);
        $this->assertTrue($atendimento->anot_consulta_realizada);
    }

    public function test_pa_history_is_available_for_chart(): void
    {
        $gestante = Gestante::factory()->create();

        Atendimento::factory()->for($gestante)->create([
            'data_atendimento' => '2026-01-10',
            'pa_sistolica' => 110,
            'pa_diastolica' => 70,
        ]);
        Atendimento::factory()->for($gestante)->create([
            'data_atendimento' => '2026-03-15',
            'pa_sistolica' => 130,
            'pa_diastolica' => 85,
        ]);

        $serie = $gestante->atendimentos()
            ->reorder('data_atendimento', 'asc')
            ->whereNotNull('pa_sistolica')
            ->whereNotNull('pa_diastolica')
            ->get(['data_atendimento', 'pa_sistolica', 'pa_diastolica']);

        $this->assertCount(2, $serie);
        $this->assertSame(110, $serie[0]->pa_sistolica);
        $this->assertSame(85, $serie[1]->pa_diastolica);
    }
}
