<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Consultation;
use Livewire\Component;

class PlanForm extends Component
{
    public Consultation $consultation;
    
    // Plan fields
    public $treatmentPlan = '';
    public $patientEducation = '';
    public $followupInstructions = '';
    public $doctorNotes = '';
    
    // Auto-save tracking
    public $lastSaved = null;
    public $isSaving = false;
    
    protected $listeners = ['save-and-navigate' => 'handleSaveAndNavigate'];

    public function mount(Consultation $consultation)
    {
        $this->consultation = $consultation;
        
        // Load existing data
        $this->treatmentPlan = $consultation->treatment_plan ?? '';
        $this->patientEducation = $consultation->patient_education ?? '';
        $this->followupInstructions = $consultation->followup_instructions ?? '';
        $this->doctorNotes = $consultation->doctor_notes ?? '';
    }

    public function saveDraft()
    {
        $this->isSaving = true;
        
        $this->consultation->update([
            'treatment_plan' => $this->treatmentPlan,
            'patient_education' => $this->patientEducation,
            'followup_instructions' => $this->followupInstructions,
            'doctor_notes' => $this->doctorNotes,
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

    public function handleSaveAndNavigate($section)
    {
        if ($this->consultation->current_section !== 'plan') {
            return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
        }
        
        $this->saveDraft();
        
        if ($section !== 'plan') {
            $this->consultation->update(['current_section' => $section]);
        }
        
        return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
    }

    public function backToDiagnosis()
    {
        $this->saveDraft();
        $this->consultation->update(['current_section' => 'diagnosis']);
        return redirect()->route('consultations.show', $this->consultation);
    }

    public function completeConsultation()
    {
        $this->saveDraft();
        $this->consultation->markAsCompleted();
        
        session()->flash('success', 'Consultation completed successfully!');
        return redirect()->route('patients.show', $this->consultation->patient);
    }

    public function render()
    {
        return view('livewire.doctor.consultation.plan-form');
    }
}
