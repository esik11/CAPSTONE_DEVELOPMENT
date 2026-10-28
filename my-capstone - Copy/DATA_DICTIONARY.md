# DATA DICTIONARY
## Clinic Management System

---

## 1. Users Table

**Description:** Stores user account information for both doctors and patients who can access the system.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each user (PK) |
| name | VARCHAR | 255 | Full name of the user |
| email | VARCHAR | 255 | Email address for login and communication (UNIQUE) |
| password | VARCHAR | 255 | Encrypted password for authentication |
| role | ENUM | - | User role: 'doctor' or 'patient' |
| email_verified_at | TIMESTAMP | - | Timestamp when email was verified |
| remember_token | VARCHAR | 100 | Token for "remember me" functionality |
| created_at | TIMESTAMP | - | Record creation timestamp |
| updated_at | TIMESTAMP | - | Record last update timestamp |

---

## 2. Patients Table

**Description:** Stores comprehensive patient demographic and contact information.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each patient (PK) |
| user_id | BIGINT | 20 | Reference to users table (FK, UNIQUE) |
| first_name | VARCHAR | 255 | Patient's first name |
| last_name | VARCHAR | 255 | Patient's last name |
| middle_name | VARCHAR | 255 | Patient's middle name |
| date_of_birth | DATE | 10 | Patient's date of birth |
| gender | VARCHAR | 50 | Patient's gender (Male/Female) |
| marital_status | VARCHAR | 50 | Marital status (Single, Married, Divorced, etc.) |
| philhealth_number | VARCHAR | 255 | Philippine Health Insurance number (UNIQUE) |
| phone_number | VARCHAR | 255 | Primary contact number |
| email | VARCHAR | 255 | Patient's email address (UNIQUE) |
| employment_status | VARCHAR | 100 | Current employment status |
| language | VARCHAR | 255 | Preferred language |
| race | VARCHAR | 255 | Patient's race/ethnicity |
| region | VARCHAR | 255 | Geographic region |
| province | VARCHAR | 255 | Province of residence |
| city | VARCHAR | 255 | City of residence |
| barangay | VARCHAR | 255 | Barangay of residence |
| zip_code | VARCHAR | 20 | Postal code |
| emergency_first_name | VARCHAR | 255 | Emergency contact first name |
| emergency_last_name | VARCHAR | 255 | Emergency contact last name |
| emergency_relationship | VARCHAR | 255 | Relationship to patient |
| emergency_address | TEXT | 65535 | Emergency contact address |
| emergency_city | VARCHAR | 255 | Emergency contact city |
| emergency_state | VARCHAR | 255 | Emergency contact state/province |
| emergency_zip_code | VARCHAR | 20 | Emergency contact postal code |
| emergency_home_phone | VARCHAR | 255 | Emergency contact home phone |
| emergency_work_phone | VARCHAR | 255 | Emergency contact work phone |
| photo | VARCHAR | 255 | Path to patient photo |
| status | VARCHAR | 50 | Patient status (active/inactive) |
| created_at | TIMESTAMP | - | Record creation timestamp |
| updated_at | TIMESTAMP | - | Record last update timestamp |

---

## 3. Appointments Table

**Description:** Manages appointment scheduling between patients and doctors for both in-clinic and telemedicine consultations.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each appointment (PK) |
| patient_id | BIGINT | 20 | Reference to patients table (FK) |
| doctor_id | BIGINT | 20 | Reference to users table - doctor (FK) |
| start_time | DATETIME | 19 | Appointment start date and time |
| end_time | DATETIME | 19 | Appointment end date and time |
| reason | TEXT | 65535 | Reason for appointment |
| status | ENUM | - | Status: pending, approved, declined, rescheduled, completed, cancelled |
| appointment_type | VARCHAR | 50 |  |Type: in-clinic or telemedicine
| appointment_mode | ENUM | - | Mode: walk-in, scheduled, emergency |
| notes | TEXT | 65535 | Additional notes about appointment |
| checked_in_at | TIMESTAMP | 19 | Timestamp when patient checked in |
| checked_in_by | BIGINT | 20 | User who performed check-in (FK) |
| created_at | TIMESTAMP | 19 | Record creation timestamp |
| updated_at | TIMESTAMP | 19 | Record last update timestamp |

