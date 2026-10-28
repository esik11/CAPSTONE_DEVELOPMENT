# E-Prescription Module - Real World Scenario

## Scenario: Dr. John Doe's Busy Monday at Salamat Doc Clinic

**Date:** January 6, 2026 (Monday)  
**Time:** 2:30 PM  
**Location:** Salamat Doc Clinic

---

## Background Story

Dr. John Doe just finished his lunch break and is reviewing his dashboard. He completed 3 consultations this morning and has 2 more appointments scheduled for the afternoon. His phone rings - it's Maria Santos, a patient he saw last week.

---

## 📞 The Phone Call

**Maria Santos (Patient):** "Good afternoon, Doc! This is Maria Santos. I'm calling about the prescription you gave me last week for my UTI."

**Dr. John Doe:** "Hi Maria! How can I help you?"

**Maria:** "Doc, I started taking the Amoxicillin you prescribed, but I developed a rash this morning. I think I might be allergic to it. The infection symptoms are still there."

**Dr. John:** "I see. Stop taking the Amoxicillin immediately. I'll prescribe you an alternative medication. Can you come to the clinic to pick up the new prescription?"

**Maria:** "Yes, Doc. I can be there in 30 minutes."

**Dr. John:** "Perfect. I'll have it ready for you."

---

## 🖥️ Using the E-Prescription Module

### Step 1: Accessing the System (2:32 PM)

Dr. John Doe logs into the Salamat Doc system and sees his dashboard:

```
Dashboard Overview:
- Today's Consultations: 3
- Today's Appointments: 2 (1 pending)
- This Week's Revenue: ₱2,555.00
- Total Patients: 45
```

He clicks on **"E-Prescription"** in the sidebar.

---

### Step 2: Searching for Patient (2:33 PM)

The E-Prescription page loads. Dr. John types in the search box:

```
Search: "Maria Santos"
```

**Search Results appear:**
```
┌─────────────────────────────────────┐
│ Maria Santos                        │
│ 32 yrs, Female • 0917-123-4567     │
└─────────────────────────────────────┘
```

He clicks on Maria's name.

---

### Step 3: Patient Information Loads (2:33 PM)

The system displays Maria's information:

**Patient Information:**
```
Name: Maria Santos
Age: 32 years
Sex: Female
```

**⚠️ ALLERGIES SECTION (Red Background):**
```
⚠️ Allergies
• Amoxicillin [SEVERE]
  (Just added from phone call)
```

**Active Conditions:**
```
• Urinary Tract Infection (UTI)
  Diagnosed: Jan 2, 2026
```

**Current Medications:**
```
• Amoxicillin 500mg - 1 capsule, 3x daily
  (Needs to be replaced)
```

---

### Step 4: Viewing Recent Prescriptions (2:34 PM)

Dr. John scrolls down to see Maria's **Recent Prescriptions** section:

```
┌────────────────────────────────────────────────────┐
│ Recent Prescriptions                               │
├────────────────────────────────────────────────────┤
│ Jan 2, 2026                    [Repeat Script]     │
│ Diagnosis: Urinary Tract Infection                 │
│ • Amoxicillin 500mg - 1 capsule, 3x daily         │
│ • Phenazopyridine 200mg - 1 tablet, 3x daily      │
└────────────────────────────────────────────────────┘
```

---

### Step 5: Creating New Prescription (2:35 PM)

Dr. John sees the allergy warning and knows he needs to prescribe an alternative antibiotic. He clicks **"+ Add Medication"**.

**Medication 1 Form appears:**

He fills in:
```
Medicine Name: Ciprofloxacin
Strength: 500mg
Dosage: 1 tablet
Frequency: Twice daily
Duration: 7 days
Quantity: 14 tablets
Instructions: Take with plenty of water
Additional Instructions: Avoid dairy products 2 hours before/after taking
```

He clicks **"+ Add Medication"** again for the pain reliever.

**Medication 2 Form:**
```
Medicine Name: Phenazopyridine
Strength: 200mg
Dosage: 1 tablet
Frequency: Three times daily
Duration: 3 days
Quantity: 9 tablets
Instructions: After meals
Additional Instructions: May cause orange discoloration of urine (normal)
```

---

### Step 6: Review and Save (2:37 PM)

Dr. John reviews the prescription:

