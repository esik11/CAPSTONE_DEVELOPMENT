# Appointment Booking Test Checklist

## Pre-Test Setup
- [ ] Ensure you're logged in as a patient user
- [ ] Clear browser cache if needed
- [ ] Check Laravel logs: `storage/logs/laravel.log`

## Test Steps

### 1. Navigate to Booking Page
- [ ] Go to `/patient/appointments`
- [ ] Click "Book Appointment" button
- [ ] Verify you're on `/patient/appointments/create`

### 2. Fill Out Form

#### Step 1: Select Doctor
- [ ] Click on a doctor card
- [ ] Verify doctor card turns blue
- [ ] Verify "Doctor Info" section updates
- [ ] Check hidden field: `doctor_id` has value

#### Step 2: Pick Date & Time
- [ ] Click on a future date in calendar
- [ ] Verify date turns blue/selected
- [ ] Check hidden field: `appointment_date` has value (YYYY-MM-DD)
- [ ] Enter start time (e.g., 10:00)
- [ ] Enter end time (e.g., 11:00)
- [ ] Verify duration display appears
- [ ] Verify duration is calculated correctly

#### Step 3: Confirm Details
- [ ] Select appointment type (In-Clinic or Telemedicine)
- [ ] Verify selected button turns blue
- [ ] Select urgency level from dropdown
- [ ] Type symptoms (minimum 10 characters)
- [ ] Check the consent checkbox
- [ ] Verify submit button changes from gray to green
- [ ] Verify button text changes to "✓ Confirm Appointment"

### 3. Submit Form
- [ ] Click "✓ Confirm Appointment" button
- [ ] Wait for page to redirect

### 4. Verify Success
- [ ] Verify redirected to `/patient/appointments`
- [ ] Verify success message appears
- [ ] Verify new appointment appears in the list

### 5. Verify Database
```sql
SELECT * FROM appointments ORDER BY id DESC LIMIT 1;
```

Expected values:
- `patient_id`: Should match your patient ID
- `doctor_id`: Should match selected doctor
- `start_time`: Should be YYYY-MM-DD HH:MM:SS
- `end_time`: Should be YYYY-MM-DD HH:MM:SS
- `reason`: Should contain your symptoms text
- `appointment_mode`: Should be 'in-clinic' or 'telemedicine'
- `urgency_priority`: Should be 'routine', 'urgent', or 'emergency'
- `consent`: Should be 1 (true)
- `status`: Should be 'pending'
- `created_at`: Should be current timestamp
- `updated_at`: Should be current timestamp

## Troubleshooting

### If Form Doesn't Submit:
1. Open browser console (F12)
2. Check for JavaScript errors
3. Verify all required fields are filled
4. Check network tab for failed requests

### If Validation Errors Appear:
1. Read the error message
2. Check which field is causing the issue
3. Verify field format matches requirements

### If Database Record Not Created:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Look for error messages
3. Verify patient record exists
4. Check database connection

## Common Issues & Solutions

### Issue: "The consent field must be accepted"
**Solution**: Make sure consent checkbox is checked

### Issue: "The end time must be after start time"
**Solution**: Ensure end time is later than start time

### Issue: "The appointment date must be a date after or equal to today"
**Solution**: Select a future date, not a past date

### Issue: "The symptoms complaint must be at least 10 characters"
**Solution**: Write more detailed symptoms description

### Issue: No patient record
**Solution**: Controller will auto-create patient record if missing

## What Was Fixed

1. ✅ Added missing `consent` field to form
2. ✅ Added `consent` to appointment creation in controller
3. ✅ Updated JavaScript validation to check consent
4. ✅ Added error logging for debugging
5. ✅ Fixed `appointment_mode` enum values in database

## Expected Behavior

When everything works correctly:
1. Form validates all fields
2. Controller receives all data
3. Patient record is verified/created
4. Date and time are combined into DateTime objects
5. Appointment record is created in database
6. User is redirected with success message
7. Appointment appears in the list
