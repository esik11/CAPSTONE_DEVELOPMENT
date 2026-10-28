# 🗑️ Telemedicine Module Removal Plan

**Date:** May 12, 2026  
**Reason:** Panelist feedback - Small clinics don't need telemedicine functionality  
**Status:** 🔄 IN PROGRESS

---

## 📋 Analysis Summary

### **What We Found:**

1. **Database Fields:**
   - `appointments.appointment_mode` - ENUM includes 'telemedicine' and 'online'
   - NO separate `telemedicine_sessions` table (good!)
   - NO `appointment_type` field (mentioned in docs but doesn't exist)

2. **Backend References:**
   - `app/Models/Billing.php` - Checks for telemedicine appointments
   - `app/Http/Controllers/Doctor/BillingController.php` - Different fees for telemedicine
   - `app/Http/Controllers/Patient/AppointmentController.php` - Validates appointment_mode

3. **Frontend References:**
   - Patient appointment booking form - Has telemedicine option
   - Various documentation files

4. **Documentation:**
   - DATA_DICTIONARY.md mentions telemedicine
   - DFD documents mention telemedicine
   - Multiple guide files

---

## 🎯 Removal Strategy (UPDATED)

### **What to KEEP:**
✅ `consultation_mode` field in consultations table
   - Used to mark if consultation was "in-clinic" or "online"
   - "Online" means conducted outside system (phone call, video call, etc.)
   - Just a tracking field, not actual telemedicine functionality

✅ **"Online" option in appointment_mode**
   - Patients can still request "online" appointments
   - These are handled outside the system (phone/video call)
   - Doctor marks consultation as "online" in consultation_mode field
   - NO built-in video conferencing or telemedicine features

### **What to REMOVE:**
❌ The word "telemedicine" from all code and documentation
❌ Any references to built-in telemedicine functionality
❌ Telemedicine-specific pricing logic (use same fee for all)
❌ Any implication that system has video conferencing
❌ Telemedicine sessions table references (doesn't exist anyway)

---

## 📝 Step-by-Step Removal Plan

### **Phase 1: Database Changes** ✅ NO CHANGES NEEDED

**Good News:** The database structure is already correct!

- `appointment_mode` enum has: 'in-clinic', 'telemedicine', 'online', 'walk-in', 'follow-up'
- We'll keep 'online' and remove only 'telemedicine'
- `consultation_mode` field already exists and is correct

#### Step 1.1: Update appointment_mode enum
**File:** Create new migration
**Action:** Remove only 'telemedicine' from enum, keep 'online'

**Current values:**
```sql
ENUM('in-clinic', 'telemedicine', 'online', 'walk-in', 'follow-up')
```

**New values:**
```sql
ENUM('in-clinic', 'online', 'walk-in', 'follow-up')
```

**Migration needed:** YES
**Data migration:** Update existing 'telemedicine' appointments to 'online'

```sql
-- Update existing telemedicine appointments to online
UPDATE appointments 
SET appointment_mode = 'online' 
WHERE appointment_mode = 'telemedicine';
```

---

### **Phase 2: Backend Changes** ⏳ PENDING

#### Step 2.1: Update Billing Model
**File:** `app/Models/Billing.php`
**Action:** Remove telemedicine-specific pricing, use same fee for all
**Lines:** 69-71

**Current:**
```php
if ($consultation->appointment && $consultation->appointment->appointment_type === 'telemedicine') {
    return 400.00;
}
```

**Change to:** Remove this check entirely - use single consultation fee for all appointment types (in-clinic, online, walk-in, follow-up)

---

#### Step 2.2: Update BillingController
**File:** `app/Http/Controllers/Doctor/BillingController.php`
**Action:** Remove telemedicine-specific pricing, use same fee for all
**Lines:** 32-34, 78-85

**Current:**
```php
if ($consultation->appointment && $consultation->appointment->appointment_type === 'telemedicine') {
    $consultationFee = 400;
}
```

**Change to:** Remove telemedicine checks, use single consultation fee (500) for all appointment types

**Current description:**
```php
'description' => 'Consultation Fee (' . ($consultation->appointment && $consultation->appointment->appointment_type === 'telemedicine' ? 'Telemedicine' : 'Walk-in') . ')',
```

**Change to:**
```php
'description' => 'Consultation Fee (' . ($consultation->appointment ? ucfirst($consultation->appointment->appointment_mode) : 'Walk-in') . ')',
```

This will show: "Consultation Fee (In-clinic)", "Consultation Fee (Online)", "Consultation Fee (Walk-in)", etc.

---

#### Step 2.3: Update Patient AppointmentController
**File:** `app/Http/Controllers/Patient/AppointmentController.php`
**Action:** Update validation rules to remove 'telemedicine', keep 'online'
**Line:** 44

**Current:**
```php
'appointment_mode' => 'required|in:in-clinic,telemedicine',
```

**Change to:**
```php
'appointment_mode' => 'required|in:in-clinic,online,walk-in,follow-up',
```

**Note:** This allows patients to request "online" appointments (handled outside system)

---

### **Phase 3: Frontend Changes** ⏳ PENDING

#### Step 3.1: Update Appointment Booking Form
**File:** `resources/views/patient/appointments/create.blade.php` (or similar)
**Action:** Change "Telemedicine" label to "Online"
**Keep options:** In-Clinic, Online, Walk-in, Follow-up

**Change:**
- "Telemedicine" → "Online"
- Update description: "Request online consultation (via phone/video call outside system)"

---

#### Step 3.2: Update Appointment Display Views
**Files:** Various appointment list/show views
**Action:** Change "Telemedicine" labels to "Online"
**Keep:** Online badge/label displays (just rename from "Telemedicine" to "Online")

---

### **Phase 4: Documentation Updates** ⏳ PENDING

#### Step 4.1: Update DATA_DICTIONARY.md
**Action:** 
- Remove telemedicine_sessions table documentation (doesn't exist)
- Update appointments table description
- Change "telemedicine" references to "online"
- Clarify that "online" appointments are handled outside system

#### Step 4.2: Update DFD Documents
**Action:** Change "Telemedicine Consultation" to "Consultation Management"
**Clarify:** System handles in-clinic and online consultations (online = outside system)
**Files:**
- DFD_LEVEL0_CONSISTENCY_ANALYSIS.md
- DFD_LEVEL1_COMPLETE_ANALYSIS.md

#### Step 4.3: Update Other Documentation
**Action:** Replace "telemedicine" with "online" where appropriate
**Clarify:** No built-in video conferencing, online consultations handled externally
**Files:**
- FLOWCHART_DFD_QUICK_REFERENCE.md
- NOTIFICATION_SYSTEM_GUIDE.md
- E_PRESCRIPTION_REAL_WORLD_SCENARIO.md
- file.txt
- APPOINTMENT_BOOKING_TEST_CHECKLIST.md

---

## ⚠️ Important Notes

### **DO NOT Remove:**
1. ✅ `consultation_mode` field in consultations table
   - This is for tracking purposes only
   - Values: 'in-clinic' or 'online'
   - "Online" means consultation happened outside system

2. ✅ Appointment booking functionality
   - Keep the appointment system
   - Just remove telemedicine as an option

3. ✅ Consultation workflow
   - Keep SOAP format consultations
   - Keep all consultation features

### **Data Migration Strategy:**
When updating the enum, we need to handle existing data:
```sql
-- Update existing telemedicine appointments to online
UPDATE appointments 
SET appointment_mode = 'online' 
WHERE appointment_mode = 'telemedicine';
```

**Note:** We're keeping 'online' as a valid option, just removing 'telemedicine' terminology

---

## 🧪 Testing After Removal

### **Test Cases:**
- [ ] Create new appointment (should only show in-clinic/walk-in/follow-up)
- [ ] View existing appointments (should display correctly)
- [ ] Create billing (should use single consultation fee)
- [ ] View billing (should not show telemedicine pricing)
- [ ] System still works without errors
- [ ] No broken references in code

---

## 📊 Progress Tracker

### **Phase 1: Database** 🔄 IN PROGRESS
- [ ] Create migration to update appointment_mode enum
- [ ] Migrate existing data
- [ ] Run migration
- [ ] Verify database updated

### **Phase 2: Backend** ⏳ PENDING
- [ ] Update Billing model
- [ ] Update BillingController
- [ ] Update Patient AppointmentController
- [ ] Run diagnostics

### **Phase 3: Frontend** ⏳ PENDING
- [ ] Update appointment booking form
- [ ] Update appointment display views
- [ ] Test UI changes

### **Phase 4: Documentation** ⏳ PENDING
- [ ] Update DATA_DICTIONARY.md
- [ ] Update DFD documents
- [ ] Update other documentation files

---

## 🎯 Current Status

**Starting with:** Phase 1 - Database Changes
**Next:** Create migration to update appointment_mode enum

---

**Last Updated:** May 12, 2026  
**Status:** 🔄 **IN PROGRESS - Phase 1**
