<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MedicalCondition;

class MedicalConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Top 10 most common conditions
        $commonConditions = [
            "Diabetes Type II",
            "Hypertension (High Blood Pressure)",
            "Asthma",
            "Dyslipidemia (High Cholesterol)",
            "Depression",
            "Hypothyroidism (Underactive Thyroid)",
            "Osteoporosis",
            "Migraines",
            "Diabetes Type I",
            "Anemia",
        ];

        // All other conditions
        $otherConditions = [
            "Abnormal EKG",
            "Angina Pectoris",
            "Bone Disease",
            "Breast Lump",
            "Cancer",
            "Coronary Artery Disease (Heart Disease)",
            "Decreased Libido",
            "Emphysema",
            "Endocrine Disorder",
            "Gallbladder Disease",
            "Heart Attack",
            "Hepatitis",
            "Hyperthyroidism (Overactive Thyroid)",
            "Impotence/ED",
            "Infertility",
            "Kidney Disease",
            "Kidney Stones",
            "Meningitis",
            "Mental Illness",
            "Nipple Discharge",
            "Phlebitis",
            "Postmenopausal Bleeding",
            "Seizures",
            "Serious Injury",
            "Stomach Ulcer",
            "Stroke",
            "Thyroid Cancer",
            "Thyroid Nodule",
            "Tuberculosis",
        ];

        // Create common conditions
        foreach ($commonConditions as $condition) {
            MedicalCondition::create([
                'condition_name' => $condition,
                'is_common' => true,
            ]);
        }

        // Create other conditions
        foreach ($otherConditions as $condition) {
            MedicalCondition::create([
                'condition_name' => $condition,
                'is_common' => false,
            ]);
        }
    }
}
