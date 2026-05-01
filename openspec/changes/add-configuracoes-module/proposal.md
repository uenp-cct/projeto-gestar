## Why

Cada unidade precisa configurar dados próprios (perfil, papéis de usuário, integrações, parâmetros gerais). Hoje não há lugar para isso. Configurações também consolidam preferências do sistema (timezone, formatos, idiomas).

## What Changes

- Criar o módulo Configurações com perfil da unidade, papéis e permissões, integrações e parâmetros gerais.
- Suportar autenticação por papéis (gestor, profissional, administrador).
- Permitir backup e auditoria básica de ações sensíveis.

## Capabilities

### New Capabilities
- `configuracoes-module`: Configurações da unidade e do sistema, com papéis de usuário e auditoria.

## Impact

- Banco: tabelas de papéis e auditoria; possivelmente uso de `spatie/laravel-permission`.
- Filament: páginas de configuração e gestão de papéis.
- Backend: middleware/policies por papel.