**New Prescription Summary:**
```
Medication 1:
✓ Ciprofloxacin 500mg
  1 tablet, Twice daily, 7 days
  Qty: 14 tablets
  Instructions: Take with plenty of water
  Note: Avoid dairy products 2 hours before/after taking

Medication 2:
✓ Phenazopyridine 200mg
  1 tablet, Three times daily, 3 days
  Qty: 9 tablets
  Instructions: After meals
  Note: May cause orange discoloration of urine (normal)
```

He clicks **"Save Prescription"**.

---

### Step 7: System Processing (2:37 PM)

The system:
1. ✅ Validates all required fields
2. ✅ Creates a new consultation record:
   ```
   Consultation ID: 47
   Patient: Maria Santos
   Doctor: Dr. John Doe
   Date: Jan 6, 2026
   Time: 2:37 PM
   Type: Prescription Only
   Status: Completed
   Chief Complaint: "Prescription Only"
   Prescriptions: [2 medications saved as JSON]
   ```
3. ✅ Shows success message: "Prescription saved successfully!"

---

### Step 8: Verification (2:38 PM)

The page refreshes and shows Maria's updated information:

**Recent Prescriptions now shows:**
```
┌────────────────────────────────────────────────────┐
│ Recent Prescriptions                               │
├────────────────────────────────────────────────────┤
│ Jan 6, 2026 (Just now)         [Repeat Script]    │
│ Diagnosis: N/A                                     │
│ • Ciprofloxacin 500mg - 1 tablet, 2x daily       │
│ • Phenazopyridine 200mg - 1 tablet, 3x daily     │
├────────────────────────────────────────────────────┤
│ Jan 2, 2026                    [Repeat Script]     │
│ Diagnosis: Urinary Tract Infection                 │
│ • Amoxicillin 500mg - 1 capsule, 3x daily        │
│ • Phenazopyridine 200mg - 1 tablet, 3x daily     │
└────────────────────────────────────────────────────┘
```

---

## 📋 What Happened in the System

### Database Changes:

**1. Consultations Table:**
```sql
INSERT INTO consultations (
    patient_id: 15,
    doctor_id: 2,
    consultation_date: '2026-01-06',
    consultation_time: '14:37:00',
    status: 'completed',
    chief_complaint: 'Prescription Only',
    prescriptions: '[
        {
            "medicine_name": "Ciprofloxacin",
            "strength": "500mg",
            "dosage": "1 tablet",
            "frequency": "Twice daily",
            "duration": "7 days",
            "quantity": "14 tablets",
            "instructions": "Take with plenty of water",
            "additional_instructions": "Avoid dairy products 2 hours before/after taking"
        },
        {
            "medicine_name": "Phenazopyridine",
            "strength": "200mg",
            "dosage": "1 tablet",
            "frequency": "Three times daily",
            "duration": "3 days",
            "quantity": "9 tablets",
            "instructions": "After meals",
            "additional_instructions": "May cause orange discoloration of urine (normal)"
        }
    ]'
)
```

**2. Allergies Table (Updated earlier):**
```sql
INSERT INTO allergies (
    patient_id: 15,
    allergen: 'Amoxicillin',
    reaction: 'Skin rash',
    severity: 'severe',
    notes: 'Developed rash after 4 days of use'
)
```

---

## 📱 Patient Side Experience

### Maria's Patient Portal (2:45 PM)

Maria arrives at the clinic and checks her patient portal on her phone while waiting:

**Patient Dashboard shows:**
```
Recent Consultations:
┌────────────────────────────────────┐
│ Jan 6, 2026 - 2:37 PM             │
│ Type: Prescription Only            │
│ Status: Completed                  │
│ [View Details]                     │
└────────────────────────────────────┘
```

She clicks **"View Details"** and sees:

**Prescription Details:**
```
Prescribed by: Dr. John Doe
Date: January 6, 2026

Medications:
1. Ciprofloxacin 500mg
   • Dosage: 1 tablet
   • Frequency: Twice daily
   • Duration: 7 days
   • Quantity: 14 tablets
   • Instructions: Take with plenty of water
   • Note: Avoid dairy products 2 hours before/after taking

2. Phenazopyridine 200mg
   • Dosage: 1 tablet
   • Frequency: Three times daily
   • Duration: 3 days
   • Quantity: 9 tablets
   • Instructions: After meals
   • Note: May cause orange discoloration of urine (normal)
```

---

## 📊 Reports Integration

### Later that day (5:00 PM)

Dr. John checks his **Reports** module:

