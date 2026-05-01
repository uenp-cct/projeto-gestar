## Context

Os protocolos guiam a conduta no pré-natal. Hoje só existem como conceito no formulário de atendimento.

## Goals / Non-Goals

**Goals:**
- Manter biblioteca de protocolos clínicos editáveis.
- Versionar mudanças sem perder histórico de qual versão guiou cada atendimento.
- Sugerir checklists baseados em risco e trimestre.

**Non-Goals:**
- Editor visual do tipo Notion nesta entrega; Markdown é suficiente.
- Aprovação multi-papel (workflow de revisão clínica).

## Decisions

### Markdown como formato
Protocolos como Markdown permitem inclusão de listas e tabelas sem editor complexo. Usar Filament Markdown editor.

### Versionamento por publicação
Cada `Protocolo` tem várias `versoes`. Apenas uma versão por protocolo é "publicada" e usada nos atendimentos.

## Risks / Trade-offs

- Mudança em protocolo publicado pode confundir histórico -> sempre criar nova versão.

## Migration Plan

1. Migrations e models.
2. Resource Filament.
3. Substituir placeholder.
4. Sugerir checklists no `AtendimentoResource`.

## Open Questions

- Quem pode publicar uma nova versão?
- Protocolos podem ser regionais?
