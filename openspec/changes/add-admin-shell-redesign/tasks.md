## 1. Painel Filament

- [ ] 1.1 Definir `brandName('ProjetoGestar')` em `AdminPanelProvider`.
- [ ] 1.2 Trocar a cor primária para `Color::Sky`.
- [ ] 1.3 Configurar `navigationGroups(['Atendimento','Gestão','Sistema'])`.

## 2. Recursos existentes

- [ ] 2.1 Renomear labels de `GestanteResource` para Pacientes e mover para o grupo Atendimento.
- [ ] 2.2 Manter `AtendimentoResource` no grupo Atendimento com `navigationSort` 1.

## 3. Páginas placeholder

- [ ] 3.1 Criar trait `IsPlaceholderPage` com `getViewData`.
- [ ] 3.2 Criar view `resources/views/filament/pages/em-breve.blade.php`.
- [ ] 3.3 Adicionar páginas Agenda, Relatórios, Cadastros, Protocolos, Indicadores e Configurações.

## 4. Validação

- [ ] 4.1 Rodar `php artisan filament:cache-components`.
- [ ] 4.2 Conferir rotas `admin/agenda`, `admin/relatorios`, etc.
- [ ] 4.3 Validar OpenSpec com `openspec validate add-admin-shell-redesign`.
