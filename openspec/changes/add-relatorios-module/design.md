## Context

Os dados do domínio já existem em `Gestante` e `Atendimento`. Falta uma camada de leitura consolidada e exportação.

## Goals / Non-Goals

**Goals:**
- Gerar relatórios pré-definidos rapidamente.
- Permitir exportação em PDF e CSV.
- Filtros padrão por unidade, período, risco.

**Non-Goals:**
- Construtor visual de relatórios livres nesta entrega.
- Painéis em tempo real (isso é Indicadores).

## Decisions

### Service de relatórios
Criar `App\Services\Reports\PrenatalReports` com métodos por relatório, retornando coleções/arrays prontos para a UI e o exportador.

### Exportação
Usar `League\Csv` para CSV e `barryvdh/laravel-dompdf` para PDF. Templates Blade para PDF.

## Risks / Trade-offs

- Relatórios pesados podem demorar -> paginar ou rodar em fila.

## Migration Plan

1. Adicionar service de relatórios e dependências.
2. Implementar relatórios mínimos.
3. Substituir o placeholder.

## Open Questions

- Quais relatórios são realmente prioritários para a primeira release?
- Há padrão visual para PDFs da unidade?
