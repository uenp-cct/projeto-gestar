## Why

A gestão da unidade precisa de relatórios consolidados para acompanhar adesão ao pré-natal, distribuição de risco, intercorrências e desfechos. Hoje só há listagens cruas; sem visão consolidada, é impossível tomar decisões e prestar contas para o SUS.

## What Changes

- Criar o módulo Relatórios com painéis pré-definidos por unidade e período.
- Permitir exportação em PDF e CSV.
- Disponibilizar filtros por unidade, profissional, período, risco e tipo de atendimento.
- Suportar relatórios mínimos: cobertura de consultas, cobertura vacinal, exames realizados, intercorrências, desfechos perinatais.

## Capabilities

### New Capabilities
- `relatorios-module`: Geração de relatórios consolidados sobre o pré-natal, com filtros e exportação.

## Impact

- Backend: queries agregadas sobre `Atendimento` e `Gestante`.
- Filament: página de Relatórios com seleção de relatório, filtros e botão de exportação.
- PDF: usar pacote como `barryvdh/laravel-dompdf`.
