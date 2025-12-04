<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $medicines = [
            // Antibiotics
            ['name' => 'Amoxicillin', 'strength' => '500mg', 'form' => 'Capsule', 'is_common' => true],
            ['name' => 'Amoxicillin', 'strength' => '250mg', 'form' => 'Capsule', 'is_common' => true],
            ['name' => 'Azithromycin', 'strength' => '500mg', 'form' => 'Tablet', 'is_common' => true],
            ['name' => 'Ciprofloxacin', 'strength' => '500mg', 'form' => 'Tablet', 'is_common' => false],
            ['name' => 'Cephalexin', 'strength' => '500mg', 'form' => 'Capsule', 'is_common' => false],
            
            // Pain relievers
            ['name' => 'Paracetamol', 'strength' => '500mg', 'form' => 'Tablet', 'is_common' => true],
            ['name' => 'Ibuprofen', 'strength' => '400mg', 'form' => 'Tablet', 'is_common' => true],
            ['name' => 'Mefenamic Acid', 'strength' => '500mg', 'form' => 'Capsule', 'is_common' => true],
            
            // Antihistamines
            ['name' => 'Cetirizine', 'strength' => '10mg', 'form' => 'Tablet', 'is_common' => true],
            ['name' => 'Loratadine', 'strength' => '10mg', 'form' => 'Tablet', 'is_common' => true],
            
            // Cough & Cold
            ['name' => 'Carbocisteine', 'strength' => '500mg', 'form' => 'Capsule', 'is_common' => true],
            ['name' => 'Salbutamol', 'strength' => '2mg', 'form' => 'Tablet', 'is_common' => false],
            
            // Gastrointestinal
            ['name' => 'Omeprazole', 'strength' => '20mg', 'form' => 'Capsule', 'is_common' => true],
            ['name' => 'Ranitidine', 'strength' => '150mg', 'form' => 'Tablet', 'is_common' => false],
            ['name' => 'Loperamide', 'strength' => '2mg', 'form' => 'Capsule', 'is_common' => false],
            
            // Vitamins
            ['name' => 'Vitamin C', 'strength' => '500mg', 'form' => 'Tablet', 'is_common' => true],
            ['name' => 'Multivitamins', 'strength' => null, 'form' => 'Tablet', 'is_common' => true],
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
