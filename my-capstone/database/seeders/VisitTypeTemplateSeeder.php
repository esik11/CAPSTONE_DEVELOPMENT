<?php

namespace Database\Seeders;

use App\Models\VisitTypeTemplate;
use Illuminate\Database\Seeder;

class VisitTypeTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $visitTypes = [
            [
                'visit_type_name' => 'Chronic follow up - Diabetes',
                'template_questions' => [
                    [
                        'id' => 'blood_sugar_monitoring',
                        'type' => 'radio',
                        'label' => 'Blood sugar monitoring',
                        'options' => ['Regular', 'Irregular', 'Not monitoring'],
                        'required' => true,
                    ],
                    [
                        'id' => 'medication_compliance',
                        'type' => 'radio',
                        'label' => 'Medication compliance',
                        'options' => ['Good', 'Fair', 'Poor'],
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Symptoms',
                        'options' => ['Polyuria', 'Polydipsia', 'Vision changes', 'Numbness/tingling', 'Foot problems'],
                        'required' => false,
                    ],
                    [
                        'id' => 'diet_exercise',
                        'type' => 'radio',
                        'label' => 'Diet and exercise',
                        'options' => ['Following plan', 'Partially following', 'Not following'],
                        'required' => false,
                    ],
                ],
                'required_fields' => ['blood_sugar_monitoring', 'medication_compliance'],
            ],
            
            [
                'visit_type_name' => 'Chronic follow up - Hypertension',
                'template_questions' => [
                    [
                        'id' => 'bp_monitoring',
                        'type' => 'radio',
                        'label' => 'Blood pressure monitoring at home',
                        'options' => ['Regular', 'Irregular', 'Not monitoring'],
                        'required' => true,
                    ],
                    [
                        'id' => 'medication_compliance',
                        'type' => 'radio',
                        'label' => 'Medication compliance',
                        'options' => ['Good', 'Fair', 'Poor'],
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Symptoms',
                        'options' => ['Headache', 'Dizziness', 'Chest pain', 'Shortness of breath', 'None'],
                        'required' => false,
                    ],
                    [
                        'id' => 'lifestyle',
                        'type' => 'checkbox',
                        'label' => 'Lifestyle modifications',
                        'options' => ['Low salt diet', 'Regular exercise', 'Weight management', 'Stress reduction'],
                        'required' => false,
                    ],
                ],
                'required_fields' => ['bp_monitoring', 'medication_compliance'],
            ],
            
            [
                'visit_type_name' => 'General checkup',
                'template_questions' => [
                    [
                        'id' => 'reason',
                        'type' => 'text',
                        'label' => 'Reason for checkup',
                        'placeholder' => 'e.g., Annual physical, health screening',
                        'required' => false,
                    ],
                    [
                        'id' => 'concerns',
                        'type' => 'checkbox',
                        'label' => 'Health concerns',
                        'options' => ['None', 'Weight management', 'Sleep issues', 'Stress', 'Diet', 'Exercise'],
                        'required' => false,
                    ],
                    [
                        'id' => 'screenings_due',
                        'type' => 'checkbox',
                        'label' => 'Screenings due',
                        'options' => ['Blood pressure', 'Cholesterol', 'Diabetes', 'Cancer screening', 'Immunizations'],
                        'required' => false,
                    ],
                ],
                'required_fields' => [],
            ],
            
            [
                'visit_type_name' => 'HIV first visit',
                'template_questions' => [
                    [
                        'id' => 'diagnosis_date',
                        'type' => 'text',
                        'label' => 'Date of diagnosis',
                        'placeholder' => 'e.g., 2 months ago',
                        'required' => false,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Current symptoms',
                        'options' => ['None', 'Fever', 'Weight loss', 'Fatigue', 'Night sweats', 'Opportunistic infections'],
                        'required' => false,
                    ],
                    [
                        'id' => 'treatment_status',
                        'type' => 'radio',
                        'label' => 'Treatment status',
                        'options' => ['Not started', 'Started', 'Considering options'],
                        'required' => true,
                    ],
                ],
                'required_fields' => ['treatment_status'],
            ],
            
            [
                'visit_type_name' => 'HIV follow up',
                'template_questions' => [
                    [
                        'id' => 'medication_compliance',
                        'type' => 'radio',
                        'label' => 'Medication compliance',
                        'options' => ['Good (>95%)', 'Fair (80-95%)', 'Poor (<80%)'],
                        'required' => true,
                    ],
                    [
                        'id' => 'side_effects',
                        'type' => 'checkbox',
                        'label' => 'Medication side effects',
                        'options' => ['None', 'Nausea', 'Diarrhea', 'Fatigue', 'Rash', 'Other'],
                        'required' => false,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Current symptoms',
                        'options' => ['None', 'Fever', 'Weight loss', 'Opportunistic infections'],
                        'required' => false,
                    ],
                ],
                'required_fields' => ['medication_compliance'],
            ],
            
            [
                'visit_type_name' => 'Immunisation',
                'template_questions' => [
                    [
                        'id' => 'vaccine_type',
                        'type' => 'text',
                        'label' => 'Vaccine type',
                        'placeholder' => 'e.g., Flu, COVID-19, MMR',
                        'required' => true,
                    ],
                    [
                        'id' => 'allergies',
                        'type' => 'radio',
                        'label' => 'Any allergies to vaccines?',
                        'options' => ['No', 'Yes'],
                        'required' => true,
                    ],
                    [
                        'id' => 'current_illness',
                        'type' => 'radio',
                        'label' => 'Currently ill?',
                        'options' => ['No', 'Yes - mild', 'Yes - moderate/severe'],
                        'required' => false,
                    ],
                ],
                'required_fields' => ['vaccine_type', 'allergies'],
            ],
            
            [
                'visit_type_name' => 'Pregnancy first visit',
                'template_questions' => [
                    [
                        'id' => 'lmp',
                        'type' => 'text',
                        'label' => 'Last menstrual period (LMP)',
                        'placeholder' => 'e.g., 8 weeks ago',
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Pregnancy symptoms',
                        'options' => ['Nausea/vomiting', 'Fatigue', 'Breast tenderness', 'Frequent urination', 'None'],
                        'required' => false,
                    ],
                    [
                        'id' => 'previous_pregnancies',
                        'type' => 'text',
                        'label' => 'Previous pregnancies',
                        'placeholder' => 'e.g., G2P1',
                        'required' => false,
                    ],
                    [
                        'id' => 'medications',
                        'type' => 'checkbox',
                        'label' => 'Current medications/supplements',
                        'options' => ['Prenatal vitamins', 'Folic acid', 'Other medications', 'None'],
                        'required' => false,
                    ],
                ],
                'required_fields' => ['lmp'],
            ],
            
            [
                'visit_type_name' => 'Pregnancy follow up',
                'template_questions' => [
                    [
                        'id' => 'gestational_age',
                        'type' => 'text',
                        'label' => 'Gestational age',
                        'placeholder' => 'e.g., 20 weeks',
                        'required' => true,
                    ],
                    [
                        'id' => 'fetal_movement',
                        'type' => 'radio',
                        'label' => 'Fetal movement',
                        'options' => ['Normal', 'Reduced', 'Not yet felt', 'N/A (too early)'],
                        'required' => false,
                    ],
                    [
                        'id' => 'concerns',
                        'type' => 'checkbox',
                        'label' => 'Concerns',
                        'options' => ['None', 'Bleeding', 'Abdominal pain', 'Contractions', 'Swelling', 'Headaches'],
                        'required' => false,
                    ],
                    [
                        'id' => 'compliance',
                        'type' => 'radio',
                        'label' => 'Prenatal vitamin compliance',
                        'options' => ['Good', 'Fair', 'Poor'],
                        'required' => false,
                    ],
                ],
                'required_fields' => ['gestational_age'],
            ],
        ];

        foreach ($visitTypes as $visitType) {
            VisitTypeTemplate::create($visitType);
        }
    }
}
