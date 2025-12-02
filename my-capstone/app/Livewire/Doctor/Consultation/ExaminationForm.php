<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Consultation;
use Livewire\Component;

class ExaminationForm extends Component
{
    public Consultation $consultation;
    
    // Vital signs
    public $temperature = null;
    public $pulseRate = null;
    public $bloodPressure = '';
    public $respiratoryRate = null;
    public $spo2 = null;
    public $weight = null;
    public $height = null;
    public $waistCircumference = null;
    
    // Examination fields
    public $generalAppearance = '';
    public $heentExam = '';
    public $cardiovascularExam = '';
    public $respiratoryExam = '';
    public $abdominalExam = '';
    public $neurologicalExam = '';
    public $musculoskeletalExam = '';
    public $skinExam = '';
    public $examinationNotes = '';
    
    // Structured examination findings
    public $cardiovascularFindings_selected = [];
    public $respiratoryFindings_selected = [];
    public $abdominalFindings_selected = [];
    public $neurologicalFindings_selected = [];
    public $musculoskeletalFindings_selected = [];
    public $heentFindings_selected = [];
    public $skinFindings_selected = [];
    
    // Auto-save tracking
    public $lastSaved = null;
    public $isSaving = false;
    
    protected $listeners = ['save-and-navigate' => 'handleSaveAndNavigate'];
    
    // Normal findings templates
    public $normalFindings = [
        'general' => 'Patient appears well, alert and oriented x3, in no acute distress.',
        'heent' => 'Normocephalic, atraumatic. Pupils equal, round, reactive to light. Tympanic membranes intact. Oropharynx clear, no erythema.',
        'cardiovascular' => 'Regular rate and rhythm. S1 and S2 normal. No murmurs, rubs, or gallops. Peripheral pulses 2+ bilaterally.',
        'respiratory' => 'Clear to auscultation bilaterally. No wheezes, rales, or rhonchi. Good air entry. Respiratory effort normal.',
        'abdominal' => 'Soft, non-tender, non-distended. Bowel sounds present in all quadrants. No organomegaly. No rebound or guarding.',
        'neurological' => 'Alert and oriented x3. Cranial nerves II-XII intact. Motor strength 5/5 in all extremities. Sensation intact. Reflexes 2+ and symmetric. Gait normal.',
        'musculoskeletal' => 'Full range of motion in all joints. No joint swelling, erythema, or warmth. No deformities. Gait normal.',
        'skin' => 'Warm, dry, intact. No rashes, lesions, or discoloration. Good turgor. Capillary refill <2 seconds.',
    ];

    public function mount(Consultation $consultation)
    {
        $this->consultation = $consultation;
        
        // Load vital signs
        $this->temperature = $consultation->temperature;
        $this->pulseRate = $consultation->pulse_rate;
        $this->bloodPressure = $consultation->blood_pressure ?? '';
        $this->respiratoryRate = $consultation->respiratory_rate;
        $this->spo2 = $consultation->spo2;
        $this->weight = $consultation->weight;
        $this->height = $consultation->height;
        $this->waistCircumference = $consultation->waist_circumference;
        
        // Load existing data
        $this->generalAppearance = $consultation->general_appearance ?? '';
        $this->heentExam = $consultation->heent_exam ?? '';
        $this->heentFindings_selected = $consultation->heent_findings ?? [];
        $this->cardiovascularExam = $consultation->cardiovascular_exam ?? '';
        $this->cardiovascularFindings_selected = $consultation->cardiovascular_findings ?? [];
        $this->respiratoryExam = $consultation->respiratory_exam ?? '';
        $this->respiratoryFindings_selected = $consultation->respiratory_findings ?? [];
        $this->abdominalExam = $consultation->abdominal_exam ?? '';
        $this->abdominalFindings_selected = $consultation->abdominal_findings ?? [];
        $this->neurologicalExam = $consultation->neurological_exam ?? '';
        $this->neurologicalFindings_selected = $consultation->neurological_findings ?? [];
        $this->musculoskeletalExam = $consultation->musculoskeletal_exam ?? '';
        $this->musculoskeletalFindings_selected = $consultation->musculoskeletal_findings ?? [];
        $this->skinExam = $consultation->skin_exam ?? '';
        $this->skinFindings_selected = $consultation->skin_findings ?? [];
        $this->examinationNotes = $consultation->examination_notes ?? '';
    }
    
