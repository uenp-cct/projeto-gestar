## ADDED Requirements

### Requirement: CRUD of unidades de saúde
The system SHALL allow authorized users to create, edit and remove unidades de saúde.

#### Scenario: Register unidade
- **WHEN** an authorized user submits an unidade with name and identifier
- **THEN** the system stores it and makes it available for selection across the system

### Requirement: CRUD of catálogos clínicos
The system SHALL allow authorized users to maintain catálogos de vacinas, exames and listas clínicas.

#### Scenario: Add new vacina to catálogo
- **WHEN** an authorized user adds a new vacina entry
- **THEN** the system stores it and the new option appears in atendimento forms

### Requirement: Atendimento forms validate against catálogo
The system SHALL validate selections in atendimento forms against the active catálogo entries.

#### Scenario: Save atendimento with valid catálogo values
- **WHEN** an authenticated user saves an atendimento with values present in the catálogo
- **THEN** the system persists the atendimento successfully
