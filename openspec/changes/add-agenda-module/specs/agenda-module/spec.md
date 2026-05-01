## ADDED Requirements

### Requirement: Schedule consultations and home visits
The system SHALL allow authenticated users to schedule consultations and home visits for a gestante.

#### Scenario: Create a new agendamento
- **WHEN** an authenticated user creates an agendamento with gestante, date, time and type
- **THEN** the system stores the agendamento with status "agendada"

### Requirement: Track agendamento status transitions
The system SHALL support agendamento status transitions among agendada, confirmada, realizada, faltou, and cancelada.

#### Scenario: Mark agendamento as realizada
- **WHEN** an authenticated user marks an agendamento as realizada and links it to an atendimento
- **THEN** the system updates the status and stores the link to the atendimento

### Requirement: Calendar view for agendamentos
The system SHALL display agendamentos in a weekly and monthly calendar view filtered by professional or gestante.

#### Scenario: Open weekly calendar
- **WHEN** an authenticated user opens the weekly calendar
- **THEN** the system displays agendamentos of the selected week with status indicators
