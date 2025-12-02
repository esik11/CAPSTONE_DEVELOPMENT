# 🚀 Quick Test Guide - Diagnosis Tab

## ⚡ 5-Minute Test

### **Step 1: Navigate to Diagnosis Tab**
```
1. Login as doctor
2. Go to any patient
3. Click "Start Consult"
4. Navigate: Symptoms → Examination → Diagnosis & Prescribe
```

### **Step 2: Test Search (30 seconds)**
```
Type "bronch" → Should show:
✅ J20.9: Acute bronchitis, unspecified

Click it → Should:
✅ Appear in "Selected Diagnoses"
✅ Have ⭐ (primary indicator)
✅ Clear search box
```

### **Step 3: Add More Diagnoses (1 minute)**
```
Search and add:
- "fever" → R50.9: Fever, unspecified
- "J06" → J06.9: Acute upper respiratory infection

Should show:
✅ Selected Diagnoses (3)
✅ Only first has ⭐
✅ Each has "Set as Primary" and "Remove" buttons
```

### **Step 4: Test Primary Selection (30 seconds)**
```
Click "Set as Primary" on second diagnosis

Should:
✅ ⭐ moves to second diagnosis
✅ "(Primary Diagnosis)" label moves
✅ First diagnosis now has "Set as Primary" button
```

### **Step 5: Test Remove (30 seconds)**
```
Click "Remove" on any diagnosis

Should:
✅ Diagnosis disappears
✅ Counter updates
✅ If removed primary, next becomes primary
```

### **Step 6: Test Notes (30 seconds)**
```
Type in "Additional Clinical Notes":
"Patient presents with productive cough for 3 days. 
No fever. Chest clear on auscultation."

Click outside textarea

Should:
✅ Text saved (blur event triggers save)
```

### **Step 7: Test Auto-Save (30 seconds)**
```
Wait 30 seconds (or click "Save Draft")

Should see:
✅ "Last saved: HH:MM:SS" at bottom
✅ Brief green flash on save
```

### **Step 8: Test Navigation (1 minute)**
```
Click "← Back to Examination"
Then click "Diagnosis & Prescribe" tab again

Should:
✅ All diagnoses still there
✅ Notes still there
✅ Primary selection preserved
```

### **Step 9: Test Complete (30 seconds)**
```
Click "Complete Consultation ✓"

Should:
✅ Save all data
✅ Mark consultation as completed
✅ Redirect to patient overview
✅ Show success message
```

---

## 🎯 Expected Results Summary

| Feature | Status |
|---------|--------|
| ICD-10 Search | ✅ Working |
| Add Diagnosis | ✅ Working |
| Remove Diagnosis | ✅ Working |
| Primary Selection | ✅ Working |
| Prevent Duplicates | ✅ Working |
| Clinical Notes | ✅ Working |
| Auto-Save (30s) | ✅ Working |
| Manual Save | ✅ Working |
| Navigation | ✅ Working |
| Data Persistence | ✅ Working |
| Complete Consultation | ✅ Working |

---

## 🔍 Sample Search Terms

| Search | Expected Result |
|--------|----------------|
| `bronch` | J20.9: Acute bronchitis |
| `fever` | R50.9: Fever, unspecified |
| `hyper` | I10: Essential hypertension |
| `diabetes` | E11.9: Type 2 diabetes mellitus |
| `J20` | All bronchitis codes |
| `cold` | J00: Acute nasopharyngitis |
| `gastro` | K21.9: Gastro-esophageal reflux |

---

## ✅ All Tests Passed?

If all tests pass, the Diagnosis tab is **fully functional** and ready for production use!

**Next:** Implement the Medicine tab for prescriptions.
