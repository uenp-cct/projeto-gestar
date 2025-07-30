<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gestantes', function (Blueprint $table) {
            $table->id();
            
            // I - Dados cadastrais
            $table->string('nome');
            $table->date('data_nascimento')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('fone')->nullable();
            $table->string('email')->nullable();

            // II - Dados sociodemográficos
            $table->tinyInteger('idade')->nullable();
            $table->tinyInteger('cor')->nullable(); // 1=Branca, 2=Preta, 3=Parda
            $table->tinyInteger('estado_conjugal')->nullable(); // 1~4
            $table->tinyInteger('numero_filhos')->nullable(); // 1~3
            $table->tinyInteger('escolaridade')->nullable(); // 1~3
            $table->string('ocupacao')->nullable();
            $table->tinyInteger('situacao_ocupacional')->nullable(); // 1~5
            $table->tinyInteger('pessoas_residencia')->nullable();
            $table->decimal('renda_familiar', 10, 2)->nullable();
            $table->decimal('renda_per_capita', 10, 2)->nullable();

            // III - Antecedentes pessoais
            $table->decimal('peso_antes_gestacao', 5, 2)->nullable();
            $table->decimal('altura', 4, 2)->nullable();
            $table->decimal('imc', 5, 2)->nullable();
            $table->tinyInteger('estado_nutricional')->nullable(); // 1~4
            $table->json('problemas_saude_pessoais')->nullable(); // array de 1~9
            $table->boolean('alergia')->nullable();
            $table->string('alergia_qual')->nullable();
            $table->boolean('medicamento_diario')->nullable();
            $table->string('medicamento_qual')->nullable();

            // IV - Antecedentes familiares
            $table->json('problemas_saude_familia')->nullable();
            $table->boolean('parceiro_ist')->nullable();
            $table->string('parceiro_ist_qual')->nullable();

            // V - Ginecológicos
            $table->boolean('ciclo_regular')->nullable();
            $table->string('duracao_ciclo')->nullable();
            $table->string('intervalo_ciclo')->nullable();
            $table->tinyInteger('idade_menarca')->nullable();
            $table->boolean('uso_anticoncepcional')->nullable();
            $table->string('qual_anticoncepcional')->nullable();
            $table->boolean('teve_ist')->nullable();
            $table->string('qual_ist')->nullable();
            $table->boolean('cirurgia_ginecologica')->nullable();
            $table->string('qual_cirurgia')->nullable();
            $table->boolean('patologias_mamas')->nullable();
            $table->string('qual_patologia_mamas')->nullable();
            $table->boolean('citologia')->nullable();
            $table->date('data_citologia')->nullable();

            // VI - Obstétricos
            $table->tinyInteger('numero_gestacoes')->nullable();
            $table->string('intervalo_gestacoes')->nullable();
            $table->tinyInteger('numero_abortos')->nullable();
            $table->string('ig_aborto')->nullable();
            $table->tinyInteger('partos_cesaria')->nullable();
            $table->tinyInteger('partos_normal')->nullable();
            $table->tinyInteger('idade_primeira_gestacao')->nullable();
            $table->tinyInteger('filhos_vivos')->nullable();
            $table->boolean('rn_prematuro')->nullable();
            $table->string('ig_prematuro')->nullable();
            $table->boolean('rn_baixo_peso')->nullable();
            $table->decimal('peso_baixo_rn', 5, 2)->nullable();
            $table->boolean('morte_neonatal')->nullable();
            $table->string('idade_morte_neonatal')->nullable();
            $table->boolean('intercorrencia_rn')->nullable();
            $table->string('qual_intercorrencia_rn')->nullable();
            $table->boolean('intercorrencia_gestacao')->nullable();
            $table->string('qual_intercorrencia_gestacao')->nullable();
            $table->boolean('intercorrencia_puerperio')->nullable();
            $table->string('qual_intercorrencia_puerperio')->nullable();
            $table->string('aleitamento_anterior_duracao')->nullable();

            // VII - Hábitos de vida
            $table->tinyInteger('tabagismo')->nullable(); // 1, 2, 3
            $table->string('tempo_tabagismo')->nullable();
            $table->tinyInteger('cigarros_dia')->nullable();
            $table->tinyInteger('fagerstrom_pontos')->nullable();
            $table->string('fagerstrom_resultado')->nullable();
            $table->boolean('alcoolismo')->nullable();
            $table->string('frequencia_alcool')->nullable();
            $table->string('quantidade_alcool')->nullable();
            $table->string('tempo_alcool')->nullable();
            $table->string('t_ace_resultado')->nullable();
            $table->boolean('drogas_ilicitas')->nullable();
            $table->string('quais_drogas')->nullable();
            $table->string('tempo_drogas')->nullable();
            $table->tinyInteger('atividade_fisica')->nullable(); // 1 ou 2
            $table->string('tempo_atividade')->nullable();

            // VIII - Gestação atual
            $table->boolean('gestacao_planejada')->nullable();
            $table->tinyInteger('tipo_gestacao')->nullable(); // 1 ou 2
            $table->tinyInteger('estratificacao_risco')->nullable(); // 1~3
            $table->text('condicao_risco')->nullable();
            $table->date('dum')->nullable();
            $table->string('certeza_dum')->nullable();
            $table->date('dpp_dum')->nullable();
            $table->date('dpp_usg')->nullable();
            $table->text('sinais_sintomas')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestantes');
    }
};