    public function getBmiProperty()
    {
        if ($this->weight && $this->height) {
            $heightInMeters = $this->height / 100;
            $bmi = $this->weight / ($heightInMeters * $heightInMeters);
            return number_format($bmi, 1);
        }
        return '--';
    }

    public function useNormalFinding($system)
    {
        $property = $system . 'Exam';
        if ($system === 'general') {
            $property = 'generalAppearance';
        }
        
        if (isset($this->normalFindings[$system])) {
            $this->$property = $this->normalFindings[$system];
        }
    }
    
    public function toggleExamCheckbox($category, $finding)
    {
        $property = $category . '_selected';
        
        // Initialize as empty array if not set
        if (!isset($this->$property) || !is_array($this->$property)) {
            $this->$property = [];
        }
        
        // Check if finding is already selected
        $key = array_search($finding, $this->$property);
        
        if ($key !== false) {
            // Remove it (uncheck)
            unset($this->$property[$key]);
            $this->$property = array_values($this->$property);
        } else {
            // Add it (check)
            $this->$property[] = $finding;
        }
    }

    public function saveDraft()
    {
        $this->isSaving = true;
        
        $this->consultation->update([
            'temperature' => $this->temperature,
            'pulse_rate' => $this->pulseRate,
            'blood_pressure' => $this->bloodPressure,
            'respiratory_rate' => $this->respiratoryRate,
            'spo2' => $this->spo2,
            'weight' => $this->weight,
            'height' => $this->height,
            'waist_circumference' => $this->waistCircumference,
            'general_appearance' => $this->generalAppearance,
            'heent_exam' => $this->heentExam,
            'heent_findings' => $this->heentFindings_selected,
            'cardiovascular_exam' => $this->cardiovascularExam,
            'cardiovascular_findings' => $this->cardiovascularFindings_selected,
            'respiratory_exam' => $this->respiratoryExam,
            'respiratory_findings' => $this->respiratoryFindings_selected,
            'abdominal_exam' => $this->abdominalExam,
            'abdominal_findings' => $this->abdominalFindings_selected,
            'neurological_exam' => $this->neurologicalExam,
            'neurological_findings' => $this->neurologicalFindings_selected,
            'musculoskeletal_exam' => $this->musculoskeletalExam,
            'musculoskeletal_findings' => $this->musculoskeletalFindings_selected,
            'skin_exam' => $this->skinExam,
            'skin_findings' => $this->skinFindings_selected,
            'examination_notes' => $this->examinationNotes,
        ]);
        
        $this->lastSaved = now()->format('H:i:s');
        $this->isSaving = false;
        
        $this->dispatch('draft-saved');
        $this->dispatch('consultation-updated');
    }

    public function autoSave()
    {
        $this->saveDraft();
    }

    public function continueToDiagnosis()
    {
        // Save before continuing
        $this->saveDraft();
        
        // Update section
        $this->consultation->update(['current_section' => 'diagnosis']);
        
        // Redirect
        session()->flash('success', 'Examination section completed. Moving to diagnosis.');
        return redirect()->route('consultations.show', $this->consultation);
    }

    public function backToSymptoms()
    {
        // Save before going back
        $this->saveDraft();
        
        // Update section
        $this->consultation->update(['current_section' => 'symptoms']);
        
        return redirect()->route('consultations.show', $this->consultation);
    }
    
    public function handleSaveAndNavigate($section)
    {
        // Only handle if we're on the examination section
        if ($this->consultation->current_section !== 'examination') {
            // Just navigate
            return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
        }
        
        // Save current data
        $this->saveDraft();
        
        // Update section if navigating to a different section
        if ($section !== 'examination') {
            $this->consultation->update(['current_section' => $section]);
        }
        
        // Redirect
        return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
    }

    public function render()
    {
        return view('livewire.doctor.consultation.examination-form');
    }
}
