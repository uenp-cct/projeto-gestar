## Why

A identidade visual do painel administrativo precisa refletir os protótipos do ProjetoGestar: cor primária azul clara, marca "ProjetoGestar" no topo e um menu lateral organizado pelos grupos Atendimento, Gestão e Sistema. Além disso, vários módulos previstos no protótipo (Agenda, Relatórios, Cadastros, Protocolos, Indicadores, Configurações) ainda não existem e precisam aparecer no menu como placeholders, sinalizando o roadmap sem confundir os usuários.

## What Changes

- Trocar cor primária do painel Filament de Amber para Sky e definir `brandName` "ProjetoGestar".
- Reorganizar `navigationGroups` em Atendimento, Gestão e Sistema, com ordens explícitas.
- Renomear visualmente o recurso de gestantes para "Pacientes" mantendo model e tabela inalterados.
- Adicionar páginas placeholder `Agenda`, `Relatórios`, `Cadastros`, `Protocolos`, `Indicadores` e `Configurações` em estado "Em breve" com descrição do escopo futuro.
- Compartilhar a view `em-breve.blade.php` para todos os placeholders, com título, subtítulo, descrição e destaques.

## Capabilities

### New Capabilities
- `admin-shell`: Identidade visual e navegação do painel administrativo do ProjetoGestar, incluindo placeholders dos módulos futuros.

### Modified Capabilities
- Nenhuma; `system.md` e `atendimento-page` permanecem coerentes.

## Impact

- Filament: alterações em `AdminPanelProvider`, em `GestanteResource` e `AtendimentoResource` para encaixar nos novos grupos.
- Páginas Filament novas em `app/Filament/Pages/` e trait `IsPlaceholderPage`.
- View Blade em `resources/views/filament/pages/em-breve.blade.php`.
- Documentação OpenSpec passa a registrar o shell administrativo como capacidade própria, separada da página de atendimento.
