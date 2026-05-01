## Context

O projeto atual usa Laravel 12 com Filament v3 e possui a entidade `Gestante` como centro do domínio. A migration de `gestantes` contém dados cadastrais, antecedentes, hábitos e gestação atual, enquanto `GestanteResource` já apresenta alguns campos de vacinas, exames, parto/RN e plano de cuidado que não existem na migration nem no `$fillable`.

Os protótipos descrevem uma Página de Atendimento única, com navegação administrativa, busca de paciente, blocos clínicos por seção e gráfico de evolução. Essa tela precisa representar uma consulta/visita específica sem perder o histórico da gestante.

## Goals / Non-Goals

**Goals:**
- Registrar múltiplos atendimentos por gestante, com data, profissional/gestor e dados clínicos.
- Organizar a tela em seções equivalentes aos protótipos: identificação, antecedentes, hábitos de vida, situação atual, risco, vacinas, exames, exame físico, parto/RN, anotações do gestor e gráfico.
- Persistir todos os campos editáveis exibidos na tela.
- Exibir histórico suficiente para alimentar o gráfico inicial de pressão arterial.
- Usar Laravel/Filament como base principal da implementação.

**Non-Goals:**
- Implementar layout pixel-perfect dos protótipos.
- Substituir todo o fluxo administrativo existente de `GestanteResource`.
- Criar integração externa com sistemas do SUS, laboratórios ou prontuário eletrônico.
- Implementar regras clínicas automáticas de estratificação de risco nesta primeira entrega.

## Decisions

### `Atendimento` será entidade própria

Criar `Atendimento` vinculado a `Gestante` permite registrar uma linha do tempo de consultas e visitas. Guardar todos os campos diretamente em `Gestante` simplificaria a primeira tela, mas perderia histórico, dificultaria auditoria e impediria gráficos por evolução.

Alternativa considerada: estender `gestantes` com todos os campos dos protótipos. Rejeitada por misturar dados estáveis da paciente com eventos clínicos datados.

### Dados clínicos serão agrupados por colunas objetivas e campos JSON

Campos usados em filtros, gráficos ou validações básicas devem ser colunas explícitas: `gestante_id`, `user_id`, `data_atendimento`, `tipo_atendimento`, `estratificacao_risco`, `pa_sistolica`, `pa_diastolica`, `altura_uterina`, `edema`, `data_parto`, `tipo_parto`, `peso_rn`, `apgar_1`, `apgar_5`.

Checklists e grupos variáveis podem começar como JSON: `vacinas`, `exames`, `habitos_vida`, `anotacoes_gestor`, `dados_parto_rn`. Isso reduz churn de migration durante a consolidação do formulário, sem impedir normalização futura.

Alternativa considerada: criar tabelas separadas para vacinas, exames e anotações desde o início. Rejeitada nesta etapa por aumentar a complexidade antes de estabilizar os campos reais usados pela equipe.

### Filament será a superfície inicial da Página de Atendimento

A tela deve ser implementada em Filament, como custom page/resource relacionado a `Gestante`, aproveitando autenticação, layout administrativo e componentes de formulário existentes.

Alternativa considerada: criar Blade/Vue separado. Rejeitada porque o projeto já usa Filament para a área operacional e não há necessidade imediata de um frontend paralelo.

### Gráfico inicial será de pressão arterial

O gráfico deve usar os registros de `Atendimento` da gestante para exibir PA sistólica e diastólica por data. O protótipo mostra esse eixo de valor clínico e ele depende de campos simples de persistir e consultar.

Alternativa considerada: criar painel de múltiplos indicadores logo na primeira entrega. Rejeitada para manter o escopo testável.

## Risks / Trade-offs

- Campos JSON podem dificultar relatórios avançados depois -> manter colunas explícitas para dados que já sabemos que serão filtrados ou usados em gráficos.
- Duplicidade com campos atuais em `GestanteResource` -> migrar ou remover os campos clínicos não persistidos do resource antigo quando a página de atendimento assumir essa função.
- Filament pode exigir customização visual para aproximar o layout dos protótipos -> priorizar funcionalidade e organização por seções antes de refinamento visual.
- Dados antigos podem existir sem atendimentos -> a tela deve permitir criar o primeiro atendimento a partir de uma gestante existente.

## Migration Plan

1. Criar migration e model `Atendimento` com relacionamentos `Gestante hasMany Atendimento` e `Atendimento belongsTo Gestante`.
2. Adicionar casts no model para grupos JSON e datas.
3. Implementar a tela/resource de atendimento em Filament.
4. Revisar `GestanteResource` para expor identificação/histórico e remover ou realocar campos clínicos não persistidos.
5. Adicionar gráfico de PA baseado nos atendimentos da gestante.
6. Cobrir criação/edição/listagem básica com testes de model, relacionamento e persistência.

Rollback: remover a página/resource de atendimento e reverter a migration de `atendimentos`, preservando a tabela `gestantes`.

## Open Questions

- A identificação por SUS precisa ser coluna obrigatória em `Gestante` ou será adicionada junto da tela?
- O papel "Gestor" será o próprio `User` autenticado ou uma entidade/profissional separada?
- Quais exames do checklist inicial são obrigatórios para a primeira versão?
