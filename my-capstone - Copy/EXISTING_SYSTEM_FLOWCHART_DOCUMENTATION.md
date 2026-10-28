# Existing System Flowchart Documentation

## Chapter 4: System Analysis and Design

### Existing System Workflow (Manual Process)

This section depicts the workflow and processes prior to the introduction of the proposed Online Integrated Clinic Information System. The existing system relied entirely on manual procedures, paper-based documentation, and physical storage methods. The clinic operated on a walk-in basis with only two users: the doctor and the patient. All administrative tasks, medical documentation, and billing were handled manually by the doctor.

---

## 📋 **EXISTING SYSTEM OVERVIEW**

### **Key Components:**
- **Users:** Doctor, Patient (only 2 users - no staff/nurse)
- **Documents:** Patient Logbook, Patient Record Form, Prescription Pad, Billing Receipt
- **Storage:** Patient Logbook (Handwritten), Manual Patient Records (Paper Files)
- **Process Type:** Walk-in only (No appointment system in existing process)

---

## 🔄 **COMPLETE MANUAL WORKFLOW PROCESS**

### **Existing System: Walk-in Consultation Process**

**Actors:** Doctor, Patient (only 2 users)

**Complete Process Flow:**

### **Step 1: Patient Walk-in**
- Patient walks into the clinic without prior appointment
- Patient waits in waiting area for doctor availability
- First-come, first-served basis

**Problems:**
- No appointment system
- Unpredictable waiting times
- No way to manage patient flow
- Patients may wait for extended periods

---

### **Step 2: Patient Registration (Logbook)**
- Doctor registers patient information manually
- Doctor writes patient details in **Patient Logbook**:
  - Patient name
  - Date of visit
  - Time of arrival
  - Basic contact information
- Logbook serves as the only record of patient visits
- No structured patient database

**Documents Used:**
- Patient Logbook (handwritten)

**Storage Method:**
- Handwritten logbook kept at reception desk

**Problems:**
- Handwriting legibility issues
- No way to search for patient history
- Logbook can be lost or damaged
- Limited information captured
- No backup copy
- Difficult to track returning patients

---

### **Step 3: Patient Record Form**
- Doctor provides **Patient Record Form** to patient
- Patient fills out medical history information:
  - Personal information (name, age, gender, address, contact)
  - Medical history (past illnesses, surgeries)
  - Current medications
  - Known allergies
  - Family medical history
- Doctor reviews completed form before consultation
- Form becomes part of patient's paper file

**Documents Used:**
- Patient Record Form (paper, pre-printed template)

**Storage Method:**
- Paper form filed in patient folder
- Stored in filing cabinet

**Problems:**
- Time-consuming for patient to fill out
- Risk of incomplete or inaccurate information
- Difficult to read patient's handwriting
- No validation of entered data
- Forms can be lost or damaged
- No way to update information easily
- Duplicate information entry for returning patients

---

### **Step 4: Check Vital Signs**
- Doctor checks patient's vital signs manually:
  - Blood pressure (using manual sphygmomanometer)
  - Heart rate (pulse)
  - Temperature (using thermometer)
  - Weight (using scale)
  - Height (using stadiometer)
  - Respiratory rate
- Doctor manually records vital signs on patient record form or consultation notes
- No automated recording or alerts

**Documents Used:**
- Patient record form or consultation notes (paper)

**Storage Method:**
- Handwritten on patient record
- Filed with consultation notes

**Problems:**
- Manual recording prone to transcription errors
- No historical tracking of vital signs over time
- Difficult to identify trends or patterns
- No automated alerts for abnormal values
- Time-consuming to compare with previous readings
- Risk of misreading instruments

---

