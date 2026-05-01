<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Atendimento extends Model
{
    use HasFactory;

    public const RISCO_HABITUAL = 1;
    public const RISCO_INTERMEDIARIO = 2;
    public const RISCO_ALTO = 3;

    public const RISCOS = [
        self::RISCO_HABITUAL => 'Habitual',
        self::RISCO_INTERMEDIARIO => 'Intermediário',
        self::RISCO_ALTO => 'Alto risco',
    ];

    public const TIPO_CONSULTA = 1;
    public const TIPO_VISITA = 2;
    public const TIPO_OUTRO = 3;

    public const TIPOS_ATENDIMENTO = [
        self::TIPO_CONSULTA => 'Consulta',
        self::TIPO_VISITA => 'Visita domiciliar',
        self::TIPO_OUTRO => 'Outro',
    ];

    protected $fillable = [
        'gestante_id',
        'user_id',
        'data_atendimento',
        'tipo_atendimento',

        'estratificacao_risco',
        'estratificacao_observacao',

        'tabagismo',
        'alcool',
        'situacao_atual',

        'pa_sistolica',
        'pa_diastolica',
        'altura_uterina',
        'edema',
        'exame_fisico_observacoes',

        'vacinas',
        'exames',
        'exames_referencia',

        'data_parto',
        'tipo_parto',
        'local_parto',
        'sexo_rn',
        'peso_rn',
        'apgar_1',
        'apgar_5',
        'parto_observacoes',

        'anot_consulta_realizada',
        'anot_consulta',
        'anot_visita_realizada',
        'anot_visita',
        'anot_acoes_realizada',
        'anot_acoes',
        'anot_plano_realizado',
        'anot_plano',
    ];

    protected $casts = [
        'data_atendimento' => 'date',
        'data_parto' => 'date',

        'tipo_atendimento' => 'integer',
        'estratificacao_risco' => 'integer',
        'tabagismo' => 'integer',
        'alcool' => 'integer',
        'tipo_parto' => 'integer',
        'sexo_rn' => 'integer',
        'edema' => 'integer',

        'pa_sistolica' => 'integer',
        'pa_diastolica' => 'integer',
        'peso_rn' => 'integer',
        'apgar_1' => 'integer',
        'apgar_5' => 'integer',
        'altura_uterina' => 'decimal:2',

        'vacinas' => 'array',
        'exames' => 'array',

        'anot_consulta_realizada' => 'boolean',
        'anot_visita_realizada' => 'boolean',
        'anot_acoes_realizada' => 'boolean',
        'anot_plano_realizado' => 'boolean',
    ];

    public function gestante(): BelongsTo
    {
        return $this->belongsTo(Gestante::class);
    }

    public function profissional(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
