## Context

O painel administrativo é construído em Filament v3. Hoje ele usa cor Amber e expõe apenas Gestantes e Atendimentos. Os protótipos definem uma navegação maior (Atendimentos, Pacientes, Agenda, Relatórios, Cadastros, Protocolos, Indicadores, Configurações), com identidade azul clara e marca "ProjetoGestar".

## Goals / Non-Goals

**Goals:**
- Aplicar a identidade do protótipo (cor, marca, agrupamentos) sem alterar fluxos clínicos.
- Tornar visíveis os módulos futuros como placeholders, com texto consistente.
- Garantir que cada módulo futuro tenha um ponto de entrada navegável já no menu.

**Non-Goals:**
- Implementar lógica funcional de Agenda/Relatórios/Cadastros/Protocolos/Indicadores/Configurações nesta entrega.
- Criar tema CSS customizado fora dos tokens do Filament.
- Reescrever `GestanteResource` ou `AtendimentoResource` além dos labels e do agrupamento.

## Decisions

### Cor primária Sky em vez de Amber
A cor Sky do Filament é um azul claro que combina com o protótipo e mantém contraste em modo escuro. Evita criar um pacote de tema novo só para isso.

Alternativa considerada: importar paleta custom via `register_theme`. Rejeitada pelo custo de manutenção sem ganho real.

### Brand name no `AdminPanelProvider`
`->brandName('ProjetoGestar')` é a forma oficial de definir o título no topo. Não é necessário logo SVG nesta entrega; pode ser adicionado depois com `->brandLogo(...)`.

### Placeholders compartilhando uma única view
Para evitar duplicação, criar `resources/views/filament/pages/em-breve.blade.php` que recebe título, subtítulo, descrição e destaques via `getViewData()` em uma trait `IsPlaceholderPage`.

Alternativa considerada: uma view por página. Rejeitada por trazer manutenção desnecessária.

### Recurso de gestantes renomeado para "Pacientes"
Mantém o model `Gestante` e a tabela `gestantes`, apenas troca `navigationLabel`, `modelLabel` e `pluralModelLabel`. Garante alinhamento com o protótipo sem migração de dados.

## Risks / Trade-offs

- Usuários atuais podem estranhar o termo "Pacientes" -> mitigar mantendo `Gestante` em conteúdos clínicos quando fizer sentido (anotações, relatórios futuros).
- Placeholders podem ser confundidos com módulos prontos -> tag visível "Em breve" e descrição explícita.

## Migration Plan

1. Atualizar `AdminPanelProvider` (cor, brand, grupos).
2. Ajustar labels e grupos de `GestanteResource` e `AtendimentoResource`.
3. Adicionar trait `IsPlaceholderPage`, view `em-breve.blade.php` e as 6 páginas placeholder.
4. Rodar `php artisan filament:cache-components` e validar rotas.

Rollback: reverter o `AdminPanelProvider` para o estado anterior e excluir as páginas placeholder; o domínio clínico não é afetado.

## Open Questions

- Logo SVG oficial do ProjetoGestar para `->brandLogo(...)`?
- Confirmar se cada placeholder deve linkar para o issue/change OpenSpec correspondente diretamente.
