# Consultation Module - Requirements Document

## Introduction

The Consultation Module is the core clinical documentation system that allows doctors to record patient encounters, document clinical findings, create treatment plans, and generate prescriptions. This module serves as the central hub for all clinical activities, whether conducted in-person or via telemedicine.

## Glossary

- **Consultation**: A clinical encounter between a doctor and patient where medical assessment and treatment occur
- **SOAP Notes**: Structured clinical documentation format (Subjective, Objective, Assessment, Plan)
- **Chief Complaint**: The primary reason the patient is seeking medical care
- **HPI**: History of Present Illness - detailed narrative of the patient's current medical issue
- **ROS**: Review of Systems - systematic review of body systems
- **Physical Examination**: Clinical findings from examining the patient
- **Assessment**: Doctor's clinical judgment and diagnosis
- **ICD-10**: International Classification of Diseases, 10th Revision - standardized diagnosis codes
- **Prescription**: Written order for medication
- **Sig**: Prescription directions (dosage instructions)
- **Follow-up**: Scheduled return visit or monitoring plan

## Requirements

### Requirement 1: Start Consultation

**User Story:** As a doctor, I want to start a consultation session from the patient overview page, so that I can begin documenting the clinical encounter.

#### Acceptance Criteria

1. WHEN a doctor clicks "Start Consult" button on patient overview page THEN the system SHALL open the consultation interface
2. WHEN a consultation is started THEN the system SHALL create a new consultation record linked to the patient and doctor
3. WHEN a consultation is started THEN the system SHALL display patient demographics and EMR summary in the sidebar
4. WHEN a consultation is started THEN the system SHALL auto-populate the consultation date and time
5. WHEN a consultation is already in progress for a patient THEN the system SHALL resume the existing consultation instead of creating a new one

### Requirement 2: Chief Complaint and History

**User Story:** As a doctor, I want to document the patient's chief complaint and history of present illness, so that I can record why the patient is seeking care.

#### Acceptance Criteria

1. WHEN documenting a consultation THEN the system SHALL provide a field for chief complaint
2. WHEN documenting a consultation THEN the system SHALL provide a rich text editor for history of present illness
3. WHEN the doctor enters chief complaint THEN the system SHALL auto-save the data every 30 seconds
4. WHEN the doctor enters HPI THEN the system SHALL support formatting (bold, italic, lists)
5. WHEN the doctor needs to reference past consultations THEN the system SHALL display consultation history in the sidebar

### Requirement 3: Vital Signs During Consultation

**User Story:** As a doctor, I want to record vital signs during the consultation, so that I can document the patient's current physiological status.

#### Acceptance Criteria

1. WHEN recording vitals during consultation THEN the system SHALL provide quick-entry fields for all vital signs
2. WHEN vitals are entered THEN the system SHALL validate ranges (e.g., BP 0-300, HR 0-250)
3. WHEN vitals are saved THEN the system SHALL link them to the current consultation
4. WHEN vitals are saved THEN the system SHALL update the patient's vital signs history
5. WHEN viewing vitals THEN the system SHALL highlight abnormal values in red

### Requirement 4: Physical Examination

**User Story:** As a doctor, I want to document physical examination findings, so that I can record objective clinical observations.

#### Acceptance Criteria

1. WHEN documenting physical exam THEN the system SHALL provide a structured template organized by body systems
2. WHEN documenting physical exam THEN the system SHALL include sections for: General, HEENT, Cardiovascular, Respiratory, Abdomen, Neurological, Musculoskeletal, Skin
3. WHEN documenting physical exam THEN the system SHALL support free-text entry for each system
4. WHEN documenting physical exam THEN the system SHALL provide common normal findings as quick-select options
5. WHEN physical exam is documented THEN the system SHALL auto-save every 30 seconds

### Requirement 5: Assessment and Diagnosis

**User Story:** As a doctor, I want to document my clinical assessment and diagnoses, so that I can record my medical judgment.

#### Acceptance Criteria

1. WHEN documenting assessment THEN the system SHALL provide a field for clinical impression
2. WHEN adding diagnoses THEN the system SHALL provide searchable ICD-10 code lookup
3. WHEN adding diagnoses THEN the system SHALL support multiple diagnoses with primary/secondary designation
4. WHEN a diagnosis is added THEN the system SHALL offer to add it to patient's condition list
5. WHEN diagnoses are saved THEN the system SHALL store both the diagnosis name and ICD-10 code

