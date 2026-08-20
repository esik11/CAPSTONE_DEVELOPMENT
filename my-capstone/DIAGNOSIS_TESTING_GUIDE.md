# 🔍 Diagnosis & Prescribe - Testing Guide

## ✅ What We've Built

### **Diagnosis Tab Features:**
1. ✅ ICD-10 code search (live search with debounce)
2. ✅ Add/remove diagnoses
3. ✅ Primary diagnosis selection
4. ✅ Additional clinical notes
5. ✅ Auto-save every 30 seconds
6. ✅ Manual save draft button
7. ✅ Navigation between tabs
8. ✅ Complete consultation button

### **Database:**
- ✅ 32 ICD-10 codes seeded
- ✅ Migration for diagnoses, prescriptions, diagnosis_notes
- ✅ JSON storage for diagnoses array

---

## 🧪 Testing Steps

### **Step 1: Access a Consultation**
1. Login as a doctor
2. Go to **Patients** page
3. Click on any patient
4. Click **"Start Consult"** button
5. Navigate through: **Symptoms → Examination → Diagnosis & Prescribe**

### **Step 2: Test ICD-10 Search**

**Test Case 1: Search by Disease Name**
- Type: `bronch`
- Expected: Should show "J20.9: Acute bronchitis, unspecified"
- Click to add it

**Test Case 2: Search by Code**
- Type: `J20`
- Expected: Should show all bronchitis codes
- Click to add one

**Test Case 3: Search Common Conditions**
- Type: `fever` → Should show "R50.9: Fever, unspecified"
- Type: `hyper` → Should show "I10: Essential hypertension"
- Type: `diabetes` → Should show "E11.9: Type 2 diabetes mellitus"

**Test Case 4: Minimum Characters**
- Type: `a` (1 character)
- Expected: No results (requires 2+ characters)
- Type: `ab` (2 characters)
- Expected: Shows results if any match

### **Step 3: Test Adding Diagnoses**

**Test Case 1: Add First Diagnosis**
- Search and add "J20.9: Acute bronchitis"
- Expected: 
  - Appears in "Selected Diagnoses" section
  - Has ⭐ (star) icon
  - Shows "(Primary Diagnosis)" label
  - Search box clears automatically

**Test Case 2: Add Multiple Diagnoses**
- Add "R50.9: Fever, unspecified"
- Add "J06.9: Acute upper respiratory infection"
- Expected:
  - All appear in list
  - Only first one has ⭐ (primary)
  - Counter shows "Selected Diagnoses (3)"

**Test Case 3: Prevent Duplicates**
- Try to add "J20.9" again
- Expected: Should not add duplicate

### **Step 4: Test Primary Diagnosis**

**Test Case 1: Change Primary**
- Click "Set as Primary" on the second diagnosis
- Expected:
  - ⭐ moves to second diagnosis
  - First diagnosis loses ⭐
  - "(Primary Diagnosis)" label moves

**Test Case 2: Remove Primary**
- Remove the primary diagnosis
- Expected:
  - First remaining diagnosis becomes primary automatically
  - ⭐ appears on new primary

### **Step 5: Test Remove Diagnosis**

**Test Case 1: Remove Non-Primary**
- Click "Remove" on a non-primary diagnosis
- Expected: Diagnosis removed from list

**Test Case 2: Remove Primary**
- Click "Remove" on primary diagnosis
- Expected:
  - Diagnosis removed
  - Next diagnosis becomes primary

**Test Case 3: Remove All**
- Remove all diagnoses
- Expected: Shows "No diagnoses added yet" message

### **Step 6: Test Clinical Notes**

**Test Case 1: Add Notes**
- Type in "Additional Clinical Notes" textarea
- Type: "Patient presents with productive cough for 3 days"
- Click outside the textarea (blur event)
- Expected: Notes saved

### **Step 7: Test Auto-Save**

**Test Case 1: Auto-Save Timer**
- Add a diagnosis
- Wait 30 seconds
- Expected: 
  - "Last saved: HH:MM:SS" appears at bottom
  - Green flash on save indicator

**Test Case 2: Manual Save**
- Add a diagnosis
- Click "Save Draft" button
- Expected:
  - Saves immediately
  - Shows "Last saved" timestamp

### **Step 8: Test Navigation**

**Test Case 1: Back to Examination**
- Click "← Back to Examination"
- Expected:
  - Saves current data
  - Navigates to Examination tab
  - Data persists when returning

**Test Case 2: Tab Navigation**
- Click "Symptoms" tab at top
- Expected:
  - Saves current data
  - Switches to Symptoms tab

### **Step 9: Test Complete Consultation**

**Test Case 1: Complete with Diagnoses**
- Add at least one diagnosis
- Click "Complete Consultation ✓"
- Expected:
  - Saves all data
  -