### **Step 5: Consultation**
- Doctor conducts face-to-face consultation with patient
- Doctor manually writes consultation notes on paper:
  - Chief complaint (reason for visit)
  - History of present illness
  - Symptoms reported by patient
  - Physical examination findings
  - Diagnosis (doctor's assessment)
  - Treatment plan and recommendations
- All notes are handwritten in free-form text
- No structured format (SOAP format not consistently followed)
- Doctor refers to previous paper records if available

**Documents Used:**
- Consultation notes (paper)
- Patient record form
- Previous consultation notes (if found)

**Storage Method:**
- Handwritten notes on paper
- Filed in patient folder

**Problems:**
- Handwriting legibility issues (difficult to read)
- No structured format for consistency
- Time-consuming to review previous consultation history
- Difficult to find specific information quickly
- No way to track patient progress over time
- Risk of losing consultation notes
- Cannot search for specific conditions or treatments
- No clinical decision support

---

### **Step 6: Prescription**
- Doctor writes prescription on **Prescription Pad** (handwritten)
- Includes:
  - Patient name
  - Date
  - Medication name (generic or brand)
  - Dosage (e.g., 500mg)
  - Frequency (e.g., 3 times daily)
  - Duration (e.g., 7 days)
  - Special instructions (e.g., take after meals)
  - Doctor's signature and license number
- Doctor gives original prescription to patient
- Carbon copy kept by doctor (if available)

**Documents Used:**
- Prescription pad (handwritten)
- Carbon copy (if available)

**Storage Method:**
- Patient keeps original prescription
- Doctor may keep carbon copy in patient folder

**Problems:**
- Handwriting legibility issues (high risk of medication errors)
- No automated allergy checking
- No drug interaction warnings
- Difficult to track prescription history
- Patient may lose prescription
- No centralized prescription database
- Cannot verify prescriptions electronic
- Cannot verify prescriptions electronically
- Risk of prescription fraud or alteration

---

### **Step 7: Billing**
- Doctor computes billing manually
- Doctor writes **Billing Receipt** by hand:
  - Patient name
  - Date
  - Services rendered (consultation)
  - Consultation fee
  - Additional charges (if any)
  - Total amount
- Patient pays (usually cash)
- Doctor gives receipt to patient
- Doctor records payment in cashbook or ledger

**Documents Used:**
- Billing receipt (handwritten, pre-numbered)
- Cashbook or ledger

**Storage Method:**
- Patient keeps original receipt
- Doctor keeps carbon copy
- Payment recorded in cashbook

**Problems:**
- Manual calculation errors
- No automated payment tracking system
- Lost receipts (no backup)
- Difficult to generate financial reports
- No payment history for patients
- Cash handling risks (theft, loss)
- Time-consuming end-of-day reconciliation
- No audit trail
- Cannot track outstanding payments

---

### **Step 8: Patient Leaves**
- Patient receives:
  - Prescription (original)
  - Billing receipt (original)
- Patient leaves clinic
- No follow-up system
- No appointment scheduling for next visit
- No automated reminders
- Patient must walk in again for next consultation

**Problems:**
- No follow-up tracking
- No appointment system for return visits
- No way to remind patients of follow-up care
- No continuity of care tracking

---

## 📊 **EXISTING SYSTEM PROBLEMS SUMMARY**

### **1. Efficiency Issues:**
- Time-consuming manual processes (registration, documentation, billing)
- Duplicate data entry (patient fills form, doctor writes in logbook)
- Slow information retrieval (searching through paper files)
- No appointment system (unpredictable patient flow)
- Doctor handles all administrative tasks (registration, billing)

### **2. Data Management Issues:**
- No centralized database (information scattered across documents)
- Difficult to search for specific patient information
- High risk of lost or damaged documents
- No backup system (single copy of records)
- Handwriting legibility problems (consultation notes, prescriptions)
- No standardized format for documentation

### **3. Accessibility Issues:**
- Cannot access records remotely
- Only one person can view a record at a time
- Difficult to share information with other healthcare providers
- Patients cannot access their own medical records
- Time-consuming to retrieve patient history

### **4. Security Issues:**
- Physical documents can be lost, stolen, or damaged
- No access control (anyone can access filing cabinet)
- No audit trail of who accessed or modified records
- Paper deterioration over time
- Risk of unauthorized access

### **5. Patient Care Issues:**
- No historical tracking of vital signs or patient progress
- Difficult to identify trends or patterns in patient health
- No automated allergy or drug interaction checking
- Risk of medication errors due to illegible handwriting
- No follow-up system for patient care
- No way to track treatment outcomes

### **6. Financial Management Issues:**
- Manual calculation errors in billing
- No payment tracking system
- Difficult to generate financial reports
- Cash handling risks (theft, loss)
- Time-consuming end-of-day reconciliation
- No audit trail for financial transactions

---

## 🎯 **JUSTIFICATION FOR PROPOSED SYSTEM**

The manual processes described above highlight the critical need for an integrated, digital healthcare information system. The proposed Online Integrated Clinic Information System addresses these challenges by:

### **Automation & Efficiency:**
1. **Automate** repetitive tasks (patient registration, billing calculations, appointment scheduling)
2. **Streamline** workflows and reduce administrative burden on doctor
3. **Eliminate** duplicate data entry
4. **Speed up** information retrieval and patient check-in process

### **Data Management & Security:**
5. **Centralize** patient information in a secure, structured database
6. **Provide** backup and disaster recovery capabilities
7. **Implement** access control and audit trails
8. **Ensure** data integrity and prevent loss of records
9. **Standardize** documentation format (SOAP notes)

### **Patient Care Improvement:**
10. **Enable** comprehensive medical history access at point of care
11. **Track** patient progress and vital signs over time
12. **Provide** allergy and drug interaction warnings
13. **Support** clinical decision-making with organized data
14. **Implement** follow-up and appointment reminder system

### **Accessibility & Communication:**
15. **Enable** remote access for authorized users
16. **Allow** patients to book appointments online
17. **Provide** patients access to their own medical records
18. **Facilitate** communication between doctor and patients

### **Financial Management:**
19. **Automate** billing calculations and payment tracking
20. **Generate** financial reports automatically
21. **Provide** audit trail for all transactions
22. **Reduce** cash handling risks

---

## 📝 **FLOWCHART ELEMENTS TO INCLUDE**

When creating your existing system flowchart diagram, include these elements:

### **Flowchart Symbols:**
- **Oval/Terminator:** Start/End (e.g., "Patient arrives", "Patient leaves")
- **Rectangle:** Process/Action (e.g., "Doctor fills out logbook", "Check vital signs")
- **Parallelogram:** Input/Output (e.g., "Patient information", "Prescription")
- **Diamond:** Decision Point (e.g., "Is patient new?", "Payment complete?")
- **Document Symbol:** Document (e.g., "Patient Record Form", "Prescription Pad")
- **Cylinder:** Storage (e.g., "Filing cabinet", "Patient logbook")
- **Arrow:** Flow direction

### **Main Process Flow (8 Steps):**
1. **Patient Walk-in** → Patient arrives at clinic
2. **Registration (Logbook)** → Doctor writes in patient logbook
3. **Patient Record Form** → Patient fills out medical history form
4. **Check Vital Signs** → Doctor measures and records vital signs
5. **Consultation** → Doctor examines patient and writes notes
6. **Prescription** → Doctor writes prescription on pad
7. **Billing** → Doctor computes fee and writes receipt
8. **Patient Leaves** → Patient receives prescription and receipt

### **Actors to Show:**
- **Doctor** (handles all tasks: registration, consultation, billing)
- **Patient** (receives care and fills out forms)

### **Documents to Indicate:**
- Patient Logbook (handwritten)
- Patient Record Form (paper)
- Consultation Notes (handwritten)
- Prescription Pad (handwritten)
- Billing Receipt (handwritten)

### **Storage to Show:**
- Patient Logbook (at reception desk)
- Filing Cabinet (patient folders)
- Cashbook/Ledger (payment records)

### **Key Characteristics to Highlight:**
- **Walk-in only** (no appointment system)
- **Manual processes** (all handwritten)
- **Paper-based** (no digital records)
- **Doctor-centric** (doctor handles all tasks)
- **No automation** (no reminders, no alerts)

---

## 📋 **WORKFLOW SUMMARY TABLE**

| Step | Actor | Process | Document Used | Storage | Problems |
|------|-------|---------|---------------|---------|----------|
| 1 | Patient | Walk-in to clinic | None | None | No appointment system, unpredictable wait times |
| 2 | Doctor | Register patient in logbook | Patient Logbook | Logbook | Handwriting issues, no search capability |
| 3 | Patient | Fill out medical history form | Patient Record Form | Filing Cabinet | Time-consuming, illegible handwriting |
| 4 | Doctor | Check and record vital signs | Patient Record Form | Filing Cabinet | Manual recording errors, no trend tracking |
| 5 | Doctor | Conduct consultation | Consultation Notes | Filing Cabinet | Illegible notes, no structured format |
| 6 | Doctor | Write prescription | Prescription Pad | Patient Folder | Medication errors risk, no allergy checking |
| 7 | Doctor | Compute billing and collect payment | Billing Receipt | Cashbook | Calculation errors, cash handling risks |
| 8 | Patient | Leave with prescription and receipt | Prescription, Receipt | Patient keeps | No follow-up system |

---

**Document Purpose:** This documentation serves as the basis for creating the Existing System Flowchart in Chapter 4 of the thesis manuscript. It accurately reflects the manual, paper-based processes used in the clinic before the implementation of the proposed Online Integrated Clinic Information System.

**Generated:** December 18, 2025
