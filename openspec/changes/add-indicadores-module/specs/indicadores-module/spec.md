## ADDED Requirements

### Requirement: Live KPI dashboard for prenatal care
The system SHALL provide a live dashboard with KPIs for prenatal care.

#### Scenario: Open Indicadores dashboard
- **WHEN** an authenticated user opens the Indicadores page
- **THEN** the system shows KPIs for cobertura de consultas, cobertura vacinal, exames realizados, distribuição de risco, and intercorrências

### Requirement: Filter dashboard by unidade and period
The system SHALL allow filtering the dashboard by unidade and period.

#### Scenario: Filter by unidade
- **WHEN** an authenticated user selects a specific unidade
- **THEN** the system updates KPIs and charts to use only data from that unidade
