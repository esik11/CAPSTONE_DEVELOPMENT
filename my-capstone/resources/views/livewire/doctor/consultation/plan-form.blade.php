<div class="space-y-4" wire:poll.30s="autoSave">
    
    <!-- Treatment Plan -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                📋 Treatment Plan
            </label>
            <p class="text-xs text-gray-500 mb-3">
                Document the treatment approach, medications prescribed, lifestyle modifications, and any procedures recommended.
            </p>
            <textarea 
                wire:model.blur="treatmentPlan"
                rows="6"
                placeholder="Example:&#10;- Continue antibiotics as prescribed (Amoxicillin 500mg, 3x daily for 7 days)&#10;- Rest and adequate hydration&#10;- Avoid cold drinks and smoking&#10;- Paracetamol for fever if needed"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"></textarea>
        </div>
    </div>

    <!-- Patient Education -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                👨‍⚕️ Patient Education
            </label>
            <p class="text-xs text-gray-500 mb-3">
                Document what was explained to the patient about their condition, treatment, and self-care.
            </p>
            <textarea 
                wire:model.blur="patientEducation"
                rows="5"
                placeholder="Example:&#10;- Explained the importance of completing the full antibiotic course&#10;- Advised on proper medication timing (after meals)&#10;- Discussed warning signs that require immediate attention&#10;- Provided information on expected recovery timeline"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"></textarea>
        </div>
    </div>

    <!-- Follow-up Instructions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                📅 Follow-up Instructions
            </label>
            <p class="text-xs text-gray-500 mb-3">
                Specify when the patient should return and what symptoms should prompt immediate medical attention.
            </p>
            <textarea 
                wire:model.blur="followupInstructions"
                rows="5"
                placeholder="Example:&#10;- Return in 7 days if symptoms persist or worsen&#10;- Come immediately if:&#10;  • Fever > 39°C (102.2°F)&#10;  • Difficulty breathing&#10;  • Chest pain&#10;  • Severe headache&#10;- Schedule follow-up appointment in 2 weeks"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"></textarea>
        </div>
    </div>

    <!-- Doctor's Notes (Internal) -->
    <div class="bg-gray-50 rounded-lg shadow p-6 border-2 border-gray-200">
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                🔒 Doctor's Notes (Internal)
            </label>
            <p class="text-xs text-gray-500 mb-3">
                Private notes for your reference only. Not visible to patient. Use for observations, reminders, or clinical reasoning.
            </p>
            <textarea 
                wire:model.blur="doctorNotes"
                rows="4"
                placeholder="Example:&#10;- Patient seems compliant, good understanding of treatment&#10;- Consider chest X-ray if symptoms persist beyond 7 days&#10;- Monitor for antibiotic resistance&#10;- Schedule follow-up to review progress"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 bg-white font-mono text-sm"></textarea>
        </div>
    </div>

    <!-- Save Status & Navigation -->
    <div class="flex items-center justify-between pt-4 border-t">
        <div class="flex items-center gap-3">
            <button type="button" wire:click="backToDiagnosis" 
                    class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded hover:bg-gray-50">
                ← Back to Diagnosis
            </button>
            <button type="button" wire:click="saveDraft" 
                    class="px-4 py-2 text-sm text-blue-600 bg-blue-50 border border-blue-200 rounded hover:bg-blue-100">
                Save Draft
            </button>
        </div>
        
        <div class="flex items-center gap-3">
            @if($lastSaved)
                <span class="text-xs text-gray-500">Last saved: {{ $lastSaved }}</span>
            @endif
            <button type="button" wire:click="completeConsultation" 
                    class="px-4 py-2 text-sm text-white bg-green-600 rounded hover:bg-green-700">
                Complete Consultation ✓
            </button>
        </div>
    </div>
</div>
