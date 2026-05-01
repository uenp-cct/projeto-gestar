## 1. Banco e domínio

- [ ] 1.1 Criar migration `create_agendamentos_table`.
- [ ] 1.2 Criar model `Agendamento` com relacionamentos para `Gestante`, `User` e `Atendimento`.
- [ ] 1.3 Criar factory para `Agendamento`.

## 2. Filament

- [ ] 2.1 Criar `AgendamentoResource` com formulário e tabela.
- [ ] 2.2 Criar página de calendário semanal/mensal.
- [ ] 2.3 Substituir o placeholder `Agenda` por links reais.

## 3. Integrações com Atendimento

- [ ] 3.1 Permitir abrir um atendimento a partir de um agendamento.
- [ ] 3.2 Atualizar status para realizada quando o atendimento for salvo.

## 4. Testes

- [ ] 4.1 Cobrir criação, transição de status e link para atendimento.
- [ ] 4.2 Validar `openspec validate add-agenda-module`.
