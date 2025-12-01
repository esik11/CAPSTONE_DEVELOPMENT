# Smart Complaint-Based Templates - Implementation Guide

## Overview

This guide explains how the smart template system works, providing complaint-specific questions that auto-generate clinical notes in real-time.

---

## User Flow

```
1. Doctor clicks "Start Consult"
   ↓
2. System shows: Complaint buttons + Visit type buttons
   ↓
3. Doctor selects complaint (e.g., "Sore throat")
   ↓
4. System loads template with relevant questions
   ↓
5. Doctor answers questions (checkboxes/dropdowns)
   ↓
6. System auto-generates symptom notes in real-time
   ↓
7. Doctor can edit/add to auto-generated notes
   ↓
8. Doctor clicks "Continue to Examination"
```

---

## UI Layout

```
┌─────────────────────────────────────────────────────────────────┐
│ Symptoms Tab | Examination | Diagnose & prescribe | Plan        │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│ Complaint                                                         │
│ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐         │
│ │Abdom │ │Anxiet│ │Back  │ │Body  │ │Chest │ │Cold/ │         │
│ │inal  │ │y     │ │pain  │ │system│ │pain  │ │Flu   │         │
│ │Pain  │ │      │ │      │ │s     │ │      │ │      │         │
│ └──────┘ └──────┘ └──────┘ └──────┘ └──────┘ └──────┘         │
│                                                                   │
│ ┌──────┐ ┌──────┐ ┌──────┐ ... (more complaints)               │
│ │Cough │ │Depres│ │Diarrh│                                      │
│ │      │ │sion  │ │ea    │                                      │
│ └──────┘ └──────┘ └──────┘                                      │
│                                                                   │
│ Visit type                                                        │
│ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐                            │
│ │COVID │ │Chroni│ │Genera│ │HIV   │                            │
│ │-19   │ │c f/u │ │l     │ │first │                            │
│ │      │ │Diabet│ │checku│ │visit │                            │
│ └──────┘ └──────┘ └──────┘ └──────┘                            │
│                                                                   │
│ Please select a complaint or visit type for us to provide        │
│ you with customised questions.                                    │
│                                                                   │
│ ─────────────────────────────────────────────────────────────   │
│                                                                   │
│ [When complaint selected, template questions appear here]        │
│                                                                   │
│ Symptom notes 📋                                                 │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ P/C/O Sore throat, tired.                                    │ │
│ │                                                              │ │
│ │ [Auto-generated text appears here as questions are answered]│ │
│ │                                                              │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## Example: Sore Throat Template

### When "Sore throat" is selected:

**Template Questions Displayed:**
```
Associated Symptoms:
☐ Fever
☐ Cough  
☐ Difficulty swallowing
☐ Runny nose
☐ Headache
☐ Fatigue

Duration:
[ ] days/weeks

Severity:
○ Mild  ○ Moderate  ○ Severe

Aggravating factors:
[ ] Free text field

Relieving factors:
[ ] Free text field
```

**Auto-Generated Notes (Real-time):**
```
P/C/O: Sore throat, tired.

Patient presents with sore throat for [X] days. Associated symptoms include fever, cough, and difficulty swallowing. Severity is moderate. Symptoms are aggravated by [user input]. Relieved by [user input].
```

---

## Example: Anxiety Template

### When "Anxiety" is selected:

**Template Questions Displayed:**
```
Symptoms:
☐ Excessive worry
☐ Restlessness
☐ Difficulty concentrating
☐ Sleep disturbance
☐ Panic attacks
☐ Physical symptoms (palpitations, sweating, trembling)

Duration:
[ ] weeks/months/years

Frequency:
○ Daily  ○ Several times per week  ○ Occasionally

Triggers:
[ ] Free text field

Impact on daily life:
☐ Work/school
☐ Relationships
☐ Sleep
☐ Appetite

