## Why

O Projeto Gestar precisa evoluir de um cadastro clínico estático para uma página de atendimento capaz de registrar consultas, visitas e acompanhamento longitudinal da gestante. Os protótipos consolidam em uma única experiência dados de identificação, histórico, risco, vacinas, exames, exame físico, parto/RN, anotações do gestor e gráfico, reduzindo dispersão de informações e preparando o sistema para uso em rotina assistencial.

## What Changes

- Introduzir a Página de Atendimento para registrar e consultar atendimentos vinculados a uma gestante.
- Criar o conceito de `Atendimento` como registro datado, vinculado a `Gestante` e opcionalmente ao profissional/gestor responsável.
- Persistir os blocos clínicos dos protótipos: estratificação de risco, vacinas, exames laboratoriais e imagens, exame físico, dados do parto/RN e anotações do gestor.
- Exibir um gráfico inicial de evolução clínica, começando por pressão arterial sistólica e diastólica ao longo dos atendimentos.
- Alinhar a interface administrativa em Filament com o modelo persistente, corrigindo a lacuna atual em que campos clínicos aparecem no formulário sem existir no banco/modelo.
- Manter o escopo visual como aproximação funcional dos protótipos, sem exigir implementação pixel-perfect.

## Capabilities

### New Capabilities
- `atendimento-page`: Fluxo de atendimento longitudinal da gestante, incluindo formulário por seções, persistência clínica, histórico de registros e gráfico de evolução.

### Modified Capabilities
- Nenhuma capacidade existente com spec estruturada será modificada por delta; a visão geral em `openspec/specs/system.md` será atualizada diretamente para refletir a nova entidade.

## Impact

- Banco de dados: novas migrations para `atendimentos` e, se necessário, colunas/estruturas auxiliares para dados clínicos normalizados ou JSON.
- Backend Laravel: novo model `Atendimento`, relacionamentos com `Gestante` e possivelmente `User`, regras de validação e factories/testes.
- Filament: nova página/resource para o atendimento, organização por seções conforme os protótipos, busca/seleção de paciente e visualização de histórico.
- Gráficos: widget ou componente Filament para evolução de PA por atendimento.
- Documentação OpenSpec: atualização de `openspec/specs/system.md` e criação da spec de capacidade `atendimento-page`.
