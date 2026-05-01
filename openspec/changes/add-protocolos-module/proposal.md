## Why

A equipe assistencial precisa de protocolos clínicos versionados para guiar atendimentos por estratificação de risco e por trimestre. Sem protocolos no sistema, condutas dependem de memória e treinamento informal.

## What Changes

- Criar o módulo Protocolos com biblioteca versionada de protocolos clínicos.
- Vincular protocolos a níveis de risco (habitual, intermediário, alto) e a trimestres.
- Disponibilizar checklists por trimestre que aparecem no atendimento.
- Suportar versionamento e publicação de novas versões.

## Capabilities

### New Capabilities
- `protocolos-module`: Biblioteca de protocolos clínicos com versionamento e checklists associados.

## Impact

- Banco: tabelas `protocolos`, `protocolo_versoes`, `protocolo_itens`.
- Filament: Resource e visualização rica em Markdown.
- Atendimento: passa a sugerir checklists do protocolo da gestante.
