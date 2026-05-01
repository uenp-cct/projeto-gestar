## Why

O sistema possui várias listas e referências hard-coded (vacinas, exames, riscos, hábitos). À medida que ele cresce, equipes precisam manter unidades de saúde, profissionais e catálogos sem depender de deploy. Um módulo Cadastros centraliza essa manutenção.

## What Changes

- Criar o módulo Cadastros com tabelas auxiliares de unidades de saúde, profissionais, catálogos de vacinas e exames, listas clínicas (alergias, medicamentos, problemas de saúde).
- Permitir CRUD por usuários autorizados.
- Migrar listas hoje hard-coded para tabelas configuráveis quando fizer sentido.

## Capabilities

### New Capabilities
- `cadastros-module`: Manutenção de tabelas auxiliares e catálogos clínicos.

## Impact

- Banco: novas tabelas `unidades`, `profissionais` (ou estender `users`), `catalogo_vacinas`, `catalogo_exames`, `listas_clinicas`.
- Filament: Resources para cada tabela auxiliar.
- Refactors em `Atendimento` e `Gestante` para passar a referenciar IDs em vez de strings.
