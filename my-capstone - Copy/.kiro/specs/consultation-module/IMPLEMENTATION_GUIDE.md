# Consultation Module - Implementation Guide

## Overview

This guide provides a step-by-step approach to implementing the Consultation Module. We'll build it in phases to ensure each component works before moving to the next.

---

## Phase 1: Database Foundation (Day 1)

### Step 1.1: Create Database Tables

**Tables to create:**

1. **consultations**
   - id, patient_id, doctor_id, appointment_id (nullable)
   - consultation_date, consultation_time
   - chief_complaint, history_present_illness
   - status (draft, completed, cancelled)
   - timestamps

2. **consultation_physical_exams**
   - id, consultation_id
   - general, heent, cardiovascular, respiratory, abdomen
   - neurological, musculoskeletal, skin, other
   - timestamps

3. **consultation_diagnoses**
   - id, consultation_id
   - diagnosis_name, icd10_code
   - is_primary (boolean)
   - timestamps

4. **consultation_plans**
   - id, consultation_id
   - treatment_plan (text)
   - follow_up_instructions (text)
   - timestamps

5. **prescriptions**
   - id, consultation_id, patient_id, doctor_id
   - medication_name, strength, dosage_form
   - quantity, directions (sig)
   - refills, notes
   - status (pending, dispensed, cancelled)
   - timestamps

6. **lab_orders**
   - id, consultation_id, patient_id, doctor_id
   - test_name, test_type (lab, imaging)
   - clinical_indication
   - status (pending, completed, cancelled)
   - timestamps

7. **referrals**
   - id, consultation_id, patient_id, doctor_id
   - specialty, reason
   - urgency (routine, urgent, emergent)
   - status (pending, completed, cancelled)
   - timestamps

8. **medical_certificates**
   - id, consultation_id, patient_id, doctor_id
   - certificate_type (sick_note, medical_certificate, fit_to_work)
   - content (text)
   - valid_from, valid_to
   - timestamps

### Step 1.2: Create Models

Create Eloquent models for all tables with proper relationships:
- Consultation belongsTo Patient, Doctor, Appointment
- Consultation hasOne PhysicalExam, ConsultationPlan
- Consultation hasMany Diagnoses, Prescriptions, LabOrders, Referrals, MedicalCertificates

---

## Phase 2: Basic Consultation Interface (Day 2-3)

### Step 2.1: Create Consultation Controller

**Routes:**
```php
Route::get('/patients/{patient}/consultation/start', [ConsultationController::class, 'start']);
Route::get('/consultations/{consultation}', [ConsultationController::class, 'show']);
Route::post('/consultations/{consultation}/complete', [ConsultationController::class, 'complete']);
```

### Step 2.2: Create Consultation Layout

**Layout structure:**
```
┌─────────────────────────────────────────────────────────┐
│ Header: Patient Name, Age, ID | Save Draft | Complete   │
├──────────────────────┬──────────────────────────────────┤
│                      │                                  │
│  Consultation Form   │    Patient EMR Summary          │
│  (Main Content)      │    (Sidebar - 30% width)        │
│                      │                                  │
│  - Chief Complaint   │    - Demographics               │
│  - HPI               │    - Vitals                     │
│  - Vitals            │    - Conditions                 │
│  - Physical Exam     │    - Medications                │
│  - Assessment        │    - Allergies                  │
│  - Plan              │    - Recent Consultations       │
│  - Prescriptions     │                                  │
│  - Orders            │    Quick Actions:               │
│  - Referrals         │    [+ Condition]                │
│                      │    [+ Medication]               │
│                      │    [+ Allergy]                  │
│                      │                                  │
└──────────────────────┴──────────────────────────────────┘
```

### Step 2.3: Create Livewire Components

**Components to create:**
1. `ConsultationForm` - Main consultation form
2. `ConsultationSidebar` - Patient EMR summary
3. `ChiefComplaintSection` - Chief complaint input
4. `VitalsQuickEntry` - Quick vital signs entry
5. `PhysicalExamSection` - Physical examination form
6. `AssessmentSection` - Assessment and diagnoses
7. `PlanSection` - Treatment plan

---

## Phase 3: SOAP Notes Implementation (Day 4-5)

### Step 3.1: Chief Complaint & HPI

**Features:**
- Text input for chief complaint
- Rich text editor for HPI (use Trix or TinyMCE)
- Auto-save every 30 seconds
- Character counter

### Step 3.2: Vitals Quick Entry

**Features:**
- Inline vital signs form
- Validation for ranges
- Highlight abnormal values
- Link to full vitals history

### Step 3.3: Physical Examination

**Features:**
- Accordion/tabs for body systems
- Quick-select normal findings
- Free-text entry for abnormal findings
- Template support

### Step 3.4: Assessment & Diagnosis

**Features:**
- ICD-10 code search (use searchable dropdown)
- Multiple diagnoses support
- Primary/secondary designation
- Quick-add to patient conditions

### Step 3.5: Treatment Plan

**Features:**
- Rich text editor
- Structured sections
- Link to prescription creation
- Link to order creation

---

