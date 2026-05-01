## ADDED Requirements

### Requirement: Maintain unidade profile and parameters
The system SHALL allow administrators to maintain unidade profile data and general parameters.

#### Scenario: Update unidade profile
- **WHEN** an administrator updates the unidade name and contact info
- **THEN** the system stores the new values and reflects them across the panel

### Requirement: Manage roles and permissions
The system SHALL support role-based permissions, with at least administrador, gestor and profissional roles.

#### Scenario: Assign role to user
- **WHEN** an administrator assigns the gestor role to a user
- **THEN** the system enforces gestor-level permissions for that user across the application

### Requirement: Audit sensitive actions
The system SHALL record audit logs for sensitive actions such as role changes and gestante deletion.

#### Scenario: Delete gestante
- **WHEN** an authorized user deletes a gestante
- **THEN** the system stores an audit entry with user, timestamp and the gestante identifier