### Requirement 6: Treatment Plan

**User Story:** As a doctor, I want to document the treatment plan, so that I can record the course of action for the patient's care.

#### Acceptance Criteria

1. WHEN documenting treatment plan THEN the system SHALL provide a rich text editor
2. WHEN documenting treatment plan THEN the system SHALL support structured sections (medications, procedures, lifestyle modifications, follow-up)
3. WHEN documenting treatment plan THEN the system SHALL auto-save every 30 seconds
4. WHEN treatment plan includes medications THEN the system SHALL provide a link to create prescriptions
5. WHEN treatment plan includes follow-up THEN the system SHALL provide a link to schedule next appointment

### Requirement 7: Prescriptions

**User Story:** As a doctor, I want to create prescriptions during consultation, so that I can provide medication orders to the patient.

#### Acceptance Criteria

1. WHEN creating a prescription THEN the system SHALL provide searchable medication lookup
2. WHEN creating a prescription THEN the system SHALL require: medication name, strength, dosage form, quantity, directions (sig)
3. WHEN creating a prescription THEN the system SHALL support common sig templates (e.g., "Take 1 tablet by mouth twice daily")
4. WHEN creating a prescription THEN the system SHALL check for drug allergies and display warnings
5. WHEN creating a prescription THEN the system SHALL check for drug interactions with current medications
6. WHEN a prescription is saved THEN the system SHALL add it to the patient's medication list
7. WHEN prescriptions are created THEN the system SHALL generate a printable prescription document
8. WHEN prescriptions are created THEN the system SHALL include doctor's license number and signature

### Requirement 8: Lab Orders and Investigations

**User Story:** As a doctor, I want to order laboratory tests and investigations, so that I can request diagnostic workup.

#### Acceptance Criteria

1. WHEN ordering labs THEN the system SHALL provide searchable test lookup (CBC, BMP, Lipid Panel, etc.)
2. WHEN ordering labs THEN the system SHALL support multiple tests in a single order
3. WHEN ordering labs THEN the system SHALL include clinical indication/reason for test
4. WHEN ordering imaging THEN the system SHALL support common imaging types (X-ray, CT, MRI, Ultrasound)
5. WHEN orders are created THEN the system SHALL generate a printable lab requisition form
6. WHEN orders are created THEN the system SHALL mark them as "pending" in the patient's record

### Requirement 9: Referrals

**User Story:** As a doctor, I want to create referrals to specialists, so that I can coordinate care with other providers.

#### Acceptance Criteria

1. WHEN creating a referral THEN the system SHALL provide specialty selection (Cardiology, Orthopedics, etc.)
2. WHEN creating a referral THEN the system SHALL require reason for referral
3. WHEN creating a referral THEN the system SHALL include relevant clinical information
4. WHEN creating a referral THEN the system SHALL support urgency levels (routine, urgent, emergent)
5. WHEN a referral is created THEN the system SHALL generate a printable referral letter

### Requirement 10: Medical Certificates and Documents

**User Story:** As a doctor, I want to generate medical certificates and sick notes, so that I can provide documentation for patients.

#### Acceptance Criteria

1. WHEN generating a sick note THEN the system SHALL include patient name, dates of illness, and fitness to work/study
2. WHEN generating a medical certificate THEN the system SHALL include diagnosis and recommendations
3. WHEN generating documents THEN the system SHALL include doctor's name, license number, and signature
4. WHEN documents are generated THEN the system SHALL save a copy to the patient's record
5. WHEN documents are generated THEN the system SHALL provide PDF download option

### Requirement 11: Quick Actions and Shortcuts

**User Story:** As a doctor, I want quick access to common actions during consultation, so that I can efficiently update the patient's record.

#### Acceptance Criteria

1. WHEN in consultation mode THEN the system SHALL provide quick-add buttons for: conditions, medications, allergies, vitals
2. WHEN quick-adding items THEN the system SHALL open modal overlays without leaving the consultation
3. WHEN items are added via quick actions THEN the system SHALL immediately update the EMR sidebar
4. WHEN items are added via quick actions THEN the system SHALL use Livewire for real-time updates
5. WHEN quick actions are used THEN the system SHALL maintain the doctor's position in the consultation form

