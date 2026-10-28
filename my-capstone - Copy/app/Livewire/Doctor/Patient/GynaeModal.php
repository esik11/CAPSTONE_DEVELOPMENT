<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class GynaeModal extends Component
{
    public Patient $patient;
    public bool $isOpen = false;

    // Contraception methods
    public $contraceptionMethods = [
        'oral_contraceptive_pill' => false,
        'contraceptive_implant' => false,
        'uid' => false,
        'contraceptive_injection' => false,
        'contraceptive_ring' => false,
        'diaphragm' => false,
        'sterilisation' => false,
    ];
    
    public $contraceptionComments = '';
    
    // Menstrual history
    public $ageAtMenarche = null;
    public $lastMenstrualPeriod = null;
    public $cycleRegularity = '';
    public $cycleLengthDays = null;
    
    public $menstrualIssues = [
        'heavy_bleeding' => false,
        'painful_periods' => false,
        'irregular_periods' => false,
        'spotting' => false,
        'amenorrhea' => false,
    ];
    
    public $menstrualComments = '';
    
    // Pregnancy information
    public $numberOfPregnancies = null;
    public $numberOfChildren = null;
    
    // Pregnancy complications
    public $pregnancyComplications = [
        'miscarriage' => false,
        'gestational_diabetes' => false,
        'preeclampsia' => false,
        'ectopic_pregnancy' => false,
    ];
    
    public $pregnancyComplicationsComments = '';

    #[On('openGynaeModal')]
    public function openModal()
    {
        $this->loadData();
        $this->isOpen = true;
    }

    public function loadData()
    {
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();

        // Reset
        $this->contraceptionMethods = [
            'oral_contraceptive_pill' => false,
            'contraceptive_implant' => false,
            'uid' => false,
            'contraceptive_injection' => false,
            'contraceptive_ring' => false,
            'diaphragm' => false,
            'sterilisation' => false,
        ];
        $this->contraceptionComments = '';
        $this->ageAtMenarche = null;
        $this->lastMenstrualPeriod = null;
        $this->cycleRegularity = '';
        $this->cycleLengthDays = null;
        $this->menstrualIssues = [
            'heavy_bleeding' => false,
            'painful_periods' => false,
            'irregular_periods' => false,
            'spotting' => false,
            'amenorrhea' => false,
        ];
        $this->menstrualComments = '';
        $this->numberOfPregnancies = null;
        $this->numberOfChildren = null;
        $this->pregnancyComplications = [
            'miscarriage' => false,
            'gestational_diabetes' => false,
            'preeclampsia' => false,
            'ectopic_pregnancy' => false,
        ];
        $this->pregnancyComplicationsComments = '';

        if ($medicalRecord && $medicalRecord->gynaeHistory) {
            $gynaeHistory = $medicalRecord->gynaeHistory;
            
            // Load contraception methods
            if ($gynaeHistory->contraception) {
                $savedMethods = json_decode($gynaeHistory->contraception, true);
                foreach ($savedMethods as $method) {
                    if (isset($this->contraceptionMethods[$method])) {
                        $this->contraceptionMethods[$method] = true;
                    }
                }
            }
            
            $this->contraceptionComments = $gynaeHistory->contraception_comments ?? '';
            
            // Load menstrual history
            $this->ageAtMenarche = $gynaeHistory->age_at_menarche;
            $this->lastMenstrualPeriod = $gynaeHistory->last_menstrual_period?->format('Y-m-d');
            $this->cycleRegularity = $gynaeHistory->cycle_regularity ?? '';
            $this->cycleLengthDays = $gynaeHistory->cycle_length_days;
            
            if ($gynaeHistory->menstrual_issues) {
                $savedIssues = json_decode($gynaeHistory->menstrual_issues, true);
                foreach ($savedIssues as $issue) {
                    if (isset($this->menstrualIssues[$issue])) {
                        $this->menstrualIssues[$issue] = true;
                    }
                }
            }
            
            $this->menstrualComments = $gynaeHistory->menstrual_comments ?? '';
            
            // Load pregnancy information
            $this->numberOfPregnancies = $gynaeHistory->number_of_pregnancies;
            $this->numberOfChildren = $gynaeHistory->number_of_children;
            
            // Load pregnancy complications
            if ($gynaeHistory->pregnancy_complications) {
                $savedComplications = json_decode($gynaeHistory->pregnancy_complications, true);
                foreach ($savedComplications as $complication) {
                    if (isset($this->pregnancyComplications[$complication])) {
                        $this->pregnancyComplications[$complication] = true;
                    }
                }
            }
            
            $this->pregnancyComplicationsComments = $gynaeHistory->pregnancy_complications_comments ?? '';
        }
    }

    public function save()
    {
        // Get or create medical record
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();
        
        if (!$medicalRecord) {
            $medicalRecord = $this->patient->medicalRecords()->create([
                'doctor_id' => auth()->id(),
            ]);
        }

        // Get selected contraception methods
        $selectedMethods = [];
        foreach ($this->contraceptionMethods as $method => $selected) {
            if ($selected) {
                $selectedMethods[] = $method;
            }
        }
        
        // Get selected menstrual issues
        $selectedIssues = [];
        foreach ($this->menstrualIssues as $issue => $selected) {
            if ($selected) {
                $selectedIssues[] = $issue;
            }
        }
        
        // Get selected pregnancy complications
        $selectedComplications = [];
        foreach ($this->pregnancyComplications as $complication => $selected) {
            if ($selected) {
                $selectedComplications[] = $complication;
            }
        }

        // Update or create gynae history
        $medicalRecord->gynaeHistory()->updateOrCreate(
            ['medical_record_id' => $medicalRecord->id],
            [
                'contraception' => json_encode($selectedMethods),
                'contraception_comments' => $this->contraceptionComments,
                'age_at_menarche' => $this->ageAtMenarche,
                'last_menstrual_period' => $this->lastMenstrualPeriod,
                'cycle_regularity' => $this->cycleRegularity,
                'cycle_length_days' => $this->cycleLengthDays,
                'menstrual_issues' => json_encode($selectedIssues),
                'menstrual_comments' => $this->menstrualComments,
                'number_of_pregnancies' => $this->numberOfPregnancies,
                'number_of_children' => $this->numberOfChildren,
                'pregnancy_complications' => json_encode($selectedComplications),
                'pregnancy_complications_comments' => $this->pregnancyComplicationsComments,
            ]
        );

        session()->flash('message', 'Gynae history updated successfully!');
        $this->closeModal();
        
        // Dispatch events to refresh displays
        $this->dispatch('gynae-updated');
        $this->js('window.dispatchEvent(new CustomEvent("gynae-updated"))');
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.doctor.patient.gynae-modal');
    }
}
