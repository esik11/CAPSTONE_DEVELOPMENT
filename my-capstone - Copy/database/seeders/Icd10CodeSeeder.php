<?php

namespace Database\Seeders;

use App\Models\Icd10Code;
use Illuminate\Database\Seeder;

class Icd10CodeSeeder extends Seeder
{
    public function run(): void
    {
        $codes = [
            // RESPIRATORY INFECTIONS (Very Common)
            ['code' => 'J00', 'description' => 'Acute nasopharyngitis (common cold)', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'J01.90', 'description' => 'Acute sinusitis, unspecified', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'J02.9', 'description' => 'Acute pharyngitis, unspecified', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'J03.90', 'description' => 'Acute tonsillitis, unspecified', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'J06.9', 'description' => 'Acute upper respiratory infection, unspecified', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'J20.9', 'description' => 'Acute bronchitis, unspecified', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'J18.9', 'description' => 'Pneumonia, unspecified organism', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'J45.909', 'description' => 'Unspecified asthma, uncomplicated', 'category' => 'Respiratory', 'is_common' => true],
            
            // HYPERTENSION (Very Common)
            ['code' => 'I10', 'description' => 'Essential (primary) hypertension', 'category' => 'Cardiovascular', 'is_common' => true],
            ['code' => 'I11.9', 'description' => 'Hypertensive heart disease without heart failure', 'category' => 'Cardiovascular', 'is_common' => false],
            
            // DIABETES (Very Common)
            ['code' => 'E11.9', 'description' => 'Type 2 diabetes mellitus without complications', 'category' => 'Endocrine', 'is_common' => true],
            ['code' => 'E11.65', 'description' => 'Type 2 diabetes mellitus with hyperglycemia', 'category' => 'Endocrine', 'is_common' => true],
            ['code' => 'E10.9', 'description' => 'Type 1 diabetes mellitus without complications', 'category' => 'Endocrine', 'is_common' => false],
            
            // GASTROINTESTINAL (Common)
            ['code' => 'K21.9', 'description' => 'Gastro-esophageal reflux disease without esophagitis', 'category' => 'Gastrointestinal', 'is_common' => true],
            ['code' => 'K29.70', 'description' => 'Gastritis, unspecified, without bleeding', 'category' => 'Gastrointestinal', 'is_common' => true],
            ['code' => 'K59.00', 'description' => 'Constipation, unspecified', 'category' => 'Gastrointestinal', 'is_common' => true],
            ['code' => 'A09', 'description' => 'Infectious gastroenteritis and colitis, unspecified', 'category' => 'Gastrointestinal', 'is_common' => true],
            
            // MUSCULOSKELETAL (Common)
            ['code' => 'M25.50', 'description' => 'Pain in unspecified joint', 'category' => 'Musculoskeletal', 'is_common' => true],
            ['code' => 'M54.5', 'description' => 'Low back pain', 'category' => 'Musculoskeletal', 'is_common' => true],
            ['code' => 'M79.1', 'description' => 'Myalgia', 'category' => 'Musculoskeletal', 'is_common' => true],
            
            // SKIN CONDITIONS (Common)
            ['code' => 'L30.9', 'description' => 'Dermatitis, unspecified', 'category' => 'Dermatology', 'is_common' => true],
            ['code' => 'L50.9', 'description' => 'Urticaria, unspecified', 'category' => 'Dermatology', 'is_common' => false],
            
            // HEADACHES (Common)
            ['code' => 'R51', 'description' => 'Headache', 'category' => 'Neurological', 'is_common' => true],
            ['code' => 'G43.909', 'description' => 'Migraine, unspecified, not intractable, without status migrainosus', 'category' => 'Neurological', 'is_common' => true],
            
            // FEVER & GENERAL SYMPTOMS (Very Common)
            ['code' => 'R50.9', 'description' => 'Fever, unspecified', 'category' => 'General', 'is_common' => true],
            ['code' => 'R05', 'description' => 'Cough', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'R06.02', 'description' => 'Shortness of breath', 'category' => 'Respiratory', 'is_common' => true],
            ['code' => 'R11.0', 'description' => 'Nausea', 'category' => 'Gastrointestinal', 'is_common' => true],
            ['code' => 'R11.10', 'description' => 'Vomiting, unspecified', 'category' => 'Gastrointestinal', 'is_common' => true],
            ['code' => 'R19.7', 'description' => 'Diarrhea, unspecified', 'category' => 'Gastrointestinal', 'is_common' => true],
            
            // INJURIES (Common)
            ['code' => 'S61.9', 'description' => 'Open wound of wrist, hand and fingers', 'category' => 'Injury', 'is_common' => true],
            ['code' => 'T14.90', 'description' => 'Injury, unspecified', 'category' => 'Injury', 'is_common' => false],
        ];

        foreach ($codes as $code) {
            Icd10Code::create($code);
        }
    }
}
