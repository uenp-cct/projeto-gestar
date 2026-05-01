<?php

namespace Database\Factories;

use App\Models\Atendimento;
use App\Models\Gestante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Atendimento>
 */
class AtendimentoFactory extends Factory
{
    protected $model = Atendimento::class;

    public function definition(): array
    {
        return [
            'gestante_id' => Gestante::factory(),
            'data_atendimento' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'tipo_atendimento' => Atendimento::TIPO_CONSULTA,
            'estratificacao_risco' => Atendimento::RISCO_HABITUAL,
            'pa_sistolica' => fake()->numberBetween(90, 160),
            'pa_diastolica' => fake()->numberBetween(60, 110),
            'altura_uterina' => fake()->randomFloat(1, 10, 38),
        ];
    }

    public function alto(): static
    {
        return $this->state(fn () => [
            'estratificacao_risco' => Atendimento::RISCO_ALTO,
        ]);
    }
}
