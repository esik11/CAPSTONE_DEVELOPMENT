# Consultation Symptoms Sub-Module - Design Document

## Overview

The Symptoms Sub-Module is the first component of the consultation system, enabling doctors to efficiently document patient complaints using smart, complaint-specific templates that auto-generate clinical notes in real-time. The system supports both template-based and free-text documentation modes.

## Architecture

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                     Presentation Layer                       │
│  ┌──────────────────┐  ┌──────────────────┐                │
│  │ Consultation     │  │ Patient EMR      │                │
│  │ Form (Livewire)  │  │ Sidebar          │                │
│  └──────────────────┘  └──────────────────┘                │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                     Application Layer                        │
│  ┌──────────────────┐  ┌──────────────────┐                │
│  │ Consultation     │  │ Template         │                │
│  │ Controller       │  │ Service          │                │
│  └──────────────────┘  └──────────────────┘                │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                       Data Layer                             │
│  ┌──────────────────┐  ┌──────────────────┐                │
│  │ Consultation     │  │ Complaint        │                │
│  │ Model            │  │ Template Model   │                │
│  └──────────────────┘  └──────────────────┘                │
└─────────────────────────────────────────────────────────────┘
```

## Components and Interfaces

### 1. Frontend Components (Livewire)

#### ConsultationSymptomsForm Component
**Purpose:** Main form for symptom documentation

**Properties:**
- `$consultation` - Current consultation instance
- `$selectedComplaints` - Array of selected complaint IDs
- `$selectedVisitType` - Selected visit type
- `$templateResponses` - Responses to template questions
- `$symptomNotesAuto` - Auto-generated notes
- `$symptomNotesManual` - Manual free-text notes
- `$documentationMode` - 'template', 'freetext', or 'hybrid'

**Methods:**
- `selectComplaint($complaintId)` - Handle complaint selection
- `selectVisitType($visitType)` - Handle visit type selection
- `updateTemplateResponse($questionId, $value)` - Update template answer
- `generateNotes()` - Generate clinical notes from template responses
- `saveDraft()` - Save consultation as draft
- `continueToExamination()` - Validate and proceed to next section

#### PatientSidebarComponent
**Purpose:** Display patient EMR summary

**Properties:**
- `$patient` - Patient instance
- `$latestVitals` - Latest vital signs
- `$activeConditions` - Current conditions
- `$activeMedications` - Current medications
- `$allergies` - Patient allergies
- `$recentConsultations` - Last 5 consultations

**Methods:**
- `refreshData()` - Reload patient data
- `openQuickAddModal($type)` - Open modal for quick actions

### 2. Backend Controllers

#### ConsultationController
**Purpose:** Handle consultation lifecycle

**Routes:**
```php
GET  /patients/{patient}/consultation/start
GET  /consultations/{consultation}
POST /consultations/{consultation}/save-draft
POST /consultations/{consultation}/continue
```

**Methods:**
```php
public function start(Patient $patient): View
{
    // Check for existing draft consultation
    // Create new consultation if none exists
    // Load consultation interface
}

public function show(Consultation $consultation): View
{
    // Load consultation data
    // Display consultation interface
}

public function saveDraft(Consultation $consultation, Request $request): RedirectResponse
{
    // Validate and save draft
    // Return to patient overview
}

public function continue(Consultation $consultation, Request $request): RedirectResponse
{
    // Validate symptoms section
    // Move to examination section
}
```

### 3. Services

#### TemplateService
**Purpose:** Handle template loading and note generation

**Methods:**
```php
public function getComplaintTemplate(string $complaintName): ?ComplaintTemplate
{
    // Load template for specific complaint
}

public function mergeTemplates(array $complaintIds): array
{
    // Merge multiple complaint templates
    // Remove duplicate questions
    // Return combined question set
}

public function generateNotes(array $templateResponses, array $complaints): string
{
    // Generate clinical notes from template responses
    // Use proper medical terminology
    // Format according to template output format
}