---

## 4. Telemedicine Sessions Table

**Description:** Manages video consultation sessions for telemedicine appointments, including meeting links, session status, and recording information.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each telemedicine session (PK) |
| appointment_id | BIGINT | 20 | Reference to appointments table (FK) |
| patient_id | BIGINT | 20 | Reference to patients table (FK) |
| doctor_id | BIGINT | 20 | Reference to users table - doctor (FK) |
| session_id | VARCHAR | 255 | Unique session identifier from video platform (UNIQUE) |
| meeting_link | TEXT | 65535 | Video call URL for the session |
| patient_join_link | TEXT | 65535 | Direct join link for patient |
| doctor_join_link | TEXT | 65535 | Direct join link for doctor |
| platform | VARCHAR | 50 | Video platform: jitsi, zoom, agora, twilio |
| status | ENUM | - | Status: scheduled, waiting, in_progress, completed, cancelled, no_show |
| scheduled_start | DATETIME | 19 | Scheduled start time |
| scheduled_end | DATETIME | 19 | Scheduled end time |
| actual_start | DATETIME | 19 | Actual session start time |
| actual_end | DATETIME | 19 | Actual session end time |
| duration_minutes | INTEGER | 11 | Actual duration in minutes |
| patient_joined_at | DATETIME | 19 | When patient joined the session |
| doctor_joined_at | DATETIME | 19 | When doctor joined the session |
| connection_quality | VARCHAR | 50 | Connection quality: excellent, good, fair, poor |
| is_recorded | BOOLEAN | 1 | Whether session was recorded |
| recording_url | TEXT | 65535 | URL to session recording |
| recording_duration | INTEGER | 11 | Recording duration in minutes |
| technical_issues | TEXT | 65535 | Any technical issues encountered |
| session_notes | TEXT | 65535 | Notes about the session |
| patient_rating | INTEGER | 11 | Patient rating (1-5) |
| patient_feedback | TEXT | 65535 | Patient feedback about session |
| created_at | TIMESTAMP | 19 | Record creation timestamp |
| updated_at | TIMESTAMP | 19 | Record last update timestamp |

---

## 5. Consultations Table

