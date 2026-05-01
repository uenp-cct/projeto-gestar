## Context

Hoje os catálogos de vacinas, exames e listas clínicas estão fixos no código. Listas auxiliares como unidades e profissionais inexistem.

## Goals / Non-Goals

**Goals:**
- Centralizar manutenção de tabelas de apoio.
- Manter compatibilidade com dados existentes em JSON (vacinas/exames).

**Non-Goals:**
- Sincronização externa com SUS/CNES.
- Templates de catálogos por estado/município nesta entrega.

## Decisions

### Manter JSON em `Atendimento`, mas validar contra catálogo
O catálogo passa a ser fonte de verdade para chaves válidas. A persistência continua em JSON para flexibilidade.

## Risks / Trade-offs

- Listas grandes podem impactar UI -> usar select com busca e cache.

## Migration Plan

1. Criar migrations e Resources Filament.
2. Migrar valores fixos para registros iniciais via seeders.
3. Atualizar `AtendimentoResource` para ler do catálogo.

## Open Questions

- Algumas listas são por unidade ou globais?
- Profissionais devem ser entidade própria ou apenas estender `User` com papéis?
