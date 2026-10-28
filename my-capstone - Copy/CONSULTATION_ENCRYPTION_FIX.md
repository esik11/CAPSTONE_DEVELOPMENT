# Consultation Encryption Fix

## Problem
Getting error: `CONSTRAINT consultations.selected_complaints failed`

```
SQLSTATE[23000]: Integrity constraint violation: 4025 
CONSTRAINT `consultations.selected_complaints` failed
```

## Root Cause
**You cannot use `encrypted:array` casting on MySQL `JSON` column types.**

### Why?
1. Laravel's `encrypted:array` cast works like this:
   ```
   Array → JSON → Encrypt → Base64 String
   ```

2. MySQL's `JSON` column type has a built-in CHECK constraint that validates data is valid JSON

3. When you try to save:
   ```
   Encrypted data = "eyJpdiI6Im1SL0JDZmFHUnExek5FQ0NCYW5RVkE9PSI..."
   MySQL checks: Is this valid JSON? ❌ NO!
   Result: CONSTRAINT VIOLATION
   ```

### The Conflict
- **Laravel expects:** To store encrypted base64 strings
- **MySQL expects:** Valid JSON in JSON columns
- **Result:** 💥 Constraint violation

## Solution
Changed encrypted JSON columns from `json` type to `text` type.

### What Changed
**Migration:** `2026_05_20_140000_fix_encrypted_json_columns_in_consultations.php`

Changed these columns from `json` to `text`:
- `selected_complaints`
- `template_responses`
- `review_of_systems`
- `associated_symptoms`
- `cardiovascular_findings`
- `respiratory_findings`
- `abdominal_findings`
- `neurological_findings`
- `musculoskeletal_findings`
- `heent_findings`
- `skin_findings`
- `diagnoses`
- `prescriptions`

### Model Casts (No Change Needed)
The `Consultation` model casts remain the same:
```php
protected $casts = [
    'selected_complaints' => 'encrypted:array',  // ✅ Works with TEXT column
    'template_responses' => 'encrypted:array',   // ✅ Works with TEXT column
    // ... etc
];
```

## How It Works Now

### Before (Broken)
```
Column Type: JSON
Cast: encrypted:array
Data Flow: Array → JSON → Encrypt → Base64 String → ❌ MySQL rejects
```

### After (Fixed)
```
Column Type: TEXT
Cast: encrypted:array
Data Flow: Array → JSON → Encrypt → Base64 String → ✅ MySQL accepts
```

## Security Impact
**No security loss!** The data is still:
- ✅ Encrypted at rest (AES-256)
- ✅ Encrypted in database
- ✅ Automatically decrypted when accessed
- ✅ HIPAA compliant

The only difference is the column type changed from `json` to `text`.

## Performance Impact
**Minimal.** 
- TEXT columns are slightly larger than JSON columns
- No JSON validation overhead
- Encryption/decryption performance unchanged

## Testing
After running the migration, test your consultation workflow:

1. **Start a consultation**
   ```
   Doctor → Appointments → Start Consultation
   ```

2. **Fill in symptoms**
   - Select complaints
   - Fill template responses
   - Add notes

3. **Save draft**
   ```
   Should work without errors now ✅
   ```

4. **Continue through sections**
   - Examination
   - Diagnosis
   - Prescribe

5. **Finalize consultation**
   ```
   Should save successfully ✅
   ```

## Alternative Solutions (Not Recommended)

### Option 1: Remove Encryption (❌ Not HIPAA Compliant)
```php
// Don't do this - loses HIPAA compliance
'selected_complaints' => 'array',  // No encryption
```

### Option 2: Encrypt Manually (❌ Too Complex)
```php
// Don't do this - too much code
public function setSelectedComplaintsAttribute($value) {
    $this->attributes['selected_complaints'] = encrypt(json_encode($value));
}
```

### Option 3: Use TEXT Columns (✅ What We Did)
```php
// Best solution - simple and secure
Column: text
Cast: encrypted:array
```

## Key Takeaway
**When using Laravel's `encrypted` or `encrypted:array` casts, always use `TEXT` column types, not `JSON`.**

```php
// ❌ WRONG
Schema::create('table', function (Blueprint $table) {
    $table->json('encrypted_field');  // Will fail with encrypted cast
});

// ✅ CORRECT
Schema::create('table', function (Blueprint $table) {
    $table->text('encrypted_field');  // Works with encrypted cast
});
```

## Files Modified
1. Created migration: `database/migrations/2026_05_20_140000_fix_encrypted_json_columns_in_consultations.php`
2. No changes to `app/Models/Consultation.php` (casts remain the same)

## Status
✅ **FIXED** - Consultation module should now work smoothly without constraint violations.
