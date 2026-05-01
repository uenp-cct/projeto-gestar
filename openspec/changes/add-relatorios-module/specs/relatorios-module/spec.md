## ADDED Requirements

### Requirement: Generate consolidated prenatal reports
The system SHALL allow authenticated users to generate consolidated prenatal reports filtered by unidade, period and risk.

#### Scenario: Generate coverage report
- **WHEN** an authenticated user selects "Cobertura de consultas" with a period
- **THEN** the system displays the consolidated coverage values for that period

### Requirement: Export reports to PDF and CSV
The system SHALL allow exporting any generated report as PDF or CSV.

#### Scenario: Export coverage report as PDF
- **WHEN** an authenticated user clicks "Exportar PDF" on a generated report
- **THEN** the system downloads a PDF file with the same data shown on screen
