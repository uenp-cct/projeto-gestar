## Context

A autenticação atual é o `User` padrão do Laravel. Não há papéis ou auditoria estruturada.

## Goals / Non-Goals

**Goals:**
- Centralizar configurações em um módulo.
- Permitir papéis de usuário com permissões claras.
- Registrar auditoria básica.

**Non-Goals:**
- Multi-tenant completo nesta entrega.
- SSO externo.

## Decisions

### `spatie/laravel-permission`
Adotar `spatie/laravel-permission` para papéis e permissões, padrão na comunidade Laravel.

### Auditoria simples
Usar `OwenIt/auditing` ou tabela própria `audit_logs` para registrar ações sensíveis (mudança de papel, exclusão de gestante).

## Risks / Trade-offs

- Permissões mal configuradas podem bloquear o uso -> presets seguros e modo dev.

## Migration Plan

1. Adicionar dependências e migrations.
2. Criar páginas de configuração no Filament.
3. Substituir placeholder.
4. Aplicar policies em recursos críticos.

## Open Questions

- Lista exata de papéis para o ProjetoGestar?
- Quais ações precisam de auditoria obrigatória?
