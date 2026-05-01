## ADDED Requirements

### Requirement: Atendimento records are linked to gestantes
The system SHALL allow each `Gestante` to have multiple dated `Atendimento` records.

#### Scenario: Create first atendimento for a gestante
- **WHEN** an authenticated user creates an atendimento for an existing gestante
- **THEN** the system stores the atendimento linked to that gestante with date, responsible user when available, and clinical sections from the form

#### Scenario: View atendimento history
- **WHEN** an authenticated user opens a gestante's atendimento page
- **THEN** the system displays existing atendimentos for that gestante in chronological or reverse chronological order

### Requirement: Atendimento page is organized by clinical sections
The system SHALL provide a Página de Atendimento organized into sections matching the approved prototypes.

#### Scenario: Open atendimento page
- **WHEN** an authenticated user opens the Página de Atendimento
- **THEN** the system displays sections for identificação e histórico, antecedentes, hábitos de vida, situação atual, estratificação de risco, vacinas, exames lab e imagens, exame físico, dados do parto e RN, anotações do gestor, and gráfico

### Requirement: Patient identification and history are available during atendimento
The system SHALL show the selected gestante's identification and stable history while creating or editing an atendimento.

#### Scenario: Select gestante for atendimento
- **WHEN** an authenticated user selects a gestante by name or SUS identifier
- **THEN** the system shows the gestante's name, SUS identifier when available, gestor, médico, personal history, family history, gynecological history, obstetric history, habits, and current situation data that exist in the record

### Requirement: Risk stratification is captured per atendimento
The system SHALL capture risk stratification for each atendimento as one of habitual, intermediário, or alto risco.

#### Scenario: Save risk stratification
- **WHEN** an authenticated user selects a risk level and saves the atendimento
- **THEN** the system persists the selected risk level with the atendimento

### Requirement: Vaccines and exam checklists are captured per atendimento
The system SHALL capture vaccine status and exam checklist information for each atendimento.

#### Scenario: Save vaccines and exams
- **WHEN** an authenticated user marks vaccine items, exam trimester checklist items, and reference/result notes
- **THEN** the system persists the selected checklist values and notes with the atendimento

### Requirement: Physical exam measurements are captured per atendimento
The system SHALL capture physical exam measurements and observations for each atendimento.

#### Scenario: Save physical exam
- **WHEN** an authenticated user enters PA, AU, edema, and physical exam observations
- **THEN** the system persists those values with the atendimento

### Requirement: Birth and newborn data are captured when applicable
The system SHALL allow birth and newborn data to be recorded from the atendimento page when applicable.

#### Scenario: Save parto and RN data
- **WHEN** an authenticated user enters birth date, birth type, RN sex, weight, Apgar scores, location, and observations
- **THEN** the system persists those values in the atendimento clinical record

### Requirement: Gestor notes and care plan are captured per atendimento
The system SHALL capture gestor notes for consultation, home visit, educational actions, and care plan.

#### Scenario: Save gestor notes
- **WHEN** an authenticated user enters gestor annotations and saves the atendimento
- **THEN** the system persists consultation notes, home visit notes, educational actions, and care plan notes with the atendimento

### Requirement: Blood pressure chart uses atendimento history
The system SHALL display a chart of systolic and diastolic blood pressure using the selected gestante's atendimento history.

#### Scenario: Display pressure chart
- **WHEN** a gestante has atendimentos with PA values
- **THEN** the system plots systolic and diastolic values by atendimento date

#### Scenario: Empty pressure chart
- **WHEN** a gestante has no atendimentos with PA values
- **THEN** the system displays an empty-state message instead of failing or showing misleading data
