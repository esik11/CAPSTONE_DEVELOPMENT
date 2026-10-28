# Smart Templates - Real-World Workflow Example

## Scenario: Patient with Sore Throat

### Step 1: Doctor Starts Consultation
```
Doctor clicks: "Start Consult" button on patient overview page
System creates: New consultation record (status: draft)
System displays: Symptoms tab with complaint buttons
```

### Step 2: Doctor Selects Complaint
```
Doctor clicks: "Sore throat" button
System loads: Sore throat template
System displays: Relevant questions below the complaint buttons
```

**UI Now Shows:**
```
┌─────────────────────────────────────────────────────────┐
│ Complaint                                                │
│ [Sore throat] ← SELECTED (highlighted)                  │
│ [Fever] [Cough] [Headache] ... (other buttons)         │
│                                                          │
│ ─────────────────────────────────────────────────────   │
│                                                          │
│ Duration:                                                │
│ [3] days ▼                                              │
│                                                          │
│ Associated symptoms:                                     │
│ ☑ Fever                                                 │
│ ☑ Cough                                                 │
│ ☑ Difficulty swallowing                                │
│ ☐ Runny nose                                            │
│ ☐ Headache                                              │
│ ☑ Fatigue                                               │
│                                                          │
│ Severity:                                                │
│ ○ Mild  ● Moderate  ○ Severe                           │
│                                                          │
│ Aggravating factors:                                     │
│ [Swallowing, talking                    ]               │
│                                                          │
│ Relieving factors:                                       │
│ [Warm drinks, throat lozenges           ]               │
│                                                          │
│ ─────────────────────────────────────────────────────   │
│                                                          │
│ Symptom notes 📋                                        │
│ ┌───────────────────────────────────────────────────┐  │
│ │ P/C/O: Sore throat, tired.                        │  │
│ │                                                    │  │
│ │ Patient presents with sore throat for 3 days.    │  │
│ │ Associated symptoms include fever, cough,         │  │
│ │ difficulty swallowing, and fatigue. Severity is   │  │
│ │ moderate. Symptoms are aggravated by swallowing   │  │
│ │ and talking. Relieved by warm drinks and throat   │  │
│ │ lozenges.                                         │  │
│ └───────────────────────────────────────────────────┘  │
│                                                          │
│ [Continue to Examination →]                             │
└─────────────────────────────────────────────────────────┘
```

### Step 3: Doctor Reviews Auto-Generated Notes
```
System auto-generates: Clinical notes in real-time as checkboxes are clicked
Doctor can: Edit the generated text if needed
Doctor can: Add additional free-text notes
```

### Step 4: Doctor Continues to Next Section
```
Doctor clicks: "Continue to Examination" button
System saves: All symptom data
System navigates: To Examination tab
```

---

## Scenario: Complex Case - Multiple Complaints

### Step 1: Patient with Multiple Issues
```
Patient presents with: Cough, Fever, and Headache
Doctor selects: All three complaint buttons
```

### Step 2: System Merges Templates
```
System loads: Questions from all three templates
System organizes: Questions by relevance
System avoids: Duplicate questions (e.g., "Duration" asked once)
```

**UI Shows:**
```
┌─────────────────────────────────────────────────────────┐
│ Complaint                                                │
│ [Cough] [Fever] [Headache] ← ALL SELECTED              │
│                                                          │
│ ─────────────────────────────────────────────────────   │
│                                                          │
│ Duration:                                                │
│ [5] days ▼                                              │
│                                                          │
│ Cough:                                                   │
│ ● Productive  ○ Dry                                     │
│ ☐ Blood in sputum                                       │
│                                                          │
│ Fever:                                                   │
│ Temperature: [38.5] °C                                  │
│ Pattern: ● Continuous  ○ Intermittent                   │
│                                                          │
│ Headache:                                                │
│ Location: ● Frontal  ○ Temporal  ○ Occipital          │
│ Character: ● Throbbing  ○ Pressure  ○ Sharp           │
│                                                          │
│ Associated symptoms:                                     │
│ ☑ Fatigue                                               │
│ ☑ Body aches                                            │
│ ☑ Chills                                                │
│ ☐ Shortness of breath                                   │
│                                                          │
│ ─────────────────────────────────────────────────────   │
│                                                          │
│ Symptom notes 📋                                        │
│ ┌───────────────────────────────────────────────────┐  │
│ │ P/C/O: Cough, fever, headache.                    │  │
│ │                                                    │  │
│ │ Patient presents with productive cough, fever,    │  │
│ │ and frontal headache for 5 days. Temperature is   │  │
│ │ 38.5°C with continuous pattern. Headache is       │  │
│ │ throbbing in character. Associated symptoms       │  │
│ │ include fatigue, body aches, and chills.          │  │
│ │ Suggestive of upper respiratory tract infection.  │  │
│ └───────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

---

## Scenario: Free-Text Mode for Complex Case

### Step 1: Doctor Prefers Manual Entry
```
Doctor doesn't select: Any complaint button
Doctor types directly: In the symptom notes field
```

**UI Shows:**
```
┌─────────────────────────────────────────────────────────┐
│ Complaint                                                │
│ [Buttons available but none selected]                   │
│                                                          │
│ Please select a complaint or visit type for us to       │
│ provide you with customised questions.                   │
│                                                          │
│ OR type your notes directly below:                       │
│                                                          │
│ ─────────────────────────────────────────────────────   │
│                                                          │
│ Symptom notes 📋                                        │
│ ┌───────────────────────────────────────────────────┐  │
│ │ [Doctor types freely here...]                     │  │
│ │                                                    │  │
│ │ 45-year-old male presents with 2-week history of  │  │
│ │ progressive dyspnea on exertion. Initially able   │  │
│ │ to climb 2 flights of stairs, now SOB after 5     │  │
│ │ steps. Associated with orthopnea (3 pillows) and  │  │
│ │ PND. Denies chest pain, palpitations. Has ankle   │  │
│ │ swelling bilaterally, worse in evenings...        │  │
│ └───────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

