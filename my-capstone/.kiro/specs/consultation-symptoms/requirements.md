# Consultation Module - Symptoms Sub-Module Requirements

## Introduction

The Symptoms Sub-Module is the first component of the Consultation Module. It allows doctors to document the patient's presenting complaints and symptoms during a clinical encounter. This includes the chief complaint, history of present illness (HPI), and review of systems (ROS).

## Glossary

- **Consultation**: A clinical encounter between a doctor and patient
- **Chief Complaint**: The primary reason the patient is seeking medical care (in patient's own words)
- **HPI**: History of Present Illness - detailed narrative of the patient's current medical issue
- **ROS**: Review of Systems - systematic review of body systems to identify additional symptoms
- **OLDCARTS**: Mnemonic for symptom documentation (Onset, Location, Duration, Character, Aggravating factors, Relieving factors, Timing, Severity)
- **Auto-save**: Automatic saving of data at regular intervals to prevent data loss

## Requirements

### Requirement 1: Start Consultation Session

**User Story:** As a doctor, I want to start a consultation session from the patient overview page, so that I can begin documenting the patient encounter.

#### Acceptance Criteria

1. WHEN a doctor clicks "Start Consult" button on patient overview page THEN the system SHALL navigate to the consultation interface
2. WHEN a consultation is started THEN the system SHALL create a new consultation record with status "draft"
3. WHEN a consultation is started THEN the system SHALL link the consultation to the patient and the authenticated doctor
4. WHEN a consultation is started THEN the system SHALL auto-populate the consultation date and time with current timestamp
5. WHEN a consultation is already in draft status for the patient THEN the system SHALL resume the existing consultation instead of creating a new one

### Requirement 2: Common Complaints Selection

**User Story:** As a doctor, I want to select from common complaints specific to adult and pediatric medicine, so that I can quickly document the reason for visit with standardized terminology.

#### Acceptance Criteria

1. WHEN starting symptom documentation THEN the system SHALL display clickable buttons for common complaints organized by category
2. WHEN displaying complaints THEN the system SHALL include adult medicine complaints: Abdominal Pain, Anxiety, Back pain, Chest pain, Cold/Flu, Constipation, Cough, Depression, Diarrhea, Earache, Fatigue, Fever, Headache, Heartburn, Injury, Insomnia, Joint pain, Muscle pain, Nausea/vomiting, Neck pain, Palpitations, Rash, Sore throat, Urinary tract infection, Weight gain, Weight loss
3. WHEN displaying complaints THEN the system SHALL include pediatric-specific complaints: Cough (pediatric), Fever (pediatric), Rash (pediatric), Feeding problems, Developmental concerns, Growth concerns
4. WHEN a complaint button is clicked THEN the system SHALL select it as the chief complaint
5. WHEN no pre-defined complaint matches THEN the system SHALL provide a free-text input field for custom complaints
6. WHEN multiple complaints exist THEN the system SHALL allow selecting multiple complaint buttons
7. WHEN complaints are selected THEN the system SHALL auto-save the selection

### Requirement 3: Visit Type Selection

**User Story:** As a doctor, I want to select the type of visit, so that the system can provide relevant templates and questions.

#### Acceptance Criteria

1. WHEN starting symptom documentation THEN the system SHALL display visit type buttons: COVID-19, Chronic follow-up (Diabetes), Chronic follow-up (Hypertension), General checkup, HIV first visit, HIV follow up, Immunisation, Pregnancy first visit, Pregnancy follow up
2. WHEN a visit type is selected THEN the system SHALL load visit-specific templates and questions
3. WHEN visit type is selected THEN the system SHALL combine with complaint selection to provide customized questions
4. WHEN visit type is not applicable THEN the system SHALL allow proceeding without visit type selection
5. WHEN visit type is selected THEN the system SHALL auto-save the selection

### Requirement 4: Smart Complaint-Based Templates

**User Story:** As a doctor, I want complaint-specific templates with relevant questions to auto-populate, so that I can document efficiently while ensuring completeness.

#### Acceptance Criteria

1. WHEN a complaint is selected (e.g., "Anxiety", "Fever", "Cough") THEN the system SHALL load a complaint-specific template with relevant questions
2. WHEN using a template THEN the system SHALL provide checkboxes and dropdowns for common associated symptoms (e.g., for "Sore throat": fever, cough, difficulty swallowing, runny nose)
3. WHEN template questions are answered THEN the system SHALL auto-populate the symptom notes summary in real-time
4. WHEN auto-populating summary THEN the system SHALL use medical terminology and proper formatting (e.g., "P/C/O: Sore throat, tired.")
5. WHEN the doctor needs to add custom notes THEN the system SHALL allow free-text entry alongside template questions
6. WHEN switching between complaints THEN the system SHALL preserve previously entered data
7. WHEN multiple complaints are selected THEN the system SHALL merge relevant questions from all templates

### Requirement 5: Flexible Documentation Mode

**User Story:** As a doctor, I want the flexibility to either use templates or type free-text notes, so that I can adapt to different consultation styles and complexity.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide both template mode and free-text mode
2. WHEN in template mode THEN the system SHALL display guided questions with checkboxes/dropdowns
3. WHEN in free-text mode THEN the system SHALL provide a rich text editor for manual note entry
4. WHEN switching modes THEN the system SHALL preserve data entered in the previous mode
5. WHEN using both modes THEN the system SHALL combine template-generated text with free-text notes in the final summary

### Requirement 4: Review of Systems (ROS)

**User Story:** As a doctor, I want to perform a systematic review of body systems, so that I can identify additional symptoms the patient may have.

#### Acceptance Criteria

1. WHEN documenting ROS THEN the system SHALL provide checkboxes for common systems: Constitutional, HEENT, Cardiovascular, Respiratory, Gastrointestinal, Genitourinary, Musculoskeletal, Skin, Neurological, Psychiatric, Endocrine, Hematologic, Allergic/Immunologic
2. WHEN a system is checked THEN the system SHALL expand to show common symptoms for that system
3. WHEN symptoms are selected THEN the system SHALL provide a text field for additional details
4. WHEN ROS data is entered THEN the system SHALL auto-save every 30 seconds
5. WHEN all systems are reviewed THEN the system SHALL mark ROS as "Complete"

### Requirement 5: Symptom Duration and Timeline

**User Story:** As a doctor, I want to document when symptoms started and their progression, so that I can understand the timeline of the illness.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide fields for symptom onset (date/time or duration)
2. WHEN documenting symptoms THEN the system SHALL support duration units (hours, days, weeks, months, years)
3. WHEN onset date is entered THEN the system SHALL calculate and display duration automatically
4. WHEN documenting symptoms THEN the system SHALL provide a timeline visualization option
5. WHEN symptom timeline is saved THEN the system SHALL store it with the consultation record

### Requirement 6: Associated Symptoms

**User Story:** As a doctor, I want to document associated symptoms, so that I can capture the complete clinical picture.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide a searchable list of common symptoms
2. WHEN a symptom is selected THEN the system SHALL allow adding severity (mild, moderate, severe)
3. WHEN symptoms are added THEN the system SHALL support multiple symptom selection
4. WHEN symptoms are documented THEN the system SHALL group related symptoms together
5. WHEN associated symptoms are saved THEN the system SHALL link them to the chief complaint

### Requirement 7: Symptom Severity and Impact

**User Story:** As a doctor, I want to document symptom severity and impact on daily activities, so that I can assess the clinical significance.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide a severity scale (1-10 or mild/moderate/severe)
2. WHEN documenting symptoms THEN the system SHALL provide checkboxes for impact on: work, sleep, appetite, mood, daily activities
3. WHEN severity is rated THEN the system SHALL visually indicate the level (color coding)
4. WHEN impact is documented THEN the system SHALL save it with the symptom record
5. WHEN severity changes during consultation THEN the system SHALL allow updating the rating

### Requirement 8: Previous Similar Episodes

**User Story:** As a doctor, I want to know if the patient has experienced similar symptoms before, so that I can identify patterns or recurrent conditions.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide a checkbox for "Previous similar episodes"
2. WHEN previous episodes are indicated THEN the system SHALL provide fields for: frequency, last occurrence, treatment received, outcome
3. WHEN previous episodes are documented THEN the system SHALL search patient history for similar consultations
4. WHEN similar past consultations are found THEN the system SHALL display them in the sidebar
5. WHEN previous episodes are saved THEN the system SHALL link them to the current consultation

### Requirement 9: Aggravating and Relieving Factors

**User Story:** As a doctor, I want to document what makes symptoms better or worse, so that I can understand triggers and effective interventions.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide text fields for aggravating factors
2. WHEN documenting symptoms THEN the system SHALL provide text fields for relieving factors
3. WHEN factors are entered THEN the system SHALL suggest common factors based on the chief complaint
4. WHEN factors are documented THEN the system SHALL auto-save every 30 seconds
5. WHEN factors are saved THEN the system SHALL store them with the symptom record

### Requirement 10: Auto-save and Data Persistence

**User Story:** As a doctor, I want my work to be automatically saved, so that I don't lose data if there's an interruption.

#### Acceptance Criteria

1. WHEN any field is modified THEN the system SHALL trigger auto-save after 30 seconds of inactivity
2. WHEN auto-save is triggered THEN the system SHALL display "Saving..." indicator
3. WHEN auto-save completes THEN the system SHALL display "Saved at [time]" indicator
4. WHEN auto-save fails THEN the system SHALL display error message and retry after 10 seconds
5. WHEN the doctor navigates away THEN the system SHALL save all pending changes before leaving

### Requirement 11: Save Draft and Continue Later

**User Story:** As a doctor, I want to save my work as a draft and continue later, so that I can handle interruptions without losing progress.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide a "Save Draft" button
2. WHEN "Save Draft" is clicked THEN the system SHALL save all data and mark consultation as "draft"
3. WHEN a draft consultation exists THEN the system SHALL display "Resume Consultation" option on patient overview
4. WHEN resuming a draft THEN the system SHALL load all previously entered data
5. WHEN a draft is older than 24 hours THEN the system SHALL display a warning message

### Requirement 12: Patient EMR Sidebar

**User Story:** As a doctor, I want to see the patient's EMR summary while documenting symptoms, so that I have context for the current visit.

#### Acceptance Criteria

1. WHEN in consultation mode THEN the system SHALL display patient EMR summary in a sidebar (30% width)
2. WHEN displaying EMR summary THEN the system SHALL show: demographics, current conditions, current medications, allergies, recent vitals
3. WHEN displaying EMR summary THEN the system SHALL show recent consultation history (last 5 visits)
4. WHEN EMR data is updated THEN the system SHALL refresh the sidebar in real-time using Livewire
5. WHEN sidebar is too long THEN the system SHALL make it scrollable while keeping header fixed

### Requirement 13: Quick Actions from Symptoms

**User Story:** As a doctor, I want quick access to add conditions or medications while documenting symptoms, so that I can efficiently update the patient's record.

#### Acceptance Criteria

1. WHEN documenting symptoms THEN the system SHALL provide quick-add buttons in sidebar: [+ Condition], [+ Medication], [+ Allergy]
2. WHEN quick-add button is clicked THEN the system SHALL open a modal overlay without leaving the consultation
3. WHEN an item is added via quick-add THEN the system SHALL update the EMR sidebar immediately
4. WHEN modal is closed THEN the system SHALL return focus to the consultation form
5. WHEN items are added THEN the system SHALL maintain the doctor's scroll position in the form

### Requirement 14: Validation and Required Fields

**User Story:** As a doctor, I want to be notified of missing required information, so that I can ensure complete documentation.

#### Acceptance Criteria

1. WHEN attempting to complete symptoms section THEN the system SHALL validate that chief complaint is not empty
2. WHEN required fields are missing THEN the system SHALL highlight them in red with error messages
3. WHEN validation fails THEN the system SHALL prevent moving to next section
4. WHEN all required fields are completed THEN the system SHALL enable "Continue to Examination" button
5. WHEN validation passes THEN the system SHALL display success indicator

### Requirement 15: Real-Time Summary Generation

**User Story:** As a doctor, I want to see the symptom notes being generated in real-time as I answer template questions, so that I can review and edit the clinical narrative.

#### Acceptance Criteria

1. WHEN answering template questions THEN the system SHALL generate symptom notes in real-time
2. WHEN notes are generated THEN the system SHALL use proper medical terminology and formatting
3. WHEN notes are generated THEN the system SHALL display them in a "Symptom notes" section with edit capability
4. WHEN the doctor edits auto-generated notes THEN the system SHALL preserve the edits
5. WHEN template responses change THEN the system SHALL update the auto-generated portion while preserving manual edits
6. WHEN notes are finalized THEN the system SHALL combine auto-generated and manual text into final symptom notes

### Requirement 16: Navigation and Progress Tracking

**User Story:** As a doctor, I want to see my progress through the consultation, so that I know which sections are complete.

#### Acceptance Criteria

1. WHEN in consultation mode THEN the system SHALL display a progress indicator showing: Symptoms, Examination, Diagnosis, Prescribe
2. WHEN a section is completed THEN the system SHALL mark it with a checkmark
3. WHEN navigating between sections THEN the system SHALL save current section data before switching
4. WHEN returning to a completed section THEN the system SHALL display previously entered data
5. WHEN all sections are complete THEN the system SHALL enable "Complete Consultation" button

## Technical Considerations

### Database Structure
- `consultations` table
  - id, patient_id, doctor_id, appointment_id (nullable)
  - consultation_date, consultation_time
  - selected_complaints (json) - array of selected complaint buttons
  - visit_type (string, nullable)
  - template_responses (json) - responses to template questions
  - symptom_notes_auto (text) - auto-generated from template
  - symptom_notes_manual (text) - free-text entry
  - symptom_notes_final (text) - combined final notes
  - symptom_onset, symptom_duration, symptom_duration_unit
  - aggravating_factors (text), relieving_factors (text)
  - previous_episodes (boolean), previous_episodes_details (text)
  - review_of_systems (json)
  - associated_symptoms (json)
  - documentation_mode (template, freetext, hybrid)
  - status (draft, in_progress, completed)
  - current_section (symptoms, examination, diagnosis, prescribe)
  - timestamps

- `complaint_templates` table
  - id, complaint_name, category (adult, pediatric)
  - template_questions (json) - structured questions for this complaint
  - common_symptoms (json) - associated symptoms to check
  - timestamps

- `visit_type_templates` table
  - id, visit_type_name
  - template_questions (json)
  - required_fields (json)
  - timestamps

### User Interface
- Split-screen layout: consultation form (70%) + patient EMR sidebar (30%)
- Auto-save indicator in header
- Progress bar showing consultation sections
- Rich text editor for HPI
- Expandable ROS sections
- Modal overlays for quick actions

### Integration Points
- Link to patient's EMR data
- Link to past consultations
- Real-time updates using Livewire
- Auto-save using Livewire polling or debounce

## Success Metrics

1. Average time to document symptoms < 5 minutes
2. 100% of consultations have chief complaint documented
3. Auto-save prevents data loss in 100% of cases
4. 90% of doctors use ROS template
5. Draft consultations can be resumed within 24 hours