### Requirement 12: Save and Complete Consultation

**User Story:** As a doctor, I want to save and complete the consultation, so that I can finalize the clinical documentation.

#### Acceptance Criteria

1. WHEN saving a consultation THEN the system SHALL validate that required fields are completed (chief complaint, assessment)
2. WHEN saving as draft THEN the system SHALL allow incomplete consultations to be resumed later
3. WHEN completing a consultation THEN the system SHALL mark it as "finalized" and prevent further edits
4. WHEN completing a consultation THEN the system SHALL update the patient's last visit date
5. WHEN completing a consultation THEN the system SHALL generate a consultation summary PDF
6. WHEN completing a consultation THEN the system SHALL return the doctor to the patient overview page

### Requirement 13: Consultation History and Review

**User Story:** As a doctor, I want to view past consultations, so that I can review the patient's clinical history.

#### Acceptance Criteria

1. WHEN viewing consultation history THEN the system SHALL display consultations in reverse chronological order
2. WHEN viewing consultation history THEN the system SHALL show: date, chief complaint, diagnoses, and doctor name
3. WHEN viewing a past consultation THEN the system SHALL display it in read-only mode
4. WHEN viewing a past consultation THEN the system SHALL show all SOAP notes, prescriptions, and orders
5. WHEN viewing consultation history THEN the system SHALL support filtering by date range and doctor

### Requirement 14: Templates and Macros

**User Story:** As a doctor, I want to use templates for common consultation types, so that I can document efficiently.

#### Acceptance Criteria

1. WHEN starting a consultation THEN the system SHALL offer common templates (Annual Physical, Follow-up, Acute Illness)
2. WHEN selecting a template THEN the system SHALL pre-populate relevant sections with standard text
3. WHEN using templates THEN the system SHALL allow customization of pre-filled content
4. WHEN documenting THEN the system SHALL support text macros/shortcuts (e.g., ".bp" expands to "Blood pressure:")
5. WHEN doctors create custom templates THEN the system SHALL save them for future use

### Requirement 15: Billing and Coding

**User Story:** As a doctor, I want to assign billing codes to the consultation, so that the visit can be properly billed.

#### Acceptance Criteria

1. WHEN completing a consultation THEN the system SHALL provide CPT code selection for the visit type
2. WHEN selecting CPT codes THEN the system SHALL suggest codes based on consultation complexity
3. WHEN billing codes are assigned THEN the system SHALL store them with the consultation record
4. WHEN billing codes are assigned THEN the system SHALL calculate the consultation fee
5. WHEN consultation is completed THEN the system SHALL mark it as "ready for billing"

## Technical Considerations

### Database Structure
- `consultations` table (main consultation record)
- `consultation_vitals` table (vitals taken during consultation)
- `consultation_diagnoses` table (diagnoses with ICD-10 codes)
- `prescriptions` table (medication orders)
- `lab_orders` table (laboratory and imaging orders)
- `referrals` table (specialist referrals)
- `medical_certificates` table (generated documents)

### User Interface
- Split-screen layout: consultation form on left, patient EMR summary on right
- Auto-save functionality every 30 seconds
- Livewire components for real-time updates
- Modal overlays for quick actions
- Rich text editors for narrative sections
- Searchable dropdowns for medications, diagnoses, tests

### Integration Points
- Link to existing EMR data (conditions, medications, allergies, vitals)
- Update patient's medication list when prescriptions are created
- Update patient's condition list when diagnoses are added
- Link to appointment system for follow-up scheduling
- Generate PDF documents for prescriptions, certificates, and summaries

### Security and Compliance
- Audit logging for all consultation actions
- Doctor authentication and authorization
- Encrypted storage of clinical notes
- Digital signature for prescriptions and certificates
- HIPAA compliance for data handling

## Success Metrics

1. Average consultation documentation time < 10 minutes
2. 100% of consultations have chief complaint and assessment documented
3. 95% of prescriptions include drug allergy checks
4. Auto-save prevents data loss in 100% of cases
5. Consultation summary PDFs generated within 5 seconds