public function getVisitTypeTemplate(string $visitType): ?array
{
    // Load visit type specific questions
}
```

## Data Models

### Consultation Model

```php
class Consultation extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'consultation_date',
        'consultation_time',
        'selected_complaints',
        'visit_type',
        'template_responses',
        'symptom_notes_auto',
        'symptom_notes_manual',
        'symptom_notes_final',
        'symptom_onset',
        'symptom_duration',
        'symptom_duration_unit',
        'aggravating_factors',
        'relieving_factors',
        'previous_episodes',
        'previous_episodes_details',
        'review_of_systems',
        'associated_symptoms',
        'documentation_mode',
        'status',
        'current_section',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'selected_complaints' => 'array',
        'template_responses' => 'array',
        'review_of_systems' => 'array',
        'associated_symptoms' => 'array',
        'previous_episodes' => 'boolean',
    ];

    // Relationships
    public function patient(): BelongsTo
    public function doctor(): BelongsTo
    public function appointment(): BelongsTo
}
```

### ComplaintTemplate Model

```php
class ComplaintTemplate extends Model
{
    protected $fillable = [
        'complaint_name',
        'category',
        'template_questions',
        'output_template',
        'common_symptoms',
    ];

    protected $casts = [
        'template_questions' => 'array',
        'common_symptoms' => 'array',
    ];

    // Scopes
    public function scopeAdult($query)
    public function scopePediatric($query)
    public function scopeByCategory($query, $category)
}
```

### VisitTypeTemplate Model

```php
class VisitTypeTemplate extends Model
{
    protected $fillable = [
        'visit_type_name',
        'template_questions',
        'required_fields',
    ];