**Description:** Stores detailed consultation records including symptoms, examination findings, diagnosis, and prescriptions.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each consultation (PK) |
| patient_id | BIGINT | 20 | Reference to patients table (FK) |
| doctor_id | BIGINT | 20 | Reference to users table - doctor (FK) |
| appointment_id | BIGINT | 20 | Reference to appointments table (FK) |
| consultation_date | DATE | 10 | Date of consultation |
| consultation_time | TIME | 8 | Time of consultation |
| status | ENUM | - | Status: draft, in_progress, completed, cancelled |
| current_section | ENUM | - | Current section: symptoms, examination, diagnosis, prescribe |
| chief_complaint | TEXT | 65535 | Main reason for visit |
| selected_complaints | JSON | 65535 | Array of selected complaint buttons |
| visit_type | VARCHAR | 255 | Type of visit (e.g., COVID-19, General checkup) |
| documentation_mode | ENUM | - | Mode: template, freetext, hybrid |
| template_responses | JSON | 65535 | Responses to template questions |
| symptom_notes_auto | TEXT | 65535 | Auto-generated symptom notes from template |
| symptom_notes_manual | TEXT | 65535 | Free-text symptom notes by doctor |
| symptom_notes_final | TEXT | 65535 | Combined final symptom notes |
| symptom_onset | VARCHAR | 255 | When symptoms started |
| symptom_duration | INTEGER | 11 | Duration of symptoms |
| symptom_duration_unit | VARCHAR | 50 | Unit: hours, days, weeks, months |
| aggravating_factors | TEXT | 65535 | Factors that worsen symptoms |
| relieving_factors | TEXT | 65535 | Factors that relieve symptoms |
| previous_episodes | BOOLEAN | 1 | Whether patient had previous episodes |
| previous_episodes_details | TEXT | 65535 | Details of previous episodes |
| review_of_systems | JSON | 65535 | Systematic review of body systems |
| associated_symptoms | JSON | 65535 | Related symptoms |
| vital_signs | JSON | 65535 | Vital signs recorded during consultation |
| physical_examination | TEXT | 65535 | Physical examination findings |
| general_appearance | TEXT | 65535 | General appearance notes |
| heent | TEXT | 65535 | Head, Eyes, Ears, Nose, Throat findings |
| cardiovascular | TEXT | 65535 | Cardiovascular system findings |
| respiratory | TEXT | 65535 | Respiratory system findings |
| abdomen | TEXT | 65535 | Abdominal examination findings |
| neurological | TEXT | 65535 | Neurological examination findings |
| musculoskeletal | TEXT | 65535 | Musculoskeletal findings |
| skin | TEXT | 65535 | Skin examination findings |
| diagnosis | JSON | 65535 | Array of diagnoses with ICD-10 codes |
| prescriptions | JSON | 65535 | Array of prescribed medications |
| laboratory_tests | JSON | 65535 | Ordered laboratory tests |
| imaging_studies | JSON | 65535 | Ordered imaging studies |
| referrals | JSON | 65535 | Referrals to specialists |
| follow_up_date | DATE | 10 | Scheduled follow-up date |
| follow_up_instructions | TEXT | 65535 | Instructions for follow-up |
| patient_education | TEXT | 65535 | Education provided to patient |
| completed_at | TIMESTAMP | 19 | When consultation was completed |
| created_at | TIMESTAMP | 19 | Record creation timestamp |
| updated_at | TIMESTAMP | 19 | Record last update timestamp |

---

## 6. Medical Records Table

**Description:** Stores historical medical visit records and basic health information.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each medical record (PK) |
| patient_id | BIGINT | 20 | Reference to patients table (FK) |
| doctor_id | BIGINT | 20 | Reference to users table - doctor (FK) |
| visit_date | DATETIME | 19 | Date and time of visit |
| symptoms | TEXT | 65535 | Reported symptoms |
| diagnosis | TEXT | 65535 | Medical diagnosis |
| treatment | TEXT | 65535 | Prescribed treatment |
| notes | TEXT | 65535 | Additional notes |
| talking_points | TEXT | 65535 | Key discussion points |
| created_at | TIMESTAMP | 19 | Record creation timestamp |
| updated_at | TIMESTAMP | 19 | Record last update timestamp |

---

## 7. Medications Table

**Description:** Stores current and past medications for patients.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each medication record (PK) |
| medical_record_id | BIGINT | 20 | Reference to medical_records table (FK) |
| medicine_name | VARCHAR | 255 | Name of the medication |
| dosage | VARCHAR | 255 | Dosage amount and unit |
| frequency | VARCHAR | 255 | How often medication is taken |
| created_at | TIMESTAMP | 19 | Record creation timestamp |
| updated_at | TIMESTAMP | 19 | Record last update timestamp |

---

## 8. Allergies Table

**Description:** Records patient allergies to medications and other substances.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each allergy record (PK) |
| medical_record_id | BIGINT | 20 | Reference to medical_records table (FK) |
| allergen_name | VARCHAR | 255 | Name of the allergen |
| type | ENUM | - | Type: medication, non_medication |
| category | VARCHAR | 100 | Category: drug, food, environmental, other |
| food_type | VARCHAR | 100 | Specific food type if applicable |
| severity | ENUM | - | Severity: mild, moderate, severe |
| reaction | TEXT | 65535 | Description of allergic reaction |
| onset_date | DATE | 10 | When allergy was first identified |
| created_at | TIMESTAMP | 19 | Record creation timestamp |
| updated_at | TIMESTAMP | 19 | Record last update timestamp |

