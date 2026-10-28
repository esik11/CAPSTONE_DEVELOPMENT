<?php

namespace App\Livewire\Doctor\Patient;

use App\Models\Patient;
use App\Models\MedicalCondition;
use Livewire\Component;
use Livewire\Attributes\On;

class ConditionModal extends Component
{
    public Patient $patient;
    public bool $isOpen = false;

    // Selected conditions with their details
    public $selectedConditions = [];
    
    // Search term for filtering conditions
    public $searchTerm = '';
    
    // New custom condition name
    public $newConditionName = '';
    
    // Show all conditions or just common ones
    public $showAllConditions = false;

    #[On('openConditionModal')]
    public function openModal()
    {
        $this->loadData();
        $this->isOpen = true;
    }
    
    public function addCustomCondition()
    {
        $this->validate([
            'newConditionName' => 'required|string|max:255',
        ]);
        
        // Create new condition
        $newCondition = MedicalCondition::create([
            'condition_name' => $this->newConditionName,
        ]);
        
        // Auto-select it with all required fields
        $this->selectedConditions[$newCondition->id] = [
            'selected' => true,
            'status' => true,
            'notes' => '',
            'is_pinned' => false,
        ];
        
        $this->newConditionName = '';
        
        session()->flash('condition_added', 'Custom condition added successfully!');
    }
    
    public function deleteCondition($conditionId)
    {
        $condition = MedicalCondition::find($conditionId);
        
        if ($condition) {
            // Remove from selected if it was selected
            unset($this->selectedConditions[$conditionId]);
            
            // Delete the condition
            $condition->delete();
            
            session()->flash('condition_deleted', 'Condition deleted successfully!');
        }
    }

    public function loadData()
    {
        // Get the latest medical record with fresh data
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();

        $this->selectedConditions = [];

        if ($medicalRecord) {
            // Load existing conditions with fresh pivot data
            $existingConditions = $medicalRecord->medicalConditions()->get();
            
            foreach ($existingConditions as $condition) {
                // Get fresh pivot data directly from database
                $pivotData = \DB::table('patient_conditions')
                    ->where('medical_record_id', $medicalRecord->id)
                    ->where('condition_id', $condition->id)
                    ->first();
                
                $this->selectedConditions[$condition->id] = [
                    'selected' => true,
                    'status' => $pivotData->status ?? true,
                    'notes' => $pivotData->notes ?? '',
                    'is_pinned' => $pivotData->is_pinned ?? false,
                ];
            }
        }
    }

    public function toggleCondition($conditionId)
    {
        if (isset($this->selectedConditions[$conditionId]['selected']) && $this->selectedConditions[$conditionId]['selected']) {
            // Unselect
            $this->selectedConditions[$conditionId]['selected'] = false;
        } else {
            // Select with default values
            $this->selectedConditions[$conditionId] = [
                'selected' => true,
                'status' => true,
                'notes' => '',
                'is_pinned' => false,
            ];
        }
    }
    
    public function togglePin($conditionId)
    {
        if (isset($this->selectedConditions[$conditionId])) {
            $this->selectedConditions[$conditionId]['is_pinned'] = !($this->selectedConditions[$conditionId]['is_pinned'] ?? false);
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

        // Prepare sync data
        $syncData = [];
        
        foreach ($this->selectedConditions as $conditionId => $data) {
            if (isset($data['selected']) && $data['selected']) {
                $syncData[$conditionId] = [
                    'status' => $data['status'] ?? true,
                    'notes' => $data['notes'] ?? '',
                    'is_pinned' => $data['is_pinned'] ?? false,
                ];
            }
        }

        // Sync conditions (this will add new, update existing, and remove unselected)
        $medicalRecord->medicalConditions()->sync($syncData);
        
        // Force database commit
        \DB::statement('SELECT 1');

        session()->flash('message', 'Conditions updated successfully!');
        
        // Close modal first
        $this->isOpen = false;
        
        // Reset after closing
        $this->reset(['selectedConditions', 'searchTerm', 'newConditionName', 'showAllConditions']);
        
        // Dispatch browser event using Alpine
        $this->js('window.dispatchEvent(new CustomEvent("conditions-updated"))');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['selectedConditions', 'searchTerm', 'newConditionName', 'showAllConditions']);
    }

    public function render()
    {
        // Get patient's existing conditions
        $medicalRecord = $this->patient->medicalRecords()->latest()->first();
        $patientConditionIds = [];
        
        if ($medicalRecord) {
            $patientConditionIds = $medicalRecord->medicalConditions->pluck('id')->toArray();
        }
        
        if ($this->searchTerm) {
            // If searching, show all matching conditions (excluding patient's existing ones)
            $allConditions = MedicalCondition::where('condition_name', 'like', '%' . $this->searchTerm . '%')
                ->whereNotIn('id', $patientConditionIds)
                ->orderBy('condition_name')
                ->get();
        } elseif ($this->showAllConditions) {
            // Show all conditions (excluding patient's existing ones)
            $allConditions = MedicalCondition::whereNotIn('id', $patientConditionIds)
                ->orderBy('condition_name')
                ->get();
        } else {
            // Show only common conditions (excluding patient's existing ones)
            $allConditions = MedicalCondition::where('is_common', true)
                ->whereNotIn('id', $patientConditionIds)
                ->orderBy('condition_name')
                ->get();
        }
        
        // Get patient's conditions separately
        $patientConditions = collect();
        if ($medicalRecord) {
            $patientConditions = $medicalRecord->medicalConditions;
        }

        return view('livewire.doctor.patient.condition-modal', [
            'patientConditions' => $patientConditions,
            'availableConditions' => $allConditions,
        ]);
    }
}
