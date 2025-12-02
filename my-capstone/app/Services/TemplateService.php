<?php

namespace App\Services;

use App\Models\ComplaintTemplate;
use App\Models\VisitTypeTemplate;
use Illuminate\Support\Collection;

class TemplateService
{
    /**
     * Get a complaint template by name and category
     */
    public function getComplaintTemplate(string $complaintName, ?string $category = null): ?ComplaintTemplate
    {
        $query = ComplaintTemplate::where('complaint_name', $complaintName);
        
        if ($category) {
            $query->byCategory($category);
        }
        
        return $query->first();
    }

    /**
     * Get all complaint templates for a specific category
     */
    public function getComplaintsByCategory(string $category): Collection
    {
        return ComplaintTemplate::byCategory($category)
            ->orderBy('complaint_name')
            ->get();
    }

    /**
     * Get a visit type template by name
     */
    public function getVisitTypeTemplate(string $visitTypeName): ?VisitTypeTemplate
    {
        return VisitTypeTemplate::where('visit_type_name', $visitTypeName)->first();
    }

    /**
     * Get all visit type templates
     */
    public function getAllVisitTypes(): Collection
    {
        return VisitTypeTemplate::orderBy('visit_type_name')->get();
    }

    /**
     * Merge multiple complaint templates into a single unified template
     * This combines questions from multiple complaints, avoiding duplicates
     */
    public function mergeTemplates(array $complaintNames, ?string $category = null): array
    {
        $templates = ComplaintTemplate::whereIn('complaint_name', $complaintNames);
        
        if ($category) {
            $templates->byCategory($category);
        }
        
        $templates = $templates->get();
        
        if ($templates->isEmpty()) {
            return [
                'questions' => [],
                'output_templates' => [],
            ];
        }

        $mergedQuestions = [];
        $outputTemplates = [];
        $seenQuestionIds = [];

        foreach ($templates as $template) {
            // Collect output templates
            $outputTemplates[$template->complaint_name] = $template->output_template;
            
            // Merge questions, avoiding duplicates based on question ID
            foreach ($template->template_questions as $question) {
                $questionId = $question['id'];
                
                // If we've seen this question ID before, skip it (avoid duplicates)
                if (in_array($questionId, $seenQuestionIds)) {
                    continue;
                }
                
                $seenQuestionIds[] = $questionId;
                
                // Prefix the question ID with complaint name to make it unique
                $question['id'] = $template->complaint_name . '_' . $questionId;
                $question['complaint'] = $template->complaint_name;
                
                $mergedQuestions[] = $question;
            }
        }

        return [
            'questions' => $mergedQuestions,
            'output_templates' => $outputTemplates,
        ];
    }

    /**
     * Generate clinical notes from template responses
     * This is the core function that creates the auto-generated documentation
     */
    public function generateNotes(array $selectedComplaints, array $templateResponses, ?string $visitType = null): string
    {
        $notes = [];

        // Generate notes for each selected complaint
        foreach ($selectedComplaints as $complaintName) {
            $template = $this->getComplaintTemplate($complaintName);
            
            if (!$template) {
                continue;
            }

            $note = $this->generateNoteFromTemplate(
                $template->output_template,
                $templateResponses,
                $complaintName
            );
            
            if (!empty($note)) {
                $notes[] = $note;
            }
        }

        // Generate notes for visit type if provided
        if ($visitType) {
            $visitTemplate = $this->getVisitTypeTemplate($visitType);
            
            if ($visitTemplate) {
                $visitNote = $this->generateNoteFromTemplate(
                    "Visit Type: {$visitType}",
                    $templateResponses,
                    $visitType
                );
                
                if (!empty($visitNote)) {
                    array_unshift($notes, $visitNote);
                }
            }
        }

        return implode("\n\n", $notes);
    }

    /**
     * Generate a single note from a template and responses
     */
    private function generateNoteFromTemplate(string $template, array $responses, string $complaintName): string
    {
        $note = $template;
        
        // Find all placeholders in the template (e.g., {duration}, {location})
        preg_match_all('/\{([^}]+)\}/', $template, $matches);
        
        if (empty($matches[1])) {
            return $note;
        }

        // Replace each placeholder with the actual response
        foreach ($matches[1] as $placeholder) {
            // Try with complaint prefix first
            $key = $complaintName . '_' . $placeholder;
            
            // If not found, try without prefix
            if (!isset($responses[$key])) {
                $key = $placeholder;
            }
            
            // Get the response value
            $value = $responses[$key] ?? '';
            
            // Format the value based on its type
            $formattedValue = $this->formatResponseValue($value);
            
            // Replace the placeholder
            $note = str_replace('{' . $placeholder . '}', $formattedValue, $note);
        }

        // Clean up any remaining unfilled placeholders
        $note = preg_replace('/\{[^}]+\}/', '[not specified]', $note);
        
        // Clean up extra spaces and punctuation
        $note = preg_replace('/\s+/', ' ', $note);
        $note = str_replace(' .', '.', $note);
        $note = str_replace(' ,', ',', $note);
        
        return trim($note);
    }

    /**
     * Format a response value for display in clinical notes
     */
    private function formatResponseValue($value): string
    {
        if (is_array($value)) {
            // For checkbox arrays, join with commas
            return implode(', ', array_filter($value));
        }
        
        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }
        
        if (is_null($value) || $value === '') {
            return '[not specified]';
        }
        
        return (string) $value;
    }

    /**
     * Validate template responses against required fields
     */
    public function validateResponses(array $selectedComplaints, array $templateResponses): array
    {
        $errors = [];

        foreach ($selectedComplaints as $complaintName) {
            $template = $this->getComplaintTemplate($complaintName);
            
            if (!$template) {
                continue;
            }

            foreach ($template->template_questions as $question) {
                if (!($question['required'] ?? false)) {
                    continue;
                }

                $key = $complaintName . '_' . $question['id'];
                
                if (!isset($templateResponses[$key]) || empty($templateResponses[$key])) {
                    $errors[$key] = "The {$question['label']} field is required for {$complaintName}.";
                }
            }
        }

        return $errors;
    }

    /**
     * Get common symptoms for selected complaints
     */
    public function getCommonSymptoms(array $complaintNames): array
    {
        $templates = ComplaintTemplate::whereIn('complaint_name', $complaintNames)->get();
        
        $allSymptoms = [];
        
        foreach ($templates as $template) {
            if (!empty($template->common_symptoms)) {
                $allSymptoms = array_merge($allSymptoms, $template->common_symptoms);
            }
        }
        
        // Remove duplicates and return
        return array_values(array_unique($allSymptoms));
    }
}
