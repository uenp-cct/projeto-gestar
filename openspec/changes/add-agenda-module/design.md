## Context

A página `Agenda` existe hoje apenas como placeholder. A equipe assistencial precisa programar atendimentos e acompanhar comparecimento.

## Goals / Non-Goals

**Goals:**
- Permitir agendar consultas e visitas para gestantes.
- Acompanhar comparecimento e ligar agendamento ao atendimento realizado.
- Visualização em calendário e em lista.

**Non-Goals:**
- Fila de espera ou triagem.
- Integração com sistemas externos do SUS nesta entrega.
- Telemedicina ou videochamada.

## Decisions

### Entidade `Agendamento` separada de `Atendimento`
Agendamento e atendimento têm ciclos distintos: um agendamento pode ser cancelado sem atendimento; um atendimento pode existir sem agendamento prévio (ex.: visita não programada). Manter separados, ligando por `atendimento_id` nullable quando ocorrer.

### Calendário no Filament via componente próprio
Implementar com pacote ou página customizada Filament que renderiza eventos por semana/mês. Lista padrão para fallback.

## Risks / Trade-offs

- Sem integração externa, agendamentos podem divergir de outras agendas das unidades.
- Status manual depende de disciplina da equipe.

## Migration Plan

1. Migration `create_agendamentos_table` e model.
2. Filament Resource `AgendamentoResource` e página de calendário.
3. Substituir a página placeholder no menu pelo resource real.

## Open Questions

- Canal preferido de lembretes (SMS, WhatsApp, e-mail)?
- A unidade básica é a mesma da gestante ou pode variar por agendamento?
