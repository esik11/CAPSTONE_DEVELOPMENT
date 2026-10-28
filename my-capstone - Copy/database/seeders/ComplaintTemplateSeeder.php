<?php

namespace Database\Seeders;

use App\Models\ComplaintTemplate;
use Illuminate\Database\Seeder;

class ComplaintTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $complaints = [
            // COMMON COMPLAINTS - ADULT & PEDIATRIC
            [
                'complaint_name' => 'Abdominal Pain',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'location',
                        'type' => 'radio',
                        'label' => 'Location',
                        'options' => ['Upper abdomen', 'Lower abdomen', 'Right side', 'Left side', 'Generalized'],
                        'required' => true,
                    ],
                    [
                        'id' => 'character',
                        'type' => 'radio',
                        'label' => 'Character',
                        'options' => ['Sharp', 'Dull', 'Cramping', 'Burning', 'Colicky'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Nausea', 'Vomiting', 'Diarrhea', 'Constipation', 'Fever', 'Bloating'],
                        'required' => false,
                    ],
                    [
                        'id' => 'severity',
                        'type' => 'radio',
                        'label' => 'Severity (1-10)',
                        'options' => ['Mild (1-3)', 'Moderate (4-6)', 'Severe (7-10)'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {location} abdominal pain for {duration}. Pain is {character} in character. Severity is {severity}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Nausea', 'Vomiting', 'Diarrhea', 'Constipation', 'Fever'],
            ],
            
            [
                'complaint_name' => 'Anxiety',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 3 months',
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Symptoms',
                        'options' => ['Excessive worry', 'Restlessness', 'Difficulty concentrating', 'Sleep disturbance', 'Panic attacks', 'Physical symptoms (palpitations, sweating)'],
                        'required' => false,
                    ],
                    [
                        'id' => 'frequency',
                        'type' => 'radio',
                        'label' => 'Frequency',
                        'options' => ['Daily', 'Several times per week', 'Occasionally', 'Rarely'],
                        'required' => false,
                    ],
                    [
                        'id' => 'impact',
                        'type' => 'checkbox',
                        'label' => 'Impact on daily life',
                        'options' => ['Work/school', 'Relationships', 'Sleep', 'Appetite'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient reports anxiety symptoms for {duration}. Experiences {symptoms} occurring {frequency}. Symptoms impact {impact}.',
                'common_symptoms' => ['Excessive worry', 'Restlessness', 'Sleep disturbance', 'Panic attacks'],
            ],
            
            [
                'complaint_name' => 'Back pain',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 1 week',
                        'required' => true,
                    ],
                    [
                        'id' => 'location',
                        'type' => 'radio',
                        'label' => 'Location',
                        'options' => ['Upper back', 'Mid back', 'Lower back', 'Radiating to legs'],
                        'required' => true,
                    ],
                    [
                        'id' => 'onset',
                        'type' => 'radio',
                        'label' => 'Onset',
                        'options' => ['Sudden', 'Gradual'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Numbness', 'Tingling', 'Weakness', 'Difficulty walking'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {location} back pain for {duration}. Onset was {onset}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Numbness', 'Tingling', 'Weakness'],
            ],
            
            [
                'complaint_name' => 'Chest pain',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 hours',
                        'required' => true,
                    ],
                    [
                        'id' => 'character',
                        'type' => 'radio',
                        'label' => 'Character',
                        'options' => ['Sharp', 'Dull', 'Crushing', 'Burning', 'Pressure'],
                        'required' => true,
                    ],
                    [
                        'id' => 'location',
                        'type' => 'radio',
                        'label' => 'Location',
                        'options' => ['Central', 'Left-sided', 'Right-sided'],
                        'required' => false,
                    ],
                    [
                        'id' => 'radiation',
                        'type' => 'checkbox',
                        'label' => 'Radiation',
                        'options' => ['Left arm', 'Right arm', 'Jaw', 'Back', 'None'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Shortness of breath', 'Diaphoresis', 'Nausea', 'Palpitations'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {character} {location} chest pain for {duration}. Radiates to {radiation}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Shortness of breath', 'Diaphoresis', 'Nausea'],
            ],
            
            [
                'complaint_name' => 'Cold/Flu',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 3 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Symptoms',
                        'options' => ['Runny nose', 'Congestion', 'Sore throat', 'Cough', 'Fever', 'Body aches', 'Headache', 'Fatigue'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with cold/flu symptoms for {duration}. Symptoms include {symptoms}.',
                'common_symptoms' => ['Runny nose', 'Congestion', 'Sore throat', 'Cough', 'Fever'],
            ],
            
            [
                'complaint_name' => 'Cough',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 5 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'type',
                        'type' => 'radio',
                        'label' => 'Type',
                        'options' => ['Dry', 'Productive'],
                        'required' => true,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Fever', 'Shortness of breath', 'Chest pain', 'Wheezing', 'Runny nose'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {type} cough for {duration}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Fever', 'Shortness of breath', 'Chest pain'],
            ],
            
            [
                'complaint_name' => 'Diarrhea',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'frequency',
                        'type' => 'text',
                        'label' => 'Frequency',
                        'placeholder' => 'e.g., 5 times per day',
                        'required' => false,
                    ],
                    [
                        'id' => 'characteristics',
                        'type' => 'checkbox',
                        'label' => 'Characteristics',
                        'options' => ['Watery', 'Bloody', 'Mucus', 'Foul-smelling'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Abdominal pain', 'Fever', 'Nausea', 'Vomiting', 'Dehydration'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with diarrhea for {duration}, occurring {frequency}. Stool is {characteristics}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Abdominal pain', 'Fever', 'Nausea'],
            ],
            
            [
                'complaint_name' => 'Fever',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'temperature',
                        'type' => 'number',
                        'label' => 'Temperature (°C)',
                        'placeholder' => 'e.g., 38.5',
                        'required' => false,
                    ],
                    [
                        'id' => 'pattern',
                        'type' => 'radio',
                        'label' => 'Pattern',
                        'options' => ['Continuous', 'Intermittent', 'Night-time only'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Chills', 'Sweats', 'Cough', 'Sore throat', 'Body aches', 'Headache'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with fever of {temperature}°C for {duration}. Pattern is {pattern}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Chills', 'Sweats', 'Cough', 'Body aches'],
            ],
            
            [
                'complaint_name' => 'Headache',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 1 day',
                        'required' => true,
                    ],
                    [
                        'id' => 'location',
                        'type' => 'radio',
                        'label' => 'Location',
                        'options' => ['Frontal', 'Temporal', 'Occipital', 'Generalized'],
                        'required' => false,
                    ],
                    [
                        'id' => 'character',
                        'type' => 'radio',
                        'label' => 'Character',
                        'options' => ['Throbbing', 'Pressure', 'Sharp', 'Dull'],
                        'required' => false,
                    ],
                    [
                        'id' => 'severity',
                        'type' => 'radio',
                        'label' => 'Severity',
                        'options' => ['Mild', 'Moderate', 'Severe'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Nausea', 'Vomiting', 'Photophobia', 'Visual changes', 'Neck stiffness'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {character} {location} headache for {duration}. Severity is {severity}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Nausea', 'Photophobia', 'Visual changes'],
            ],
            
            [
                'complaint_name' => 'Sore throat',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 3 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'severity',
                        'type' => 'radio',
                        'label' => 'Severity',
                        'options' => ['Mild', 'Moderate', 'Severe'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Fever', 'Cough', 'Difficulty swallowing', 'Runny nose', 'Headache', 'Fatigue'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with sore throat for {duration}. Severity is {severity}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Fever', 'Cough', 'Difficulty swallowing'],
            ],
            
            // Additional Adult Complaints
            [
                'complaint_name' => 'Body systems',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'system',
                        'type' => 'text',
                        'label' => 'Which body system?',
                        'placeholder' => 'e.g., Cardiovascular, Respiratory',
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'text',
                        'label' => 'Symptoms',
                        'placeholder' => 'Describe symptoms',
                        'required' => true,
                    ],
                ],
                'output_template' => 'Patient presents with {system} symptoms: {symptoms}.',
                'common_symptoms' => [],
            ],
            
            [
                'complaint_name' => 'Constipation',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 5 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'last_bowel_movement',
                        'type' => 'text',
                        'label' => 'Last bowel movement',
                        'placeholder' => 'e.g., 3 days ago',
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Abdominal pain', 'Bloating', 'Nausea', 'Loss of appetite'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with constipation for {duration}. Last bowel movement was {last_bowel_movement}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Abdominal pain', 'Bloating'],
            ],
            
            [
                'complaint_name' => 'Contraception',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'reason',
                        'type' => 'radio',
                        'label' => 'Reason for visit',
                        'options' => ['New contraception', 'Contraception review', 'Side effects', 'Change method'],
                        'required' => true,
                    ],
                    [
                        'id' => 'current_method',
                        'type' => 'text',
                        'label' => 'Current contraception method',
                        'placeholder' => 'e.g., Oral contraceptive pill',
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents for {reason}. Current method: {current_method}.',
                'common_symptoms' => [],
            ],
            
            [
                'complaint_name' => 'Depression',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 months',
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Symptoms',
                        'options' => ['Low mood', 'Loss of interest', 'Sleep disturbance', 'Appetite changes', 'Fatigue', 'Difficulty concentrating', 'Suicidal thoughts'],
                        'required' => false,
                    ],
                    [
                        'id' => 'impact',
                        'type' => 'checkbox',
                        'label' => 'Impact on daily life',
                        'options' => ['Work', 'Relationships', 'Self-care', 'Social activities'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient reports depressive symptoms for {duration}. Symptoms include {symptoms}. Impact on {impact}.',
                'common_symptoms' => ['Low mood', 'Loss of interest', 'Sleep disturbance'],
            ],
            
            [
                'complaint_name' => 'Earache',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'side',
                        'type' => 'radio',
                        'label' => 'Which ear?',
                        'options' => ['Left', 'Right', 'Both'],
                        'required' => true,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Fever', 'Discharge', 'Hearing loss', 'Dizziness'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {side} ear pain for {duration}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Fever', 'Discharge'],
            ],
            
            [
                'complaint_name' => 'Fatigue',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 weeks',
                        'required' => true,
                    ],
                    [
                        'id' => 'severity',
                        'type' => 'radio',
                        'label' => 'Severity',
                        'options' => ['Mild', 'Moderate', 'Severe'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Sleep disturbance', 'Weight changes', 'Mood changes', 'Fever'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {severity} fatigue for {duration}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Sleep disturbance', 'Weight changes'],
            ],
            
            [
                'complaint_name' => 'Gynae problem',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'problem_type',
                        'type' => 'text',
                        'label' => 'Type of problem',
                        'placeholder' => 'e.g., Irregular periods, discharge',
                        'required' => true,
                    ],
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 1 month',
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with gynecological problem: {problem_type} for {duration}.',
                'common_symptoms' => [],
            ],
            
            [
                'complaint_name' => 'Heartburn',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 1 week',
                        'required' => true,
                    ],
                    [
                        'id' => 'frequency',
                        'type' => 'radio',
                        'label' => 'Frequency',
                        'options' => ['Occasional', 'Daily', 'After meals', 'At night'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Regurgitation', 'Difficulty swallowing', 'Chest pain', 'Nausea'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with heartburn for {duration}, occurring {frequency}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Regurgitation', 'Chest pain'],
            ],
            
            [
                'complaint_name' => 'Injury',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'type',
                        'type' => 'text',
                        'label' => 'Type of injury',
                        'placeholder' => 'e.g., Sprain, fracture, cut',
                        'required' => true,
                    ],
                    [
                        'id' => 'location',
                        'type' => 'text',
                        'label' => 'Location',
                        'placeholder' => 'e.g., Right ankle',
                        'required' => true,
                    ],
                    [
                        'id' => 'mechanism',
                        'type' => 'text',
                        'label' => 'How did it happen?',
                        'placeholder' => 'e.g., Fall, sports injury',
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {type} injury to {location}. Mechanism: {mechanism}.',
                'common_symptoms' => [],
            ],
            
            [
                'complaint_name' => 'Injury - laceration',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'location',
                        'type' => 'text',
                        'label' => 'Location',
                        'placeholder' => 'e.g., Left hand',
                        'required' => true,
                    ],
                    [
                        'id' => 'size',
                        'type' => 'text',
                        'label' => 'Size',
                        'placeholder' => 'e.g., 3 cm',
                        'required' => false,
                    ],
                    [
                        'id' => 'mechanism',
                        'type' => 'text',
                        'label' => 'How did it happen?',
                        'placeholder' => 'e.g., Knife, glass',
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with laceration to {location}, approximately {size}. Mechanism: {mechanism}.',
                'common_symptoms' => [],
            ],
            
            [
                'complaint_name' => 'Insomnia',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 weeks',
                        'required' => true,
                    ],
                    [
                        'id' => 'type',
                        'type' => 'checkbox',
                        'label' => 'Type',
                        'options' => ['Difficulty falling asleep', 'Difficulty staying asleep', 'Early morning waking'],
                        'required' => false,
                    ],
                    [
                        'id' => 'impact',
                        'type' => 'checkbox',
                        'label' => 'Impact',
                        'options' => ['Daytime fatigue', 'Mood changes', 'Concentration problems'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient reports insomnia for {duration}. Type: {type}. Impact includes {impact}.',
                'common_symptoms' => ['Daytime fatigue', 'Mood changes'],
            ],
            
            [
                'complaint_name' => 'Joint pain and swelling',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'location',
                        'type' => 'text',
                        'label' => 'Which joint(s)?',
                        'placeholder' => 'e.g., Right knee',
                        'required' => true,
                    ],
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 3 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'characteristics',
                        'type' => 'checkbox',
                        'label' => 'Characteristics',
                        'options' => ['Swelling', 'Redness', 'Warmth', 'Stiffness', 'Limited movement'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {location} joint pain for {duration}. Characteristics include {characteristics}.',
                'common_symptoms' => ['Swelling', 'Stiffness'],
            ],
            
            [
                'complaint_name' => 'Joint swelling',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'location',
                        'type' => 'text',
                        'label' => 'Which joint(s)?',
                        'placeholder' => 'e.g., Both ankles',
                        'required' => true,
                    ],
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 1 week',
                        'required' => true,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Pain', 'Redness', 'Warmth', 'Stiffness'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {location} joint swelling for {duration}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Pain', 'Stiffness'],
            ],
            
            [
                'complaint_name' => 'Muscle pain',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'location',
                        'type' => 'text',
                        'label' => 'Location',
                        'placeholder' => 'e.g., Legs, back',
                        'required' => true,
                    ],
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'onset',
                        'type' => 'radio',
                        'label' => 'Onset',
                        'options' => ['After exercise', 'Gradual', 'Sudden', 'Unknown'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with {location} muscle pain for {duration}. Onset was {onset}.',
                'common_symptoms' => [],
            ],
            
            [
                'complaint_name' => 'Nausea vomiting',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 1 day',
                        'required' => true,
                    ],
                    [
                        'id' => 'frequency',
                        'type' => 'text',
                        'label' => 'Frequency of vomiting',
                        'placeholder' => 'e.g., 3 times',
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Abdominal pain', 'Diarrhea', 'Fever', 'Headache', 'Dizziness'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with nausea and vomiting for {duration}, occurring {frequency}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Abdominal pain', 'Diarrhea', 'Fever'],
            ],
            
            [
                'complaint_name' => 'Neck pain',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 3 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'onset',
                        'type' => 'radio',
                        'label' => 'Onset',
                        'options' => ['Sudden', 'Gradual'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Headache', 'Shoulder pain', 'Numbness/tingling', 'Stiffness'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with neck pain for {duration}. Onset was {onset}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Headache', 'Stiffness'],
            ],
            
            [
                'complaint_name' => 'Palpitations',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 hours',
                        'required' => true,
                    ],
                    [
                        'id' => 'frequency',
                        'type' => 'radio',
                        'label' => 'Frequency',
                        'options' => ['Constant', 'Intermittent', 'First episode'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Chest pain', 'Shortness of breath', 'Dizziness', 'Syncope'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with palpitations for {duration}, {frequency}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Chest pain', 'Shortness of breath', 'Dizziness'],
            ],
            
            [
                'complaint_name' => 'Rash',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'location',
                        'type' => 'text',
                        'label' => 'Location',
                        'placeholder' => 'e.g., Arms, trunk',
                        'required' => true,
                    ],
                    [
                        'id' => 'characteristics',
                        'type' => 'checkbox',
                        'label' => 'Characteristics',
                        'options' => ['Itchy', 'Painful', 'Spreading', 'Blistering'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Fever', 'Swelling', 'Discharge'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with rash on {location} for {duration}. Characteristics: {characteristics}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Itchy', 'Fever'],
            ],
            
            [
                'complaint_name' => 'Urinary tract infection',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Duration',
                        'placeholder' => 'e.g., 2 days',
                        'required' => true,
                    ],
                    [
                        'id' => 'symptoms',
                        'type' => 'checkbox',
                        'label' => 'Symptoms',
                        'options' => ['Burning on urination', 'Frequency', 'Urgency', 'Blood in urine', 'Lower abdominal pain', 'Fever'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient presents with urinary symptoms for {duration}. Symptoms include {symptoms}.',
                'common_symptoms' => ['Burning on urination', 'Frequency', 'Urgency'],
            ],
            
            [
                'complaint_name' => 'Weight gain',
                'category' => 'adult',
                'template_questions' => [
                    [
                        'id' => 'amount',
                        'type' => 'text',
                        'label' => 'Amount gained',
                        'placeholder' => 'e.g., 5 kg',
                        'required' => false,
                    ],
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Over what period?',
                        'placeholder' => 'e.g., 3 months',
                        'required' => true,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Fatigue', 'Mood changes', 'Appetite changes', 'Swelling'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient reports weight gain of {amount} over {duration}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Fatigue', 'Mood changes'],
            ],
            
            [
                'complaint_name' => 'Weight loss',
                'category' => 'both',
                'template_questions' => [
                    [
                        'id' => 'amount',
                        'type' => 'text',
                        'label' => 'Amount lost',
                        'placeholder' => 'e.g., 5 kg',
                        'required' => false,
                    ],
                    [
                        'id' => 'duration',
                        'type' => 'text',
                        'label' => 'Over what period?',
                        'placeholder' => 'e.g., 2 months',
                        'required' => true,
                    ],
                    [
                        'id' => 'intentional',
                        'type' => 'radio',
                        'label' => 'Intentional?',
                        'options' => ['Yes', 'No'],
                        'required' => false,
                    ],
                    [
                        'id' => 'associated_symptoms',
                        'type' => 'checkbox',
                        'label' => 'Associated symptoms',
                        'options' => ['Appetite loss', 'Fatigue', 'Fever', 'Night sweats'],
                        'required' => false,
                    ],
                ],
                'output_template' => 'Patient reports {intentional} weight loss of {amount} over {duration}. Associated symptoms include {associated_symptoms}.',
                'common_symptoms' => ['Appetite loss', 'Fatigue'],
            ],
        ];

        foreach ($complaints as $complaint) {
            ComplaintTemplate::create($complaint);
        }
    }
}
