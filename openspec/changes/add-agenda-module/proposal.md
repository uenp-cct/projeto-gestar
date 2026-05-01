## Why

Hoje os atendimentos são registrados sem agendamento prévio. A equipe precisa de uma agenda para programar consultas e visitas, ver a semana por profissional e enviar lembretes às gestantes, evitando faltas e melhorando a adesão ao pré-natal.

## What Changes

- Criar o módulo Agenda com agendamento de consultas e visitas domiciliares por gestante e profissional.
- Persistir agendamentos como entidade própria, com data, horário, tipo, status e profissional.
- Conectar agendamentos ao registro de `Atendimento` quando a consulta é realizada.
- Disponibilizar visualização em calendário (semana e mês) e lista de pendências.
- Suportar status: agendada, confirmada, realizada, faltou, cancelada.

## Capabilities

### New Capabilities
- `agenda-module`: Agendamento de consultas e visitas, com calendário, status de comparecimento e ligação com atendimentos.

## Impact

- Banco: tabela `agendamentos` (gestante_id, user_id, data, hora, tipo, status, observacoes, atendimento_id nullable).
- Backend: model `Agendamento`, relacionamentos e regras de transição de status.
- Filament: substituir a página placeholder `Agenda` por um Resource/Calendar real.
- UX: notificações e lembretes para gestantes (canal a definir em design).
