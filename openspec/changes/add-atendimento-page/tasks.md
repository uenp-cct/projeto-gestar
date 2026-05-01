## 1. Data Model

- [ ] 1.1 Create `Atendimento` model, migration, and factory.
- [ ] 1.2 Add `gestante_id`, optional `user_id`, `data_atendimento`, `tipo_atendimento`, `estratificacao_risco`, physical exam fields, parto/RN fields, notes fields, and JSON clinical groups to the `atendimentos` table.
- [ ] 1.3 Add casts for dates, booleans, numeric measurements, and JSON groups in `Atendimento`.
- [ ] 1.4 Add `Gestante hasMany Atendimento` and `Atendimento belongsTo Gestante` relationships.
- [ ] 1.5 Add or confirm a SUS identifier field on `Gestante` if patient search requires it.

## 2. Filament Atendimento Flow

- [ ] 2.1 Create a Filament resource or custom page for Página de Atendimento.
- [ ] 2.2 Add patient search/selection by gestante name and SUS identifier when available.
- [ ] 2.3 Show read-only identification and stable history context from the selected gestante.
- [ ] 2.4 Build form sections for antecedentes, hábitos de vida, situação atual, estratificação de risco, vacinas, exames lab e imagens, exame físico, dados do parto e RN, and anotações do gestor.
- [ ] 2.5 Save all editable form sections into the selected atendimento record.
- [ ] 2.6 Add create, edit, and history/list access for atendimentos linked to a gestante.

## 3. Existing Gestante Resource Alignment

- [ ] 3.1 Review `GestanteResource` fields that currently reference non-persisted clinical columns.
- [ ] 3.2 Move atendimento-specific fields out of `GestanteResource` or back them with real persistence through `Atendimento`.
- [ ] 3.3 Expose risk and current pregnancy context consistently between `Gestante` and `Atendimento` without duplicating conflicting data.

## 4. Chart and Clinical History

- [ ] 4.1 Add a Filament chart/widget or page component for PA evolution.
- [ ] 4.2 Query the selected gestante's atendimentos ordered by `data_atendimento`.
- [ ] 4.3 Plot systolic and diastolic pressure values by atendimento date.
- [ ] 4.4 Show an empty state when no PA data exists.

## 5. Validation and Tests

- [ ] 5.1 Add validation rules for required atendimento fields and accepted risk values.
- [ ] 5.2 Add tests for creating an atendimento linked to a gestante.
- [ ] 5.3 Add tests for editing atendimento clinical sections.
- [ ] 5.4 Add tests or assertions for PA chart data generation.
- [ ] 5.5 Run migrations and the relevant test suite.

## 6. Documentation and Review

- [ ] 6.1 Update user-facing labels in pt-BR to match the prototypes.
- [ ] 6.2 Confirm the OpenSpec change validates with `openspec status --change add-atendimento-page`.
- [ ] 6.3 Review the final UI against the two prototype images for section coverage.
