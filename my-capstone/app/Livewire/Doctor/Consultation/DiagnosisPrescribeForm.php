<?php

namespace App\Livewire\Doctor\Consultation;

use App\Models\Consultation;
use App\Models\Icd10Code;
use Livewire\Component;

class DiagnosisPrescribeForm extends Component
{
    public Consultation $consultation;
    
    // Active tab
    public $activeTab = 'diagnosis';
    
    // Diagnosis search
    public $diagnosisSearch = '';
    public $diagnosisResults = [];
    public $selectedDiagnoses = [];
    
    // Diagnosis notes
    public $diagnosisNotes = '';
    
    // Auto-save tracking
    public $lastSaved = null;
    public $isSaving = false;
    
    protected $listeners = ['save-and-navigate' => 'handleSaveAndNavigate'];

    public function mount(Consultation $consultation)
    {
        $this->consultation = $consultation;
        
        // Load existing data
        $this->selectedDiagnoses = $consultation->diagnoses ?? [];
        $this->diagnosisNotes = $consultation->diagnosis_notes ?? '';
    }

    public function updatedDiagnosisSearch()
    {
        if (strlen($this->diagnosisSearch) >= 2) {
            $this->diagnosisResults = Icd10Code::search($this->diagnosisSearch, 10)->toArray();
        } else {
            $this->diagnosisResults = [];
        }
    }

    public function addDiagnosis($code, $description)
    {
        // Check if already added
        $exists = collect($this->selectedDiagnoses)->contains('code', $code);
        
        if (!$exists) {
            $this->selectedDiagnoses[] = [
                'code' => $code,
                'description' => $description,
                'is_primary' => empty($this->selectedDiagnoses), // First one is primary
            ];
            
            // Clear search
            $this->diagnosisSearch = '';
            $this->diagnosisResults = [];
        }
    }

    public function removeDiagnosis($index)
    {
        unset($this->selectedDiagnoses[$index]);
        $this->selectedDiagnoses = array_values($this->selectedDiagnoses);
        
        // If we removed the primary, make the first one primary
        if (!empty($this->selectedDiagnoses)) {
            $hasPrimary = collect($this->selectedDiagnoses)->contains('is_primary', true);
            if (!$hasPrimary) {
                $this->selectedDiagnoses[0]['is_primary'] = true;
            }
        }
    }

    public function setPrimary($index)
    {
        // Remove primary from all
        foreach ($this->selectedDiagnoses as $key => $diagnosis) {
            $this->selectedDiagnoses[$key]['is_primary'] = false;
        }
        
        // Set this one as primary
        $this->selectedDiagnoses[$index]['is_primary'] = true;
    }

    public function saveDraft()
    {
        $this->isSaving = true;
        
        $this->consultation->update([
            'diagnoses' => $this->selectedDiagnoses,
            'diagnosis_notes' => $this->diagnosisNotes,
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
        if ($this->consultation->current_section !== 'diagnosis') {
            return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
        }
        
        $this->saveDraft();
        
        if ($section !== 'diagnosis') {
            $this->consultation->update(['current_section' => $section]);
        }
        
        return redirect()->route('consultations.show', ['consultation' => $this->consultation, 'section' => $section]);
    }

    public function backToExamination()
    {
        $this->saveDraft();
        $this->consultation->update(['current_section' => 'examination']);
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
        return view('livewire.doctor.consultation.diagnosis-prescribe-form');
    }
}
