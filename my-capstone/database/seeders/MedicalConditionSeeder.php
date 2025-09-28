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
        $conditions = [
            "Abnormal EKG",
            "Anemia",
            "Angina Pectoris",
            "Asthma",
            "Bone Disease",
            "Breast Lump",
            "Cancer",
            "Coronary Artery Disease (Heart Disease)",
            "Decreased Libido",
            "Depression",
            "Diabetes Type I",
            "Diabetes Type II",
            "Dyslipidemia (High Cholesterol)",
            "Emphysema",
            "Endocrine Disorder",
            "Gallbladder Disease",
            "Heart Attack",
            "Hepatitis",
            "Hypertension (High Blood Pressure)",
            "Hyperthyroidism (Overactive Thyroid)",
            "Hypothyroidism (Underactive Thyroid)",
            "Impotence/ED",
            "Infertility",
            "Kidney Disease",
            "Kidney Stones",
            "Meningitis",
            "Mental Illness",
            "Migraines",
            "Nipple Discharge",
            "Osteoporosis",
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

        foreach ($conditions as $condition) {
            MedicalCondition::create(['condition_name' => $condition]);
        }
    }
}