**Prescription Report shows:**
```
Issued Prescriptions - January 6, 2026

Maria Santos (32 yrs, Female)
Consultation Date: Jan 6, 2026
• Ciprofloxacin 500mg - 1 tablet, 2x daily
• Phenazopyridine 200mg - 1 tablet, 3x daily
```

**Daily Consultation Log shows:**
```
Date: Jan 6, 2026
Patient: Maria Santos
Type: Prescription Only
Chief Complaint: Prescription Only
Diagnosis: N/A
[View Details]
```

---

## 🎯 Alternative Scenario: Using Repeat Script

### What if Maria needed the SAME prescription next month?

**Scenario:** Maria's UTI returns in February.

**Dr. John's workflow:**

1. Opens E-Prescription
2. Searches "Maria Santos"
3. Sees her recent prescriptions
4. Clicks **"Repeat Script"** on the January 6 prescription
5. All medications auto-fill instantly:
   ```
   ✓ Ciprofloxacin 500mg - all fields filled
   ✓ Phenazopyridine 200mg - all fields filled
   ```
6. Reviews (maybe adjusts duration)
7. Clicks **"Save Prescription"**
8. Done in 30 seconds!

---

## ⏱️ Time Comparison

### Without E-Prescription Module:
```
1. Create new appointment          (2 min)
2. Start consultation              (1 min)
3. Fill symptoms form              (3 min)
4. Skip examination                (0 min)
5. Fill diagnosis & prescribe      (4 min)
6. Review and finalize             (2 min)
7. Create billing                  (2 min)
────────────────────────────────────────
Total Time: ~14 minutes
```

### With E-Prescription Module:
```
1. Open E-Prescription             (5 sec)
2. Search patient                  (10 sec)
3. Review allergies/conditions     (20 sec)
4. Add medications                 (2 min)
5. Save prescription               (5 sec)
────────────────────────────────────────
Total Time: ~3 minutes
```

**Time Saved: 11 minutes (79% faster!)**

---

## 🔒 Safety Features in Action

### What the system prevented:

1. **Allergy Alert:**
   - System showed Amoxicillin allergy in RED
   - Dr. John saw it immediately
   - Prevented re-prescribing the same medication

2. **Medical History:**
   - Showed active UTI condition
   - Displayed current medications
   - Helped inform treatment decision

3. **Complete Records:**
   - All prescriptions tracked
   - Patient can view anytime
   - Available in reports

---

## 📈 Business Impact

### For the Clinic:

**Efficiency:**
- Faster prescription management
- No need for full consultation
- More patients can be served

**Revenue:**
- Quick prescriptions = more time for complex cases
- Better patient satisfaction = more referrals

**Compliance:**
- All prescriptions documented
- Complete audit trail
- Easy reporting

### For the Doctor:

**Convenience:**
- Handle prescription changes quickly
- Work from anywhere (if system is web-based)
- Less paperwork

**Safety:**
- Allergy warnings
- Medical history at fingertips
- Prescription history visible

### For the Patient:

**Accessibility:**
- View prescriptions anytime
- Digital records
- No lost paper prescriptions

**Safety:**
- Doctor sees all allergies
- Informed prescribing
- Better care

---

## 🎓 Key Takeaways

1. **E-Prescription saves time** - 79% faster than full consultation
2. **Safety first** - Allergy warnings prevent errors
3. **Repeat Script is powerful** - One-click prescription renewal
4. **Integrated system** - Works with consultations, reports, patient portal
5. **Real-world solution** - Solves actual clinical problems

---

## 💡 Other Use Cases

### Use Case 2: Chronic Disease Management
**Patient:** Juan Reyes (Hypertension)
**Scenario:** Monthly prescription renewal
**Solution:** Repeat Script → Adjust quantity → Save (30 seconds)

### Use Case 3: Follow-up Prescription
**Patient:** Ana Cruz (Post-surgery)
**Scenario:** Pain medication adjustment
**Solution:** Search patient → Add new medication → Save (2 minutes)

### Use Case 4: Telemedicine Follow-up
**Patient:** Pedro Garcia (Video consultation)
**Scenario:** Prescription after video call
**Solution:** E-Prescription during call → Send to patient portal (3 minutes)

---

**This is how the E-Prescription module works in real-world clinical practice at Salamat Doc Clinic!**

---

**Document Created:** January 5, 2026  
**Scenario Date:** January 6, 2026  
**Version:** 1.0.0
