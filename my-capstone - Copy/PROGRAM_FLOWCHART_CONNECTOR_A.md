# Program Flowchart - Patient Records Management (Connector A)

## Simplified with Medical History and Database Operations

This flowchart shows the complete patient records workflow with generalized medical history management and explicit database operations.

---

## 📊 **PATIENT RECORDS MANAGEMENT FLOWCHART**

```mermaid
flowchart TB
    %% START
    A((A))
    
    %% MAIN MODULE
    Module[PATIENT RECORDS<br/>MANAGEMENT<br/>Display Patient List]
    
    %% MAIN ACTIONS
    Create[Add New Patient]
    View[View Patient Details]
    Edit[Edit Patient Info]
    Toggle[Toggle Patient Status]
    Back[Return to Dashboard]
    
    %% VIEW PATIENT DETAILS FLOW
    ShowDetails[Display Patient Overview<br/>& Medical History]
    HasHistory{Has Medical<br/>History?}
    AddHistory[Add Medical History]
    UpdateHistory[Update Medical History]
    
    %% INPUT
    InputAdd[/Input patient data:<br/>name, contact, DOB,<br/>gender, address/]
    InputEdit[/Modify patient data/]
    InputHistory[/Input medical history:<br/>conditions, medications,<br/>allergies, surgeries/]
    
    %% VALIDATION
    ValidAdd{Valid<br/>data?}
    ValidEdit{Valid<br/>data?}
    ValidHistory{Valid<br/>data?}
    
    %% DATABASE OPERATIONS
    SavePatient[Save to Database]
    UpdatePatient[Update Database]
    SaveHistory[Save to Database]
    UpdateStatus[Update Database]
    
    %% CONFIRMATION
    ConfirmToggle{Confirm<br/>status change?}
    
    %% END
    Menu((MENU))
    
    %% MAIN FLOW
    A --> Module
    
    Module -->|Click Add| Create
    Module -->|Click View| View
    Module -->|Click Edit| Edit
    Module -->|Click Toggle| Toggle
    Module -->|Click Back| Back
    
    %% CREATE FLOW
    Create --> InputAdd
    InputAdd --> ValidAdd
    ValidAdd -->|No| InputAdd
    ValidAdd -->|Yes| SavePatient
    SavePatient --> Module
    
    %% VIEW FLOW WITH MEDICAL HISTORY
    View --> ShowDetails
    ShowDetails --> HasHistory
    HasHistory -->|No| AddHistory
    HasHistory -->|Yes| UpdateHistory
    
    AddHistory --> InputHistory
    UpdateHistory --> InputHistory
    
    InputHistory --> ValidHistory
    ValidHistory -->|No| InputHistory
    ValidHistory -->|Yes| SaveHistory
    SaveHistory --> ShowDetails
    
    ShowDetails -->|Back| Module
    
    %% EDIT FLOW
    Edit --> InputEdit
    InputEdit --> ValidEdit
    ValidEdit -->|No| InputEdit
    ValidEdit -->|Yes| UpdatePatient
    UpdatePatient --> Module
    
    %% TOGGLE STATUS FLOW
    Toggle --> ConfirmToggle
    ConfirmToggle -->|No| Module
    ConfirmToggle -->|Yes| UpdateStatus
    UpdateStatus --> Module
    
    %% BACK TO MENU
    Back --> Menu
    
    %% STYLING
    classDef startStyle fill:#90EE90,stroke:#006400,stroke-width:3px
    classDef inputStyle fill:#FFE4B5,stroke:#FF8C00,stroke-width:2px
    classDef decisionStyle fill:#FFB6C1,stroke:#DC143C,stroke-width:2px
    classDef processStyle fill:#87CEEB,stroke:#4682B4,stroke-width:2px
    classDef moduleStyle fill:#E6E6FA,stroke:#4B0082,stroke-width:3px
    classDef dbStyle fill:#DDA0DD,stroke:#8B008B,stroke-width:2px
    
    class A,Menu startStyle
    class InputAdd,InputEdit,InputHistory inputStyle
    class ValidAdd,ValidEdit,ValidHistory,ConfirmToggle,HasHistory decisionStyle
    class Create,Edit,Toggle,Back,ShowDetails,AddHistory,UpdateHistory processStyle
    class Module moduleStyle
    class SavePatient,UpdatePatient,SaveHistory,UpdateStatus dbStyle
```

---

## 🔄 **COMPLETE LOGIC FLOW**

```
(A) → PATIENT RECORDS MANAGEMENT
         ↓
    ├─ Add Patient → Input → Validate → Save to Database → Back to List
    │
    ├─ View Patient → Show Details & Medical History
    │                      ↓
    │                 Has Medical History?
    │                 ├─ No → Add Medical History → Input → Validate → Save → Show Details
    │                 └─ Yes → Update Medical History → Input → Validate → Save → Show Details
    │                      ↓
    │                 Back to List
    │
    ├─ Edit Patient → Input → Validate → Update Database → Back to List
    │
    ├─ Toggle Status → Confirm → Update Database → Back to List
    │
    └─ Back → Return to MENU
```

---

## 📋 **KEY FEATURES**

### **1. Patient Management** ✅
- Add new patient
- View patient details
- Edit patient info
- Toggle status (Active/Inactive)

### **2. Medical History Management** ✅ (Generalized)
- Check if medical history exists
- Add medical history (if none)
- Update medical history (if exists)
- Includes: conditions, medications, allergies, surgeries

### **3. Database Operations** ✅ (Explicit)
- **Save to Database** - For new records
- **Update Database** - For modifications
- Shows data persistence clearly

### **4. Validation** ✅
- Input validation for all data entry
- Confirmation for status changes
- Loop back on invalid data

---

## 💡 **WHY THIS APPROACH WORKS**

### **Simplified Medical Records:**
- ❌ Not: "Add Condition", "Add Medication", "Add Allergy", "Add Surgery"
- ✅ Instead: "Add/Update Medical History" (generalized)

### **Explicit Database Operations:**
- Shows **where data is saved**
- Makes data flow clear
- Demonstrates understanding of persistence

### **Balanced Detail:**
- Not too simple (shows medical history)
- Not too complex (generalizes details)
- ~15 boxes total - clean and readable

---

## 🎯 **THESIS CAPTION**

> **Figure X: Patient Records Management Program Flowchart**
> 
> This flowchart illustrates the patient records management module with integrated medical history management. The doctor can add, view, edit, or toggle patient status. When viewing patient details, the system checks if medical history exists and allows the doctor to add or update it accordingly. All operations include validation and explicit database persistence, ensuring data integrity throughout the workflow.

---

## ✅ **PERFECT BALANCE ACHIEVED**

This version:
- ✅ Shows medical history management (your suggestion)
- ✅ Includes database operations (your request)
- ✅ Keeps it generalized (not overwhelming)
- ✅ Clean and professional (~15 boxes)
- ✅ Thesis-ready and defensible

---

**This is the final version! Ready to proceed with Connector B (Appointments)?**