Previous treatment:
○ None  ○ Counseling  ○ Medication  ○ Both
```

**Auto-Generated Notes:**
```
P/C/O: Anxiety

Patient reports anxiety symptoms for [X] months. Experiences excessive worry, restlessness, and sleep disturbance occurring daily. Triggers include [user input]. Symptoms impact work and sleep. Previous treatment: [selection].
```

---

## Example: Fever (Pediatric) Template

### When "Fever" is selected for pediatric patient:

**Template Questions Displayed:**
```
Temperature:
[ ] °C

Duration:
[ ] hours/days

Associated symptoms:
☐ Cough
☐ Runny nose
☐ Vomiting
☐ Diarrhea
☐ Rash
☐ Ear pain
☐ Difficulty breathing
☐ Decreased activity/lethargy
☐ Poor feeding

Fever pattern:
○ Continuous  ○ Intermittent  ○ Night-time only

Medications given:
☐ Paracetamol
☐ Ibuprofen
☐ None

Response to medication:
○ Good  ○ Partial  ○ None
```

**Auto-Generated Notes:**
```
P/C/O: Fever

Child presents with fever of [X]°C for [X] days. Pattern is [continuous/intermittent]. Associated symptoms include cough, runny nose, and decreased activity. Parents have given paracetamol with good response.
```

---

## Complaint Categories and Templates

### Adult Medicine Complaints

**Respiratory:**
- Cough → Questions: Duration, productive/dry, blood, fever, SOB, chest pain
- Shortness of breath → Questions: Onset, exertion, rest, orthopnea, PND, chest pain
- Chest pain → Questions: Location, character, radiation, duration, triggers, SOB

**Cardiovascular:**
- Palpitations → Questions: Duration, frequency, triggers, dizziness, chest pain
- Chest pain → Questions: Character, location, radiation, exertion-related, SOB

**Gastrointestinal:**
- Abdominal pain → Questions: Location, character, duration, radiation, N/V, bowel changes
- Nausea/vomiting → Questions: Duration, frequency, blood, abdominal pain, fever
- Diarrhea → Questions: Duration, frequency, blood/mucus, fever, abdominal pain

**Neurological:**
- Headache → Questions: Location, character, duration, triggers, visual changes, N/V
- Dizziness → Questions: Type (vertigo/lightheaded), duration, triggers, falls
- Anxiety → Questions: Symptoms, duration, triggers, impact, previous treatment

**Musculoskeletal:**
- Back pain → Questions: Location, onset, character, radiation, weakness, numbness
- Joint pain → Questions: Location, swelling, redness, stiffness, trauma

**General:**
- Fever → Questions: Temperature, duration, pattern, chills, sweats, source
- Fatigue → Questions: Duration, severity, sleep, mood, weight changes
- Weight loss → Questions: Amount, duration, intentional, appetite, other symptoms

### Pediatric-Specific Complaints

**Respiratory:**
- Cough (pediatric) → Questions: Duration, productive, fever, breathing difficulty, feeding
- Difficulty breathing → Questions: Onset, severity, wheeze, stridor, fever, feeding

**Fever:**
- Fever (pediatric) → Questions: Temperature, duration, pattern, associated symptoms, medications given

**Gastrointestinal:**
- Vomiting (pediatric) → Questions: Duration, frequency, blood, diarrhea, feeding, hydration
- Diarrhea (pediatric) → Questions: Duration, frequency, blood, vomiting, hydration status

**Skin:**
- Rash (pediatric) → Questions: Location, appearance, itchy, fever, spread, contacts

**Developmental:**
- Feeding problems → Questions: Type of feeding, amount, frequency, vomiting, weight gain
- Developmental concerns → Questions: Milestones, regression, concerns, family history
- Growth concerns → Questions: Weight, height, appetite, activity, comparison to siblings

---

## Visit Type Templates

### COVID-19
- Symptoms checklist (fever, cough, SOB, loss of taste/smell, etc.)
- Exposure history
- Vaccination status
- Test results

### Chronic Follow-up - Diabetes
- Blood sugar monitoring
- Medication compliance
- Diet and exercise
- Symptoms (polyuria, polydipsia, vision changes)
- Foot examination

### Chronic Follow-up - Hypertension
- BP readings at home
- Medication compliance
- Symptoms (headache, dizziness, chest pain)
- Lifestyle modifications

### General Checkup
- Health maintenance questions
- Screening due dates
- Preventive care
- Health concerns

### Pregnancy First Visit
- LMP, EDD
- Pregnancy symptoms
- Previous pregnancies
- Medical history
- Medications/supplements

---

## Template Question Types

### 1. Checkboxes (Multiple Selection)
```json
{
  "type": "checkbox",
  "question": "Associated symptoms:",
  "options": ["Fever", "Cough", "Headache", "Fatigue"],
  "output_format": "Associated symptoms include {selected_items}."
}
```

### 2. Radio Buttons (Single Selection)
```json
{
  "type": "radio",
  "question": "Severity:",
  "options": ["Mild", "Moderate", "Severe"],
  "output_format": "Severity is {selected_option}."
}
```

### 3. Text Input
```json
{
  "type": "text",
  "question": "Duration:",
  "placeholder": "e.g., 3 days",
  "output_format": "Duration: {user_input}."
}
```

### 4. Number Input
```json
{
  "type": "number",
  "question": "Temperature:",
  "unit": "°C",
  "output_format": "Temperature: {value}°C."
}
```

### 5. Dropdown
```json
{
  "type": "dropdown",
  "question": "Frequency:",
  "options": ["Daily", "Several times per week", "Occasionally", "Rarely"],
  "output_format": "Frequency: {selected_option}."
}
```

---

## Database Structure for Templates

### complaint_templates table
```sql
CREATE TABLE complaint_templates (
    id BIGINT PRIMARY KEY,
    complaint_name VARCHAR(100),
    category ENUM('adult', 'pediatric', 'both'),
    template_questions JSON,
    output_template TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Example JSON for template_questions:
```json
{
  "questions": [
    {
      "id": "duration",
      "type": "text",
      "label": "Duration:",
      "placeholder": "e.g., 3 days",
      "required": true
    },
    {
      "id": "associated_symptoms",
      "type": "checkbox",
      "label": "Associated symptoms:",
      "options": ["Fever", "Cough", "Headache", "Fatigue"],
      "required": false
    },
    {
      "id": "severity",
      "type": "radio",
      "label": "Severity:",
      "options": ["Mild", "Moderate", "Severe"],
      "required": true
    }
  ],
  "output_template": "Patient presents with {complaint} for {duration}. Associated symptoms include {associated_symptoms}. Severity is {severity}."
}
```

---

## Implementation Steps

### Phase 1: Basic Complaint Selection
1. Create complaint buttons UI
2. Store selected complaints
3. Display selection

### Phase 2: Template System
1. Create complaint_templates table
2. Seed with common complaints
3. Load template when complaint selected

### Phase 3: Dynamic Questions
1. Render questions based on template
2. Handle different question types
3. Validate responses

### Phase 4: Real-Time Summary
1. Generate text as questions are answered
2. Display in "Symptom notes" section
3. Allow editing of generated text

### Phase 5: Hybrid Mode
1. Support template + free-text
2. Merge both modes
3. Preserve edits

---

## Benefits

✅ **Faster Documentation** - Click instead of type
✅ **Standardized** - Consistent terminology
✅ **Complete** - Guided questions ensure nothing is missed
✅ **Flexible** - Can still use free-text for complex cases
✅ **Smart** - Auto-generates proper medical notes
✅ **Specialty-Specific** - Adult vs pediatric templates
✅ **Scalable** - Easy to add new templates

---

This is the game-changer that makes your EMR stand out! 🚀