## Phase 4: Prescriptions (Day 6-7)

### Step 4.1: Prescription Creation

**Features:**
- Medication search (searchable dropdown)
- Strength and dosage form selection
- Quantity input
- Sig (directions) with templates
- Refills
- Drug allergy checking
- Drug interaction checking

### Step 4.2: Prescription Display

**Features:**
- List of prescriptions in consultation
- Edit/delete prescriptions
- Print prescription button
- Add to patient medications

### Step 4.3: Prescription PDF Generation

**Features:**
- Generate PDF with doctor letterhead
- Include patient demographics
- Include all prescriptions
- Doctor signature and license number
- Print/download functionality

---

## Phase 5: Orders & Referrals (Day 8)

### Step 5.1: Lab Orders

**Features:**
- Test search (CBC, BMP, etc.)
- Multiple tests per order
- Clinical indication
- Generate requisition form

### Step 5.2: Imaging Orders

**Features:**
- Imaging type selection (X-ray, CT, MRI, Ultrasound)
- Body part/region
- Clinical indication
- Generate requisition form

### Step 5.3: Referrals

**Features:**
- Specialty selection
- Reason for referral
- Urgency level
- Generate referral letter

---

## Phase 6: Medical Certificates (Day 9)

### Step 6.1: Sick Note Generation

**Features:**
- Date range selection
- Diagnosis
- Fitness to work/study
- Generate PDF

### Step 6.2: Medical Certificate

**Features:**
- Certificate type selection
- Custom content
- Generate PDF

---

## Phase 7: Quick Actions & Integration (Day 10)

### Step 7.1: Quick Add Modals

**Features:**
- Quick add condition (modal overlay)
- Quick add medication (modal overlay)
- Quick add allergy (modal overlay)
- Real-time EMR sidebar updates

### Step 7.2: Auto-save Implementation

**Features:**
- Auto-save every 30 seconds
- Visual indicator (saving/saved)
- Prevent data loss

### Step 7.3: Consultation History

**Features:**
- List past consultations
- View consultation details (read-only)
- Filter by date/doctor
- Print consultation summary

---

## Phase 8: Templates & Optimization (Day 11-12)

### Step 8.1: Consultation Templates

**Features:**
- Common templates (Annual Physical, Follow-up, Acute Illness)
- Custom template creation
- Template selection on consultation start

### Step 8.2: Text Macros

**Features:**
- Define text shortcuts
- Auto-expand macros
- Common medical abbreviations

### Step 8.3: Performance Optimization

**Features:**
- Lazy loading for consultation history
- Optimize database queries
- Cache patient EMR summary

---

## Phase 9: Billing & Finalization (Day 13)

### Step 9.1: CPT Code Assignment

**Features:**
- CPT code selection
- Suggested codes based on complexity
- Fee calculation

### Step 9.2: Consultation Completion

**Features:**
- Validation before completion
- Mark as finalized
- Generate consultation summary PDF
- Update patient's last visit date
- Return to patient overview

---

## Phase 10: Testing & Polish (Day 14-15)

### Step 10.1: Testing

- Test all consultation workflows
- Test auto-save functionality
- Test PDF generation
- Test drug allergy/interaction checks
- Test quick actions
- Test on different screen sizes

### Step 10.2: Polish

- Improve UI/UX
- Add loading states
- Add success/error messages
- Add keyboard shortcuts
- Add tooltips and help text

---

## Technical Stack

**Backend:**
- Laravel 11
- Livewire 3
- MySQL

**Frontend:**
- Tailwind CSS
- Alpine.js
- Trix/TinyMCE (rich text editor)
- Select2/Choices.js (searchable dropdowns)

**PDF Generation:**
- Laravel DomPDF or Snappy

**Additional Libraries:**
- ICD-10 API or database
- Drug database (RxNorm or custom)
- Drug interaction checker

---

## Database Relationships

```
Patient
  └── hasMany Consultations
        ├── hasOne PhysicalExam
        ├── hasOne ConsultationPlan
        ├── hasMany Diagnoses
        ├── hasMany Prescriptions
        ├── hasMany LabOrders
        ├── hasMany Referrals
        └── hasMany MedicalCertificates

Doctor
  └── hasMany Consultations

Appointment
  └── hasOne Consultation
```

---

## Key Features Summary

✅ **Core Documentation:**
- Chief complaint & HPI
- Physical examination
- Assessment & diagnosis
- Treatment plan

✅ **Clinical Actions:**
- Prescriptions with drug checking
- Lab/imaging orders
- Specialist referrals
- Medical certificates

✅ **Efficiency Features:**
- Auto-save
- Quick actions
- Templates
- Text macros

✅ **Integration:**
- Links to EMR data
- Updates patient records
- Real-time sidebar updates

✅ **Output:**
- Consultation summary PDF
- Prescription PDF
- Lab requisition forms
- Referral letters
- Medical certificates

---

## Next Steps

1. Review this implementation guide
2. Confirm the scope and features
3. Start with Phase 1 (Database Foundation)
4. Build incrementally, testing each phase
5. Iterate based on feedback

Would you like to proceed with implementation?
