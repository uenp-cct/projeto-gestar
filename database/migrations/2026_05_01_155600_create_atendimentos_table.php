<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('atendimentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gestante_id')
                ->constrained('gestantes')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('data_atendimento');
            $table->tinyInteger('tipo_atendimento')->nullable()->comment('1=Consulta,2=Visita domiciliar,3=Outro');

            // Estratificacao de risco: 1=Habitual, 2=Intermediario, 3=Alto risco
            $table->tinyInteger('estratificacao_risco')->nullable();
            $table->text('estratificacao_observacao')->nullable();

            // Habitos de vida (snapshot por atendimento)
            $table->tinyInteger('tabagismo')->nullable()->comment('1=Nao,2=Sim,3=Ex-tabagista');
            $table->tinyInteger('alcool')->nullable()->comment('1=Nao,2=Sim,3=Socialmente');

            $table->text('situacao_atual')->nullable();

            // Exame fisico
            $table->unsignedSmallInteger('pa_sistolica')->nullable();
            $table->unsignedSmallInteger('pa_diastolica')->nullable();
            $table->decimal('altura_uterina', 5, 2)->nullable();
            $table->tinyInteger('edema')->nullable()->comment('0=Ausente,1=+,2=++,3=+++');
            $table->text('exame_fisico_observacoes')->nullable();

            // Vacinas/exames laboratoriais como JSON estruturado por atendimento
            $table->json('vacinas')->nullable();
            $table->json('exames')->nullable();
            $table->text('exames_referencia')->nullable();

            // Dados do parto e RN (preenchidos quando aplicavel)
            $table->date('data_parto')->nullable();
            $table->tinyInteger('tipo_parto')->nullable()->comment('1=Vaginal,2=Cesarea');
            $table->string('local_parto')->nullable();
            $table->tinyInteger('sexo_rn')->nullable()->comment('1=Feminino,2=Masculino');
            $table->unsignedSmallInteger('peso_rn')->nullable()->comment('em gramas');
            $table->tinyInteger('apgar_1')->nullable();
            $table->tinyInteger('apgar_5')->nullable();
            $table->text('parto_observacoes')->nullable();

            // Anotacoes do gestor (cada item: feito + observacao)
            $table->boolean('anot_consulta_realizada')->default(false);
            $table->text('anot_consulta')->nullable();
            $table->boolean('anot_visita_realizada')->default(false);
            $table->text('anot_visita')->nullable();
            $table->boolean('anot_acoes_realizada')->default(false);
            $table->text('anot_acoes')->nullable();
            $table->boolean('anot_plano_realizado')->default(false);
            $table->text('anot_plano')->nullable();

            $table->timestamps();

            $table->index(['gestante_id', 'data_atendimento']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('atendimentos');
    }
};
