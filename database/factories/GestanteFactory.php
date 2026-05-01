<?php

namespace Database\Factories;

use App\Models\Gestante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gestante>
 */
class GestanteFactory extends Factory
{
    protected $model = Gestante::class;

    public function definition(): array
    {
        return [
            'nome' => fake()->name('female'),
            'numero_sus' => fake()->numerify('############'),
            'data_nascimento' => fake()->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
            'estratificacao_risco' => fake()->numberBetween(1, 3),
        ];
    }
}