---

## Scenario: Hybrid Mode - Template + Free-Text

### Step 1: Doctor Uses Template
```
Doctor selects: "Chest pain" complaint
System loads: Chest pain template
Doctor answers: Template questions
```

### Step 2: Doctor Adds Custom Notes
```
System generates: Basic clinical notes from template
Doctor adds: Additional context in free-text
```

**Final Notes:**
```
┌───────────────────────────────────────────────────────┐
│ P/C/O: Chest pain.                                    │
│                                                        │
│ [AUTO-GENERATED FROM TEMPLATE:]                       │
│ Patient presents with central chest pain for 2 hours. │
│ Character is crushing. Radiates to left arm. Severity │
│ is severe (8/10). Associated symptoms include         │
│ shortness of breath and diaphoresis.                  │
│                                                        │
│ [DOCTOR'S ADDITIONAL NOTES:]                          │
│ Pain started while mowing lawn. No relief with rest.  │
│ Patient appears anxious and diaphoretic. Wife called  │
│ ambulance. PMH significant for hypertension and       │
│ hyperlipidemia. Family history of MI (father at 55).  │
│ High suspicion for ACS.                               │
└───────────────────────────────────────────────────────┘
```

---

## Scenario: Pediatric Visit - Fever

### Step 1: Doctor Selects Pediatric Complaint
```
Patient: 2-year-old child
Doctor selects: "Fever" button (pediatric template loads)
```

**UI Shows Pediatric-Specific Questions:**
```
┌─────────────────────────────────────────────────────────┐
│ Complaint                                                │
│ [Fever] ← SELECTED                                      │
│                                                          │
│ ─────────────────────────────────────────────────────   │
│                                                          │
│ Temperature:                                             │
│ [39.2] °C                                               │
│                                                          │
│ Duration:                                                │
│ [2] days ▼                                              │
│                                                          │
│ Associated symptoms:                                     │
│ ☑ Cough                                                 │
│ ☑ Runny nose                                            │
│ ☐ Vomiting                                              │
│ ☐ Diarrhea                                              │
│ ☐ Rash                                                  │
│ ☐ Ear pain                                              │
│ ☐ Difficulty breathing                                  │
│ ☑ Decreased activity/lethargy                           │
│ ☑ Poor feeding                                          │
│                                                          │
│ Fever pattern:                                           │
│ ● Continuous  ○ Intermittent  ○ Night-time only        │
│                                                          │
│ Medications given:                                       │
│ ☑ Paracetamol                                           │
│ ☐ Ibuprofen                                             │
│ ☐ None                                                  │
│                                                          │
│ Response to medication:                                  │
│ ● Good  ○ Partial  ○ None                              │
│                                                          │
│ Hydration status:                                        │
│ ● Good (wet diapers, tears)                            │
│ ○ Reduced                                               │
│ ○ Concerning (dry, no tears)                           │
│                                                          │
│ ─────────────────────────────────────────────────────   │
│                                                          │
│ Symptom notes 📋                                        │
│ ┌───────────────────────────────────────────────────┐  │
│ │ P/C/O: Fever.                                      │  │
│ │                                                    │  │
│ │ 2-year-old child presents with fever of 39.2°C    │  │
│ │ for 2 days. Pattern is continuous. Associated     │  │
│ │ symptoms include cough, runny nose, decreased     │  │
│ │ activity, and poor feeding. Parents have given    │  │
│ │ paracetamol with good response. Hydration status  │  │
│ │ is good with wet diapers and tears present.       │  │
│ │ Likely viral upper respiratory tract infection.   │  │
│ └───────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────┘
```

---

## Key Features Demonstrated

✅ **Click-based documentation** - Faster than typing
✅ **Real-time note generation** - See notes as you work
✅ **Specialty-specific** - Pediatric vs adult templates
✅ **Flexible** - Can use templates, free-text, or both
✅ **Smart merging** - Multiple complaints handled intelligently
✅ **Editable** - Can modify auto-generated text
✅ **Complete** - Guided questions ensure nothing is missed
✅ **Professional** - Generates proper medical terminology

---

This is exactly what makes your EMR special! 🎯