---

## 9. Billings Table

**Description:** Manages billing and payment records for consultations.

| Field Name | Data Type | Length | Description |
|------------|-----------|--------|-------------|
| id | BIGINT | 20 | Unique identifier for each billing record (PK) |
| consultation_id | BIGINT | 20 | Reference to consultations table (FK) |
| receipt_number | VARCHAR | 255 | Unique receipt number (e.g., REC-2026-0001) (UNIQUE) |
| billing_date | DATE | 10 | Date of billing |
| total_amount | DECIMAL | 10,2 | Total amount to be paid |
| items | JSON | 65535 | Array of billing items with descriptions and amounts |
| payment_method | ENUM | - | Method: cash, card, gcash, paymaya, bank_transfer |
| payment_status | ENUM | - | Status: paid, pending, partial, waived |
| is_waived | BOOLEAN | 1 | Whether payment is waived |
| waive_reason | VARCHAR | 255 | Reason for waiving payment |
| notes | TEXT | 65535 | Additional billing notes |
| created_at | TIMESTAMP | 19 | Record creation timestamp |
| updated_at | TIMESTAMP | 19 | Record last update timestamp |

---

## ENTITY RELATIONSHIPS

**Primary Key (PK):** Unique identifier for each record in the table  
**Foreign Key (FK):** Reference to another table's primary key

### Relationships Summary:

1. **Users ↔ Patients:** One-to-One relationship (one user account per patient)
2. **Patients → Appointments:** One-to-Many (one patient can have many appointments)
3. **Doctors → Appointments:** One-to-Many (one doctor can have many appointments)
4. **Appointments → Telemedicine Sessions:** One-to-One (telemedicine appointments have one session)
5. **Appointments → Consultations:** One-to-One (one appointment results in one consultation)
6. **Patients → Consultations:** One-to-Many (one patient can have many consultations)
7. **Patients → Medical Records:** One-to-Many (one patient can have many medical records)
8. **Medical Records → Medications:** One-to-Many (one medical record can have many medications)
9. **Medical Records → Allergies:** One-to-Many (one medical record can have many allergies)
10. **Consultations → Billings:** One-to-One (one consultation has one billing record)

---

## DATA TYPE DEFINITIONS

| Data Type | Length | Description |
|-----------|--------|-------------|
| BIGINT | 20 | Large integer for IDs (auto-incrementing, up to 19 digits) |
| VARCHAR(n) | n | Variable-length text with maximum length of n characters |
| TEXT | 65535 | Long-form text (up to 64KB) |
| DATE | 10 | Date value (YYYY-MM-DD format) |
| DATETIME | 19 | Date and time value (YYYY-MM-DD HH:MM:SS format) |
| TIME | 8 | Time value (HH:MM:SS format) |
| TIMESTAMP | 19 | Automatic timestamp for record tracking |
| DECIMAL(m,n) | m,n | Precise numeric value (m total digits, n decimal places) |
| INTEGER | 11 | Whole number (up to 10 digits) |
| BOOLEAN | 1 | True/false value (0 or 1) |
| ENUM | - | Predefined list of allowed values (variable) |
| JSON | 65535 | Structured data stored in JSON format (up to 64KB) |

---

## NOTES

**Constraints:**
- **PRIMARY KEY (PK):** Unique identifier, cannot be null, auto-increments
- **FOREIGN KEY (FK):** References another table's primary key
- **UNIQUE:** Value must be unique across all records
- **NOT NULL:** Field must have a value
- **CASCADE DELETE:** When parent record is deleted, child records are automatically deleted
- **SET NULL:** When parent record is deleted, foreign key is set to NULL

**Timestamp Fields:**
- `created_at`: Automatically set when record is created
- `updated_at`: Automatically updated when record is modified

---

**Document Version:** 1.0  
**Last Updated:** January 8, 2026  
**System:** Clinic Management System
