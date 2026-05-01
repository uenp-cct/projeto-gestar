## ADDED Requirements

### Requirement: Admin shell shows ProjetoGestar identity
The system SHALL render the Filament admin panel with the ProjetoGestar brand name and a sky blue primary color.

#### Scenario: Authenticated user opens the panel
- **WHEN** an authenticated user opens any page under `/admin`
- **THEN** the page header displays "ProjetoGestar" and primary actions use the sky blue palette

### Requirement: Admin navigation is grouped by Atendimento, Gestão and Sistema
The system SHALL organize navigation items into the groups Atendimento, Gestão and Sistema.

#### Scenario: Inspect navigation groups
- **WHEN** an authenticated user opens the admin panel
- **THEN** the sidebar shows Atendimentos and Pacientes under Atendimento, Agenda under Atendimento, Relatórios, Cadastros, Protocolos and Indicadores under Gestão, and Configurações under Sistema

### Requirement: Pacientes label replaces Gestantes in navigation
The system SHALL display the gestante resource as "Pacientes" in the navigation while keeping the underlying model and table unchanged.

#### Scenario: Open the Pacientes resource
- **WHEN** an authenticated user clicks "Pacientes" in the sidebar
- **THEN** the system opens the existing gestante list with "Pacientes" as the page title

### Requirement: Admin panel shows placeholder pages for future modules
The system SHALL provide placeholder pages for Agenda, Relatórios, Cadastros, Protocolos, Indicadores and Configurações.

#### Scenario: Open a placeholder page
- **WHEN** an authenticated user opens any of the placeholder pages
- **THEN** the system displays a "Em breve" panel with the module name, a short description, and a list of planned features
