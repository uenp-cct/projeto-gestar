<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gestante extends Model
{
    protected $fillable = [
        // I - Dados Cadastrais
        'nome', 'data_nascimento', 'endereco', 'numero', 'bairro', 'fone', 'email',

        // II - Dados Sociodemográficos
        'idade', 'cor', 'estado_conjugal', 'numero_filhos', 'escolaridade',
        'ocupacao', 'situacao_ocupacional', 'pessoas_residencia',
        'renda_familiar', 'renda_per_capita',

        // III - Antecedentes Pessoais
        'peso_antes_gestacao', 'altura', 'imc', 'estado_nutricional',
        'problemas_saude_pessoais', 'alergia', 'alergia_qual',
        'medicamento_diario', 'medicamento_qual',

        // IV - Antecedentes Familiares
        'problemas_saude_familia', 'parceiro_ist', 'parceiro_ist_qual',

        // V - Ginecológicos
        'ciclo_regular', 'duracao_ciclo', 'intervalo_ciclo', 'idade_menarca',
        'uso_anticoncepcional', 'qual_anticoncepcional',
        'teve_ist', 'qual_ist', 'cirurgia_ginecologica', 'qual_cirurgia',
        'patologias_mamas', 'qual_patologia_mamas', 'citologia',
        'data_citologia',

        // VI - Obstétricos
        'numero_gestacoes', 'intervalo_gestacoes', 'numero_abortos', 'ig_aborto',
        'partos_cesaria', 'partos_normal', 'idade_primeira_gestacao',
        'filhos_vivos', 'rn_prematuro', 'ig_prematuro', 'rn_baixo_peso',
        'peso_baixo_rn', 'morte_neonatal', 'idade_morte_neonatal',
        'intercorrencia_rn', 'qual_intercorrencia_rn',
        'intercorrencia_gestacao', 'qual_intercorrencia_gestacao',
        'intercorrencia_puerperio', 'qual_intercorrencia_puerperio',
        'aleitamento_anterior_duracao',

        // VII - Hábitos de Vida
        'tabagismo', 'tempo_tabagismo', 'cigarros_dia', 'fagerstrom_pontos',
        'fagerstrom_resultado', 'alcoolismo', 'frequencia_alcool',
        'quantidade_alcool', 'tempo_alcool', 't_ace_resultado',
        'drogas_ilicitas', 'quais_drogas', 'tempo_drogas',
        'atividade_fisica', 'tempo_atividade',

        // VIII - Gestação Atual
        'gestacao_planejada', 'tipo_gestacao', 'estratificacao_risco',
        'condicao_risco', 'dum', 'certeza_dum', 'dpp_dum', 'dpp_usg',
        'sinais_sintomas',
    ];

    protected $casts = [
        'dum' => 'date',
        'dpp_dum' => 'date',
        'dpp_usg' => 'date',
        'data_nascimento' => 'date',
        'data_citologia' => 'date',

        // jsons
        'problemas_saude_pessoais' => 'array',
        'problemas_saude_familia' => 'array',
    ];
}
