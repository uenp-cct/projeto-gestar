## Context

Os dados existem em `Atendimento` e `Gestante`. Falta uma camada de leitura otimizada para painéis em tempo real.

## Goals / Non-Goals

**Goals:**
- Painel rápido com KPIs e gráficos.
- Filtros básicos por unidade e período.

**Non-Goals:**
- Construtor de dashboards customizados.
- Integração externa BI nesta entrega.

## Decisions

### Cache de KPIs por filtro
Usar cache de 5 min por combinação unidade/período para reduzir custo.

### Reaproveitar widgets do Filament
Usar `ChartWidget` e `StatsOverviewWidget` em uma página de dashboard própria.

## Risks / Trade-offs

- Cache pode atrasar reflexo de novos dados em até 5 min -> aceitável.

## Migration Plan

1. Service de KPIs com cache.
2. Página de Indicadores com widgets.
3. Substituir placeholder.

## Open Questions

- Quais 6 KPIs realmente saem na primeira release?
- Refresh automático em quanto tempo?
