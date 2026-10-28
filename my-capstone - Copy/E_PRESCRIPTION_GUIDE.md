# E-Prescription Module Guide

## Overview
The E-Prescription module allows doctors to create, modify, and manage prescriptions independently from the full consultation workflow. This is particularly useful for:

- **Prescription amendments** after consultation finalization
- **Allergy discoveries** requiring medication changes
- **Follow-up prescriptions** without full consultation
- **Quick prescriptions** for simple cases
- **Prescription renewals** using the Repeat Script feature

---

## Features

### 1. Patient Search
- **Autocomplete search** by name or phone number
- **Real-time results** as you type
- **Patient details** displayed after selection

### 2. Safety Information Display
- **Allergy Warnings** - Color-coded by severity (severe/moderate/mild)
- **Active Conditions** - Current medical conditions
- **Current Medications** - Ongoing medication regimen

### 3. Prescription Creation
- **Add multiple medications** with detailed information
- **Required fields:**
  - Medicine Name
  - Strength (e.g., 500mg)
  - Dosage (e.g., 1 tablet)
  - Frequency (e.g., Twice daily)
  - Duration (e.g., 7 days)
  - Quantity (e.g., 14 tablets)
  - Instructions (e.g., After meals)
- **Optional field:**
  - Additional Instructions

### 4. Repeat Script Feature
- **View recent prescriptions** from patient's history
- **One-click reload** of previous prescriptions
- **Modify as needed** before saving
- **Saves time** for recurring prescriptions

### 5. Prescription Management
- **Add Medication** - Add new medications to prescription
- **Remove Medication** - Remove unwanted medications
- **Clear All** - Start fresh
- **Save Prescription** - Creates a new consultation record

---

## How to Use

### Step 1: Access E-Prescription
1. Login as doctor
2. Click **E-Prescription** in the sidebar
3. You'll see the e-prescription interface

### Step 2: Select Patient
1. Type patient name or phone in the search box
2. Select patient from dropdown results
3. Patient information and medical history will load

### Step 3: Review Safety Information
1. Check **Allergies** section (if any)
2. Review **Active Conditions**
3. Note **Current Medications**

### Step 4: Create Prescription

**Option A: New Prescription**
1. Click **+ Add Medication** button
2. Fill in all required fields
3. Add more medications as needed
4. Click **Save Prescription**

**Option B: Repeat Script**
1. Scroll to **Recent Prescriptions** section
2. Find the prescription you want to repeat
3. Click **Repeat Script** button
4. Medications will auto-fill
5. Modify if needed
6. Click **Save Prescription**

### Step 5: Save
1. Review all medications
2. Click **Save Prescription**
3. Prescription is saved as a new consultation
4. Patient can view it in their records

---

## Use Cases

### Case 1: Allergy Discovery
**Scenario:** Patient discovers allergy to prescribed medication after consultation finalization.

**Solution:**
1. Open E-Prescription
2. Search for patient
3. See allergy warning
4. Create new prescription with alternative medication
5. Save

### Case 2: Dosage Adjustment
**Scenario:** Need to change medication dosage without full consultation.

**Solution:**
1. Open E-Prescription
2. Search for patient
3. Click Repeat Script on recent prescription
4. Modify dosage
5. Save

### Case 3: Follow-up Prescription
**Scenario:** Patient needs prescription renewal for chronic condition.

**Solution:**
1. Open E-Prescription
2. Search for patient
3. Click Repeat Script
4. Adjust duration/quantity if needed
5. Save

### Case 4: Quick Prescription
**Scenario:** Simple prescription for minor ailment without full consultation.

**Solution:**
1. Open E-Prescription
2. Search for patient
3. Add medications
4. Save

---

## Technical Details

### Routes
```php
GET  /doctor/e-prescription                          # Main page
GET  /doctor/e-prescription/search                   # Patient search
GET  /doctor/e-prescription/patient/{patient}        # Patient details
POST /doctor/e-prescription/create                   # Save prescription
POST /doctor/e-prescription/consultation/{id}/update # Update existing
```

### Controller
`app/Http/Controllers/Doctor/EPrescriptionController.php`

### View
`resources/views/doctor/e-prescription/index.blade.php`

### Data Storage
- Prescriptions are stored as JSON in `consultations` table
- Creates a simple consultation record with:
  - `chief_complaint`: "Prescription Only"
  - `status`: "completed"
  - `prescriptions`: JSON array of medications

---

## Safety Features

### Allergy Warnings
- **Prominent display** with red background
- **Color-coded severity:**
  - 🔴 Severe - Red badge
  - 🟠 Moderate - Orange badge
  - 🟡 Mild - Yellow badge

### Active Conditions
- Displayed in blue section
- Shows current medical conditions
- Helps inform prescription decisions

### Current Medications
- Displayed in purple section
- Shows ongoing medications
- Helps avoid drug interactions

---

## Benefits

1. **Time-Saving** - No need to redo full consultation
2. **Safety** - Allergy warnings before prescribing
3. **Flexibility** - Modify prescriptions easily
4. **Efficiency** - Repeat Script feature
5. **Convenience** - Standalone tool for quick prescriptions
6. **Patient Safety** - All medical history visible

---

## Tips

1. **Always check allergies** before prescribing
2. **Use Repeat Script** for recurring prescriptions
3. **Review current medications** to avoid interactions
4. **Fill all required fields** for complete records
5. **Add additional instructions** for clarity

---

## Integration

The E-Prescription module integrates with:
- **Patient Records** - Accesses patient information
- **Consultation System** - Creates consultation records
- **Medical History** - Displays allergies, conditions, medications
- **Reports** - Prescriptions appear in prescription reports

---

## Future Enhancements

Potential improvements:
- Drug interaction checking
- Medication database integration
- Prescription templates
- Print prescription directly
- Email prescription to patient
- Medication cost calculator

---

**Last Updated:** January 5, 2026  
**Version:** 1.0.0
