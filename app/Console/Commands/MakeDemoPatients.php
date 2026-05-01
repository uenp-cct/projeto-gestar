<?php

namespace App\Console\Commands;

use App\Models\Atendimento;
use App\Models\Gestante;
use Faker\Factory as FakerFactory;
use Illuminate\Console\Command;

class MakeDemoPatients extends Command
{
    protected $signature = 'gestar:demo-patients
        {--count= : Quantidade de pacientes a gerar}
        {--seed= : Seed numerico para reprodutibilidade}';

    protected $description = 'Gera pacientes-exemplo (gestantes) com nomes em portugues e atendimentos variados.';

    public function handle(): int
    {
        $faker = FakerFactory::create('pt_BR');
        if ($seed = $this->option('seed')) {
            $faker->seed((int) $seed);
            mt_srand((int) $seed);
        }

        $count = (int) ($this->option('count') ?? 0);
        if ($count <= 0) {
            $count = (int) $this->ask('Quantos pacientes deseja gerar?', '10');
        }
        $count = max(1, min(500, $count));

        $this->newLine();
        $this->components->info("Gerando {$count} paciente(s) de exemplo...");

        $resumoRisco = [
            Atendimento::RISCO_HABITUAL => 0,
            Atendimento::RISCO_INTERMEDIARIO => 0,
            Atendimento::RISCO_ALTO => 0,
        ];
        $totalAtendimentos = 0;
        $totalComParto = 0;

        $bar = $this->output->createProgressBar($count);
        $bar->start();

        for ($i = 0; $i < $count; $i++) {
            $risco = $this->sortearRisco();
            $resumoRisco[$risco]++;

            $gestante = Gestante::create([
                'nome' => $faker->name('female'),
                'numero_sus' => $faker->numerify('############'),
                'data_nascimento' => $faker->dateTimeBetween('-42 years', '-18 years')->format('Y-m-d'),
                'endereco' => $faker->streetName(),
                'numero' => (string) $faker->numberBetween(1, 2500),
                'bairro' => $faker->citySuffix(),
                'fone' => $faker->cellphoneNumber(false),
                'email' => $faker->optional(0.6)->safeEmail(),
                'estratificacao_risco' => $risco,
                'condicao_risco' => $faker->optional(0.4)->sentence(8),
                'numero_gestacoes' => $faker->numberBetween(1, 5),
                'partos_normal' => $faker->numberBetween(0, 3),
                'partos_cesaria' => $faker->numberBetween(0, 2),
                'numero_abortos' => $faker->numberBetween(0, 1),
            ]);

            $qtdAtendimentos = random_int(1, 6);
            $totalAtendimentos += $qtdAtendimentos;

            $temParto = mt_rand(1, 100) <= 20 && $qtdAtendimentos >= 3;
            if ($temParto) {
                $totalComParto++;
            }

            $dataBase = $faker->dateTimeBetween('-8 months', '-1 weeks');

            for ($a = 0; $a < $qtdAtendimentos; $a++) {
                $data = (clone $dataBase)->modify('+'.($a * random_int(15, 35)).' days');
                if ($data > new \DateTimeImmutable('now')) {
                    $data = new \DateTimeImmutable('-3 days');
                }

                $partoNoUltimo = $temParto && $a === $qtdAtendimentos - 1;

                Atendimento::create([
                    'gestante_id' => $gestante->id,
                    'data_atendimento' => $data->format('Y-m-d'),
                    'tipo_atendimento' => $this->sortearTipoAtendimento(),
                    'estratificacao_risco' => $this->oscilarRisco($risco),
                    'estratificacao_observacao' => $faker->optional(0.3)->sentence(10),
                    'tabagismo' => $faker->randomElement([1, 1, 1, 2, 3]),
                    'alcool' => $faker->randomElement([1, 1, 1, 3, 2]),
                    'situacao_atual' => $faker->optional(0.5)->sentence(12),
                    'pa_sistolica' => $this->paSistolicaPorRisco($risco),
                    'pa_diastolica' => $this->paDiastolicaPorRisco($risco),
                    'altura_uterina' => $this->alturaUterinaPorOrdem($a, $qtdAtendimentos),
                    'edema' => $faker->randomElement([0, 0, 0, 1, 2, 3]),
                    'exame_fisico_observacoes' => $faker->optional(0.4)->sentence(10),
                    'vacinas' => $this->montarVacinas($faker),
                    'exames' => $this->montarExames($a, $qtdAtendimentos),
                    'exames_referencia' => $faker->optional(0.4)->sentence(8),
                    'data_parto' => $partoNoUltimo ? $data->format('Y-m-d') : null,
                    'tipo_parto' => $partoNoUltimo ? $faker->randomElement([1, 2]) : null,
                    'local_parto' => $partoNoUltimo ? 'Maternidade '.$faker->lastName() : null,
                    'sexo_rn' => $partoNoUltimo ? $faker->randomElement([1, 2]) : null,
                    'peso_rn' => $partoNoUltimo ? random_int(2400, 4100) : null,
                    'apgar_1' => $partoNoUltimo ? random_int(6, 9) : null,
                    'apgar_5' => $partoNoUltimo ? random_int(8, 10) : null,
                    'parto_observacoes' => $partoNoUltimo ? $faker->sentence(8) : null,
                    'anot_consulta_realizada' => $faker->boolean(70),
                    'anot_consulta' => $faker->optional(0.6)->sentence(10),
                    'anot_visita_realizada' => $faker->boolean(20),
                    'anot_visita' => $faker->optional(0.2)->sentence(10),
                    'anot_acoes_realizada' => $faker->boolean(30),
                    'anot_acoes' => $faker->optional(0.3)->sentence(10),
                    'anot_plano_realizado' => $faker->boolean(50),
                    'anot_plano' => $faker->optional(0.5)->sentence(12),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->components->info("Pacientes gerados: {$count}");
        $this->components->info("Atendimentos criados: {$totalAtendimentos}");
        $this->components->info("Pacientes com parto registrado: {$totalComParto}");
        $this->newLine();

        $this->table(
            ['Risco inicial', 'Pacientes'],
            [
                ['Habitual', $resumoRisco[Atendimento::RISCO_HABITUAL]],
                ['Intermediário', $resumoRisco[Atendimento::RISCO_INTERMEDIARIO]],
                ['Alto risco', $resumoRisco[Atendimento::RISCO_ALTO]],
            ],
        );

        return self::SUCCESS;
    }

    protected function sortearRisco(): int
    {
        $r = mt_rand(1, 100);
        if ($r <= 50) return Atendimento::RISCO_HABITUAL;
        if ($r <= 80) return Atendimento::RISCO_INTERMEDIARIO;

        return Atendimento::RISCO_ALTO;
    }

    protected function oscilarRisco(int $base): int
    {
        $r = mt_rand(1, 100);
        if ($r <= 80) {
            return $base;
        }

        return match ($base) {
            Atendimento::RISCO_HABITUAL => Atendimento::RISCO_INTERMEDIARIO,
            Atendimento::RISCO_INTERMEDIARIO => mt_rand(0, 1) ? Atendimento::RISCO_HABITUAL : Atendimento::RISCO_ALTO,
            default => Atendimento::RISCO_INTERMEDIARIO,
        };
    }

    protected function sortearTipoAtendimento(): int
    {
        $r = mt_rand(1, 100);
        if ($r <= 75) return Atendimento::TIPO_CONSULTA;
        if ($r <= 95) return Atendimento::TIPO_VISITA;

        return Atendimento::TIPO_OUTRO;
    }

    protected function paSistolicaPorRisco(int $risco): int
    {
        return match ($risco) {
            Atendimento::RISCO_HABITUAL => random_int(105, 125),
            Atendimento::RISCO_INTERMEDIARIO => random_int(118, 140),
            default => random_int(130, 165),
        };
    }

    protected function paDiastolicaPorRisco(int $risco): int
    {
        return match ($risco) {
            Atendimento::RISCO_HABITUAL => random_int(65, 80),
            Atendimento::RISCO_INTERMEDIARIO => random_int(75, 92),
            default => random_int(85, 105),
        };
    }

    protected function alturaUterinaPorOrdem(int $ordem, int $total): float
    {
        $base = 12 + ($ordem * (24 / max(1, $total)));

        return round($base + (mt_rand(-15, 15) / 10), 1);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    protected function montarVacinas(\Faker\Generator $faker): array
    {
        $statuses = ['pendente', 'aplicada', 'nao_aplica'];
        $out = [];
        foreach (['hepatite_b', 'influenza', 'dtpa', 'covid_19', 'outras'] as $v) {
            $status = $faker->randomElement($statuses);
            $out[$v] = [
                'aplicada' => $status === 'aplicada',
                'status' => $status,
            ];
        }
        $out['observacoes'] = $faker->optional(0.3)->sentence(6) ?? '';

        return $out;
    }

    /**
     * @return array<string, array<string, bool>>
     */
    protected function montarExames(int $ordem, int $total): array
    {
        $progresso = $total > 0 ? ($ordem + 1) / $total : 1;
        $out = [];
        foreach (['hemograma', 'glicemia', 'urina_eas', 'vdrl', 'hiv', 'ultrassonografia'] as $exame) {
            $out[$exame] = [
                't1' => mt_rand(0, 100) < (60 + $progresso * 30),
                't2' => mt_rand(0, 100) < (30 + $progresso * 50),
                't3' => mt_rand(0, 100) < ($progresso > 0.66 ? 70 : 15),
            ];
        }

        return $out;
    }
}