    protected $casts = [
        'template_questions' => 'array',
        'required_fields' => 'array',
    ];
}
```

## Database Schema

### consultations table
```sql
CREATE TABLE consultations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    patient_id BIGINT NOT NULL,
    doctor_id BIGINT NOT NULL,
    appointment_id BIGINT NULL,
    consultation_date DATE NOT NULL,
    consultation_time TIME NOT NULL,
    selected_complaints JSON NULL,
    visit_type VARCHAR(100) NULL,
    template_responses JSON NULL,
    symptom_notes_auto TEXT NULL,
    symptom_notes_manual TEXT NULL,
    symptom_notes_final TEXT NULL,
    symptom_onset VARCHAR(100) NULL,
    symptom_duration INT NULL,
    symptom_duration_unit VARCHAR(20) NULL,
    aggravating_factors TEXT NULL,
    relieving_factors TEXT NULL,
    previous_episodes BOOLEAN DEFAULT FALSE,
    previous_episodes_details TEXT NULL,
    review_of_systems JSON NULL,
    associated_symptoms JSON NULL,
    documentation_mode ENUM('template', 'freetext', 'hybrid') DEFAULT 'template',
    status ENUM('draft', 'in_progress', 'completed', 'cancelled') DEFAULT 'draft',
    current_section ENUM('symptoms', 'examination', 'diagnosis', 'prescribe') DEFAULT 'symptoms',
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
);
```

### complaint_templates table
```sql
CREATE TABLE complaint_templates (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    complaint_name VARCHAR(100) NOT NULL,
    category ENUM('adult', 'pediatric', 'both') DEFAULT 'both',
    template_questions JSON NOT NULL,
    output_template TEXT NOT NULL,
    common_symptoms JSON NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    UNIQUE KEY unique_complaint (complaint_name, category)
);
```

### visit_type_templates table
```sql
CREATE TABLE visit_type_templates (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    visit_type_name VARCHAR(100) NOT NULL UNIQUE,
    template_questions JSON NOT NULL,
    required_fields JSON NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## User Interface Design

### Layout Structure

```
┌─────────────────────────────────────────────────────────────────┐
│ Header: Patient Name | Auto-save indicator | Save Draft | Cancel│
├──────────────────────────┬──────────────────────────────────────┤
│                          │                                      │
│  Main Content (70%)      │    Patient Sidebar (30%)            │
│                          │                                      │
│  ┌─ Tabs ─────────────┐ │    ┌─ Demographics ──────────────┐  │
│  │ Symptoms │ Exam │   │ │    │ Name, Age, Gender, ID      │  │
│  │ Diagnose │ Plan │   │ │    └────────────────────────────┘  │
│  └────────────────────┘ │                                      │
│                          │    ┌─ Latest Vitals ─────────────┐  │
│  Complaint Buttons       │    │ BP, HR, Temp, Weight       │  │
│  [Button] [Button]...    │    └────────────────────────────┘  │
│                          │                                      │
│  Visit Type Buttons      │    ┌─ Conditions ────────────────┐  │
│  [Button] [Button]...    │    │ Active conditions list     │  │
│                          │    │ [+ Add Condition]          │  │
│  Template Questions      │    └────────────────────────────┘  │
│  (Dynamic based on       │                                      │
│   selected complaint)    │    ┌─ Medications ───────────────┐  │
│                          │    │ Active medications list    │  │
│  Symptom Notes           │    │ [+ Add Medication]         │  │
│  ┌────────────────────┐ │    └────────────────────────────┘  │
│  │ Auto-generated     │ │                                      │
│  │ clinical notes     │ │    ┌─ Allergies ─────────────────┐  │
│  │ (editable)         │ │    │ Known allergies            │  │
│  └────────────────────┘ │    │ [+ Add Allergy]            │  │
│                          │    └────────────────────────────┘  │
│  [Continue to Exam →]    │                                      │
│                          │    ┌─ Recent Consultations ──────┐  │
│                          │    │ Last 5 visits              │  │
│                          │    └────────────────────────────┘  │
└──────────────────────────┴──────────────────────────────────────┘
```

### Component Hierarchy

```
ConsultationLayout
├── ConsultationHeader
│   ├── PatientInfo
│   ├── AutoSaveIndicator
│   └── ActionButtons
├── ConsultationTabs
│   ├── SymptomsTab (active)
│   ├── ExaminationTab
│   ├── DiagnosisTab
│   └── PlanTab
├── MainContent
│   └── SymptomsForm (Livewire)
│       ├── ComplaintButtons
│       ├── VisitTypeButtons
│       ├── TemplateQuestions (dynamic)
│       └── SymptomNotesEditor
└── PatientSidebar (Livewire)
    ├── Demographics
    ├── LatestVitals
    ├── ConditionsWidget
    ├── MedicationsWidget
    ├── AllergiesWidget
    └── RecentConsultations
```

## Key Features Implementation

### 1. Auto-Save Functionality

**Implementation:**
- Use Livewire's `wire:poll.30s` for automatic saving
- Debounce user input to prevent excessive saves
- Display visual indicator during save operation

```php
// In Livewire component
public function autoSave()
{
    $this->consultation->update([
        'selected_complaints' => $this->selectedComplaints,
        'template_responses' => $this->templateResponses,
        'symptom_notes_auto' => $this->symptomNotesAuto,
        'symptom_notes_manual' => $this->symptomNotesManual,
    ]);
    
    $this->lastSaved = now();
}
```

### 2. Real-Time Note Generation

**Implementation:**
- Watch template responses for changes
- Regenerate notes when responses update
- Preserve manual edits

```php
public function updatedTemplateResponses()
{
    $this->symptomNotesAuto = app(TemplateService::class)
        ->generateNotes(
            $this->templateResponses,
            $this->selectedComplaints
        );
}
```

### 3. Template Loading

**Implementation:**
- Load templates when complaints are selected
- Merge templates for multiple complaints
- Cache templates for performance

```php
public function selectComplaint($complaintId)
{
    if (in_array($complaintId, $this->selectedComplaints)) {
        // Remove complaint
        $this->selectedComplaints = array_diff(
            $this->selectedComplaints,
            [$complaintId]
        );
    } else {
        // Add complaint
        $this->selectedComplaints[] = $complaintId;
    }
    
    $this->loadTemplates();
}

private function loadTemplates()
{
    $this->currentTemplate = app(TemplateService::class)
        ->mergeTemplates($this->selectedComplaints);
}
```

### 4. Quick Actions Integration

**Implementation:**
- Use Livewire events to communicate between components
- Open modals without page reload
- Refresh sidebar after adding items

```php
// In sidebar component
public function openQuickAddModal($type)
{
    $this->dispatch('open' . ucfirst($type) . 'Modal');
}

// Listen for updates
#[On('condition-added')]
public function refreshConditions()
{
    $this->activeConditions = $this->patient
        ->currentConditions()
        ->get();
}
```

## Error Handling

### Validation Rules

```php
// Symptoms section validation
$rules = [
    'selectedComplaints' => 'required_without:symptomNotesManual|array',
    'symptomNotesManual' => 'required_without:selectedComplaints|string',
    'templateResponses' => 'array',
];
```

### Error States

1. **No complaint selected and no manual notes**
   - Display: "Please select a complaint or enter manual notes"
   - Action: Highlight both sections

2. **Auto-save failure**
   - Display: "Failed to save. Retrying..."
   - Action: Retry after 10 seconds, show error if persistent

3. **Template loading failure**
   - Display: "Unable to load template. Please try again."
   - Action: Fallback to free-text mode

## Testing Strategy

### Unit Tests
- Template service note generation
- Complaint template merging
- Validation rules

### Feature Tests
- Start consultation flow
- Save draft functionality
- Continue to examination
- Auto-save mechanism

### Browser Tests (Dusk)
- Complete symptom documentation workflow
- Template selection and question answering
- Real-time note generation
- Quick actions from sidebar

## Performance Considerations

### Optimization Strategies

1. **Template Caching**
   - Cache complaint templates in Redis
   - Cache duration: 1 hour
   - Invalidate on template update

2. **Lazy Loading**
   - Load patient sidebar data on demand
   - Paginate consultation history

3. **Database Indexing**
   ```sql
   CREATE INDEX idx_consultations_patient_status 
   ON consultations(patient_id, status);
   
   CREATE INDEX idx_consultations_doctor_date 
   ON consultations(doctor_id, consultation_date);
   ```

4. **Query Optimization**
   - Eager load relationships
   - Use select() to limit columns
   - Cache patient EMR summary

## Security Considerations

### Authorization
- Verify doctor can access patient
- Verify doctor owns consultation
- Prevent unauthorized edits

```php
// Policy
public function update(User $user, Consultation $consultation)
{
    return $user->id === $consultation->doctor_id;
}
```

### Data Protection
- Encrypt sensitive notes
- Audit log all changes
- HIPAA compliance for data storage

## Deployment Considerations

### Database Migrations
1. Create consultations table
2. Create complaint_templates table
3. Create visit_type_templates table
4. Seed complaint templates
5. Seed visit type templates

### Configuration
```php
// config/consultation.php
return [
    'auto_save_interval' => 30, // seconds
    'draft_expiry_hours' => 24,
    'template_cache_ttl' => 3600, // seconds
];
```

## Future Enhancements

1. **Voice-to-Text**
   - Integrate speech recognition for note dictation

2. **AI-Assisted Documentation**
   - Suggest diagnoses based on symptoms
   - Auto-complete clinical notes

3. **Template Customization**
   - Allow doctors to create custom templates
   - Share templates across practice

4. **Mobile Optimization**
   - Responsive design for tablets
   - Touch-optimized interface

---

This design provides a solid foundation for implementing the Symptoms Sub-Module with smart templates and real-time note generation.
