# Patient Appointment Booking Guide

## ✅ COMPLETED

### Patient Appointments Module

**Files Created:**
1. `resources/views/patient/appointments/index.blade.php` - List all appointments
2. `resources/views/patient/appointments/create.blade.php` - Book new appointment form
3. `resources/views/patient/dashboard.blade.php` - Patient dashboard

**Files Updated:**
1. `app/Http/Controllers/Patient/AppointmentController.php` - Updated validation rules

---

## 📋 BOOKING FORM FIELDS

**Doctor Selection:**
- Radio buttons showing all doctors
- Displays doctor name and email

**Appointment Details:**
- **Date:** Calendar picker (today onwards)
- **Time:** Dropdown with 30-min slots (8:00 AM - 5:30 PM)
- **Type:** In-Clinic or Telemedicine
- **Urgency:** Routine, Urgent, Emergency
- **Reason:** Text area (minimum 10 characters)

**Consent:**
- Checkbox to agree to terms

---

## 🔄 WORKFLOW

### 1. Patient Books Appointment
```
Patient fills form → Submits → Status: PENDING
```

**Data saved:**
```php
[
    'patient_id' => current_patient_id,
    'doctor_id' => selected_doctor,
    'start_time' => '2025-12-07 10:00:00',
    'end_time' => '2025-12-07 10:30:00',
    'reason' => 'Fever and cough',
    'status' => 'pending',
    'appointment_mode' => 'in-clinic',
    'urgency_priority' => 'routine',
]
```

### 2. Doctor Sees Request
- Appointment appears in doctor's "Upcoming" section
- Status: PENDING (yellow badge)
- Doctor can: Approve, Decline, or Reschedule

### 3. Doctor Approves
- Status changes to: CONFIRMED
- Patient receives notification
- Appointment shows in patient's "Confirmed" filter

### 4. Patient Arrives
- Doctor clicks "Check In"
- Status: CHECKED_IN

### 5. Consultation Starts
- Doctor clicks "Start Consultation"
- Status: IN_PROGRESS
- Opens consultation module

### 6. Consultation Ends
- Doctor completes SOAP documentation
- Status: COMPLETED

---

## 🎨 FEATURES

**Patient Appointments Page:**
- ✅ Filter tabs (All, Upcoming, Pending, Confirmed, Completed, Cancelled)
- ✅ Color-coded status badges
- ✅ View appointment details
- ✅ Cancel appointments (if pending/confirmed)
- ✅ Empty state with "Book Appointment" button

**Book Appointment Form:**
- ✅ Doctor selection with radio buttons
- ✅ Date picker (future dates only)
- ✅ Time slots (30-minute intervals)
- ✅ Appointment type selection
- ✅ Urgency level
- ✅ Reason for visit (required, min 10 chars)
- ✅ Consent checkbox
- ✅ Form validation
- ✅ Error messages

---

## 🧪 TESTING STEPS

### Test 1: Book Appointment
1. Log in as patient
2. Go to Appointments page
3. Click "Book Appointment"
4. Fill out form:
   - Select doctor
   - Choose date (tomorrow)
   - Select time (10:00 AM)
   - Type: In-Clinic
   - Urgency: Routine
   - Reason: "Fever and cough for 3 days"
   - Check consent
5. Click "Book Appointment"
6. Should redirect to appointments list
7. New appointment should show with "Pending" status

### Test 2: Doctor Approves
1. Log out patient
2. Log in as doctor
3. Go to Appointments page
4. See new appointment in "Upcoming" section
5. Click "Approve"
6. Status changes to "Confirmed"

### Test 3: Patient Views Confirmed
1. Log out doctor
2. Log in as patient
3. Go to Appointments
4. Click "Confirmed" filter
5. See approved appointment

### Test 4: Cancel Appointment
1. As patient, click "Cancel" on pending/confirmed appointment
2. Confirm cancellation
3. Status changes to "Cancelled"

---

## 📊 STATUS FLOW

```
PENDING (Patient books)
   ↓
CONFIRMED (Doctor approves)
   ↓
CHECKED_IN (Patient arrives)
   ↓
IN_PROGRESS (Consultation starts)
   ↓
COMPLETED (Consultation ends)
```

**Alternative paths:**
- PENDING → DECLINED (Doctor declines)
- PENDING/CONFIRMED → CANCELLED (Patient cancels)

---

## 🎯 VALIDATION RULES

- **doctor_id:** Required, must exist in users table
- **appointment_date:** Required, must be today or future date
- **appointment_time:** Required, format HH:MM
- **symptoms_complaint:** Required, minimum 10 characters
- **appointment_mode:** Required, must be 'in-clinic' or 'telemedicine'
- **urgency_priority:** Required, must be 'routine', 'urgent', or 'emergency'
- **consent:** Required, must be checked

---

## ✅ READY FOR TESTING

The patient appointment booking system is now complete and ready to test the full workflow from patient booking to doctor approval!
