# 🗺️ Consultation Module - TODO Roadmap

**Last Updated:** December 2, 2024  
**Status:** Diagnosis & Prescriptions Complete ✅

---

## ✅ COMPLETED FEATURES

- [x] Symptoms documentation (templates, free-text, vitals)
- [x] Examination documentation (body systems, findings)
- [x] Diagnosis with ICD-10 search
- [x] Multiple diagnoses with primary selection
- [x] Medicine database (17 common medicines)
- [x] Prescription search and add
- [x] Prescription edit modal with quick-select buttons
- [x] Auto-save functionality (every 30 seconds)
- [x] Tab navigation (Symptoms → Examination → Diagnosis & Prescribe)
- [x] Patient sidebar (demographics, vitals, allergies, conditions, medications)

---

## 🔥 HIGH PRIORITY - Core Features

### 1. ⏱️ Prescription History in Sidebar (15 minutes)
**Status:** 🔴 Not Started  
**Description:**
- Show recent prescriptions (last 30 days) in patient sidebar
- Display: Medicine name, dosage, date prescribed
- Helps avoid duplicates and see what worked before

**Implementation:**
- Add to patient sidebar (Executive Summary view)
- Query consultations with prescriptions from last 30 days
- Display in collapsible section

---

### 2. ⚠️ Drug Allergy Warning (20 minutes)
**Status:** 🔴 Not Started  
**Description:**
- When adding prescription, check against patient allergies
- Show warning popup if medicine matches allergy
- Example: Patient allergic to "Aspirin" → Warning when prescribing aspirin

**Implementation:**
- Add `checkDrugAllergy()` method in DiagnosisPrescribeForm
- Compare medicine name against patient allergies
- Show modal warning with "Prescribe Anyway" or "Cancel" options

---

### 3. 🖨️ Print Prescription (30 minutes)
**Status:** 🔴 Not Started  
**Description:**
- Generate PDF prescription document
- Include clinic letterhead, doctor signature, patient info, medicines
- Print button after completing consultation

**Implementation:**
- Install Laravel PDF package (dompdf or snappy)
- Create prescription PDF template
- Add "Print Prescription" button in consultation summary
- Generate PDF with all prescription details

---

### 4. 📄 Consultation Summary View (30 minutes)
**Status:** 🔴 Not Started  
**Description:**
- After completing consultation, show summary page
- Display all SOAP notes, diagnoses, prescriptions
- "Print Summary" and "Back to Patient" buttons

**Implementation:**
- Create consultation summary view
- Display: Symptoms, Examination, Diagnoses, Prescriptions
- Add print functionality
- Redirect here after "Complete Consultation"

---

## 🎨 MEDIUM PRIORITY - Polish & UX

### 5. 🏥 Add Consultation Type (10 minutes)
**Status:** 🔴 Not Started  
**Description:**
- Field to mark as "In-Clinic" or "Telemedicine"
- Shows in consultation header

**Implementation:**
- Add `consultation_type` enum field to consultations table
- Add dropdown in consultation header
- Display badge showing type

---

### 6. 💰 Add Consultation Fee (15 minutes)
**Status:** 🔴 Not Started  
**Description:**
- Simple field for consultation fee amount
- Payment status (Paid/Unpaid)
- Shows in consultation summary

**Implementation:**
- Add `consultation_fee` and `payment_status` to consultations table
- Add fields in consultation completion modal
- Display in summary view

---

### 7. ⚡ Quick Actions in Sidebar (20 minutes)
**Status:** 🔴 Not Started  
**Description:**
- Quick-add buttons for conditions, medications, allergies during consultation
- Opens modals without leaving consultation

**Implementation:**
- Add quick-add buttons in sidebar
- Wire up existing modals (already created)
- Refresh sidebar after adding

---

### 8. 📋 Consultation History in Sidebar (20 minutes)
**Status:** 🔴 Not Started  
**Description:**
- Show patient's recent consultations (last 5)
- Click to view past consultation details

**Implementation:**
- Add "Recent Consultations" section in sidebar
- Display: Date, chief complaint, diagnosis
- Link to view full consultation

---

## 🌟 LOW PRIORITY - Nice to Have

### 9. 🧪 Lab Orders (Future)
**Status:** 🔴 Not Started  
**Description:**
- Order lab tests (CBC, X-ray, etc.)
- Generate lab requisition form

**Implementation:**
- Create lab_orders table
- Add lab test database
- Create order form
- Generate requisition PDF

---

### 10. 📝 Medical Certificates (Future)
**Status:** 🔴 Not Started  
**Description:**
- Generate sick notes
- Medical fitness certificates

**Implementation:**
- Create certificate templates
- Add certificate generation form
- Generate PDF certificates

---

### 11. 📅 Follow-up Scheduling (Future)
**Status:** 🔴 Not Started  
**Description:**
- Schedule next appointment from consultation
- Set reminders

**Implementation:**
- Add "Schedule Follow-up" button
- Link to appointment booking
- Pre-fill patient details

---

## 📊 Implementation Phases

### **Phase 1: Complete Core Prescription Features** (45 min)
- [ ] 1. Prescription history in sidebar (15 min)
- [ ] 2. Drug allergy warning (20 min)
- [ ] 5. Add consultation type field (10 min)

### **Phase 2: Output & Documentation** (1 hour)
- [ ] 3. Print prescription PDF (30 min)
- [ ] 4. Consultation summary view (30 min)

### **Phase 3: Billing & Admin** (30 min)
- [ ] 6. Add consultation fee field (15 min)
- [ ] 8. Consultation history in sidebar (15 min)

### **Phase 4: Polish** (20 min)
- [ ] 7. Quick actions in sidebar (20 min)

### **Phase 5: Future Enhancements** (TBD)
- [ ] 9. Lab orders
- [ ] 10. Medical certificates
- [ ] 11. Follow-up scheduling

---

## 🎯 Next Steps

**Recommended:** Start with **Phase 1** - Core prescription features
- These are quick wins (45 minutes total)
- Critical for safety (drug allergy warning)
- Improves UX (prescription history)

**To start Phase 1, run:**
```bash
# We'll implement:
# 1. Prescription history in sidebar
# 2. Drug allergy warning
# 3. Consultation type field
```

---

## 📝 Notes

- All times are estimates
- Test each feature before moving to next
- Can adjust priorities based on clinic needs
- Some features may require additional packages (PDF generation)

---

## 🏆 Success Metrics

- [ ] Doctor can complete consultation in < 10 minutes
- [ ] Zero drug allergy incidents (warning system working)
- [ ] Prescriptions are clear and printable
- [ ] All SOAP notes properly documented
- [ ] System is stable and fast

---

**Ready to start Phase 1?** Let's implement the core prescription features!
