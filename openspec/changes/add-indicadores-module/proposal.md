## Why

Diferente de Relatórios, a equipe e a gestão precisam de um painel de indicadores em tempo real, com gráficos e KPIs do pré-natal. Isso permite ações imediatas, não só prestação de contas.

## What Changes

- Criar o módulo Indicadores com painel em tempo real.
- KPIs principais: cobertura de consultas por trimestre, cobertura vacinal, exames realizados, distribuição de risco, intercorrências.
- Filtros por unidade e período.
- Atualização automática (refresh) e exportação simples (PNG/CSV).

## Capabilities

### New Capabilities
- `indicadores-module`: Painel em tempo real com KPIs e gráficos do pré-natal.

## Impact

- Backend: queries agregadas e cache.
- Filament: Widgets de chart e cards de KPI.
- Performance: cache configurado para queries pesadas.
