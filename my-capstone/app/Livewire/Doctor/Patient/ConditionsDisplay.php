<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use Livewire\Component;
use Livewire\Attributes\On;

class ConditionsDisplay extends Component
{
    public Patient $patient;
    public $showInSummary = false; // true for summary card, false for full list
    public $refreshKey = 0; // Used to force re-render

    #[On('conditionsUpdated')]
    public function refreshConditions()
    {
        // Increment the refresh key to force a re-render
        $this->refreshKey++;
    }

    public function render()
    {
        // Always get fresh data from database, bypassing any cached relationships
        $medicalRecord = \App\Models\MedicalRecord::where('patient_id', $this->patient->id)
            ->latest()
            ->first();
        
        $conditions = collect();
        
        if ($medicalRecord) {
            // Get conditions with pivot data
            $conditions = \App\Models\MedicalCondition::whereHas('medicalRecords', function ($query) use ($medicalRecord) {
                $query->where('medical_record_id', $medicalRecord->id);
            })
            ->with(['medicalRecords' => function ($query) use ($medicalRecord) {
                $query->where('medical_record_id', $medicalRecord->id);
            }])
            ->get()
            ->map(function ($condition) use ($medicalRecord) {
                // Manually attach pivot data
                $pivot = \DB::table('patient_conditions')
                    ->where('medical_record_id', $medicalRecord->id)
                    ->where('condition_id', $condition->id)
                    ->first();
                
                if ($pivot) {
                    $condition->pivot = $pivot;
                }
                
                return $condition;
            });
        }
        
        // If showing in summary, only show pinned conditions
        if ($this->showInSummary) {
            $conditions = $conditions->filter(function ($condition) {
                return isset($condition->pivot) && $condition->pivot->is_pinned == 1;
            });
        }
        
        return view('livewire.doctor.patient.conditions-display', [
            'conditions' => $conditions,
        ]);
    }
}
