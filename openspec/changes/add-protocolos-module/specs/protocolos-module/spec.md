## ADDED Requirements

### Requirement: Maintain a library of clinical protocols
The system SHALL allow authorized users to create and edit clinical protocols associated with risk levels and trimesters.

#### Scenario: Create new protocol
- **WHEN** an authorized user creates a protocol with risk level, trimester and Markdown content
- **THEN** the system stores the protocol and an initial draft version

### Requirement: Version protocols on publish
The system SHALL keep historical versions when a protocol is republished.

#### Scenario: Publish a new version
- **WHEN** an authorized user publishes a new version of an existing protocol
- **THEN** the system marks the new version as published and keeps the previous version as historical

### Requirement: Suggest checklists in atendimento
The system SHALL suggest checklist items in the atendimento form based on the gestante's risk and gestational trimester.

#### Scenario: Open atendimento for habitual risk in second trimester
- **WHEN** an authenticated user opens an atendimento for a habitual risk gestante in the second trimester
- **THEN** the system pre-selects checklist items defined by the published protocol for that combination
