# Billing & Payment System Proposal

## Current Manual Process (Without System)

### How Clinics Handle Billing Manually:

**Step 1: Patient Arrives**
- Patient checks in at reception
- Receptionist writes name in logbook

**Step 2: Consultation**
- Doctor sees patient
- Doctor writes consultation notes on paper
- Doctor writes prescription on prescription pad

**Step 3: Payment (Manual)**
- Patient goes to cashier/reception
- Staff manually writes receipt:
  - Patient name
  - Date
  - Service: "Consultation Fee"
  - Amount: ₱500
  - Payment method: Cash
- Staff gives handwritten receipt
- Staff records in cashbook/ledger

**Step 4: End of Day**
- Staff counts cash
- Staff tallies receipts
- Staff records in accounting book
- Manual reconciliation

**Problems with Manual System:**
- ❌ Lost receipts (no backup)
- ❌ Calculation errors
- ❌ Hard to track who paid/didn't pay
- ❌ Time-consuming end-of-day reconciliation
- ❌ Difficult to generate reports
- ❌ No payment history tracking
- ❌ Paper receipts fade/get damaged

---

## Proposed System: Integrated Billing

### Approach: Add Payment Tracking to Consultation Module

**Why This Approach?**
- Your scope: "Tracks consultation fees and payment records"
- Simple: Only tracking consultation payments (not complex billing)
- Efficient: Payment recorded when consultation is finalized

### How It Works:

**Step 1: Doctor Completes Consultation**
- Doctor fills out SOAP notes in system
- Doctor prescribes medications
- Doctor clicks "Finalize & Sign Consultation"

**Step 2: Payment Modal Appears**
```
┌─────────────────────────────────────┐
│     CONSULTATION PAYMENT            │
├─────────────────────────────────────┤
│ Patient: Juan Dela Cruz             │
│ Date: December 10, 2025             │
│                                     │
│ Consultation Fee: ₱500              │
│                                     │
│ Payment Method:                     │
│ ○ Cash  ○ Card  ○ GCash  ○ PayMaya │
│                                     │
│ Amount Paid: [₱500]                 │
│                                     │
│ [Cancel]  [Record Payment]          │
└─────────────────────────────────────┘
```

**Step 3: System Records Payment**
- Payment saved in consultation record
- Receipt number auto-generated (REC-2025-001)
- Payment status updated to "Paid"

**Step 4: Receipt Generated**
- System generates digital receipt (PDF)
- Can be printed or emailed to patient
- Stored in system (never lost)

**Step 5: Reports Available**
- Daily sales report (automatic)
- Payment history per patient
- Monthly revenue reports
- No manual counting needed

---

## What Gets Stored:

**In Consultations Table:**
```
Existing Fields:
- Patient info
- Doctor info
- SOAP notes
- Prescriptions
- Diagnosis

NEW Payment Fields:
- consultation_fee (₱500)
- payment_status (paid/unpaid)
- amount_paid (₱500)
- payment_method (cash/card/gcash)
- payment_date (2025-12-10)
- receipt_number (REC-2025-001)
```

---

## Benefits vs Manual System:

| Feature | Manual System | Proposed System |
|---------|---------------|-----------------|
| Receipt Generation | Handwritten | Auto-generated PDF |
| Payment Tracking | Paper logbook | Digital database |
| Lost Receipts | Common problem | Never lost (digital) |
| Daily Reports | Manual counting | Automatic reports |
| Payment History | Hard to find | One click to view |
| Errors | Common | Minimal |
| Time to Process | 5-10 minutes | 30 seconds |

---

## What Client Needs to Decide:

### Option 1: Integrated Billing (Recommended)
**Complexity:** Simple (3 hours work)
**Best for:** Clinics that only charge consultation fees

**Features:**
- ✅ Track consultation payments
- ✅ Generate receipts
- ✅ Payment history
- ✅ Basic reports
- ❌ Can't bill medications separately
- ❌ Can't handle partial payments

### Option 2: Full Billing Module
**Complexity:** Complex (15 hours work)
**Best for:** Clinics that sell medications, do procedures, lab tests

**Features:**
- ✅ Multiple billing items (consultation + meds + procedures)
- ✅ Partial payments
- ✅ Invoicing
- ✅ Advanced reports
- ✅ Separate billing interface
- ⚠️ More complex to use

---

## Questions for Client:

1. **Do you only charge consultation fees?**
   - YES → Use Option 1 (Integrated)
   - NO → Use Option 2 (Full Module)

2. **Do you sell medications at the clinic?**
   - YES → Consider Option 2
   - NO → Option 1 is fine

3. **Do you need to bill for multiple services in one visit?**
   (Example: Consultation + Lab Test + Medication)
   - YES → Use Option 2
   - NO → Option 1 is fine

4. **Do patients sometimes pay partially?**
   (Example: Pay ₱300 today, ₱200 next week)
   - YES → Use Option 2
   - NO → Option 1 is fine

5. **Do you need separate billing staff/cashier interface?**
   - YES → Use Option 2
   - NO → Option 1 is fine

---

## Recommendation:

**Start with Option 1 (Integrated Billing)**

**Reasons:**
1. Your scope says "tracks consultation fees" (simple)
2. Faster to implement (3 hours vs 15 hours)
3. Easier to use
4. Can upgrade to Option 2 later if needed
5. Matches your DFD data flows

**You can always expand later if:**
- Clinic starts selling medications
- Need to bill for procedures/lab tests
- Need more complex billing features

---

## Implementation Timeline:

**Option 1: Integrated Billing**
- Database changes: 30 minutes
- Payment modal: 1 hour
- Receipt PDF: 1 hour
- Testing: 30 minutes
- **Total: 3 hours**

**Option 2: Full Billing Module**
- Database design: 2 hours
- Billing interface: 5 hours
- Payment processing: 3 hours
- Reports: 3 hours
- Testing: 2 hours
- **Total: 15 hours**

---

## Next Steps:

1. Discuss with client which option fits their needs
2. Confirm if they only charge consultation fees
3. Decide on payment methods to support (cash, card, GCash, etc.)
4. Confirm receipt format requirements
5. Proceed with implementation

---

**Prepared by:** Development Team  
**Date:** December 10, 2025  
**For:** Client Discussion - Billing System Requirements
