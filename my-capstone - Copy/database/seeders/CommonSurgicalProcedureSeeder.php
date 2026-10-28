<?php

namespace Database\Seeders;

use App\Models\CommonSurgicalProcedure;
use Illuminate\Database\Seeder;

class CommonSurgicalProcedureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $procedures = [
            // General Surgery
            ['name' => 'Appendectomy', 'category' => 'General Surgery', 'description' => 'Removal of the appendix'],
            ['name' => 'Cholecystectomy', 'category' => 'General Surgery', 'description' => 'Removal of the gallbladder'],
            ['name' => 'Hernia Repair', 'category' => 'General Surgery', 'description' => 'Repair of inguinal, umbilical, or other hernias'],
            ['name' => 'Hemorrhoidectomy', 'category' => 'General Surgery', 'description' => 'Removal of hemorrhoids'],
            ['name' => 'Mastectomy', 'category' => 'General Surgery', 'description' => 'Removal of breast tissue'],
            ['name' => 'Thyroidectomy', 'category' => 'General Surgery', 'description' => 'Removal of thyroid gland'],
            
            // Orthopedic Surgery
            ['name' => 'Total Knee Replacement', 'category' => 'Orthopedic', 'description' => 'Replacement of knee joint'],
            ['name' => 'Total Hip Replacement', 'category' => 'Orthopedic', 'description' => 'Replacement of hip joint'],
            ['name' => 'ACL Reconstruction', 'category' => 'Orthopedic', 'description' => 'Repair of anterior cruciate ligament'],
            ['name' => 'Spinal Fusion', 'category' => 'Orthopedic', 'description' => 'Fusion of vertebrae'],
            ['name' => 'Carpal Tunnel Release', 'category' => 'Orthopedic', 'description' => 'Release of carpal tunnel'],
            ['name' => 'Rotator Cuff Repair', 'category' => 'Orthopedic', 'description' => 'Repair of shoulder rotator cuff'],
            
            // Cardiovascular Surgery
            ['name' => 'Coronary Artery Bypass Graft (CABG)', 'category' => 'Cardiovascular', 'description' => 'Bypass surgery for blocked arteries'],
            ['name' => 'Angioplasty', 'category' => 'Cardiovascular', 'description' => 'Opening of blocked blood vessels'],
            ['name' => 'Pacemaker Insertion', 'category' => 'Cardiovascular', 'description' => 'Implantation of cardiac pacemaker'],
            ['name' => 'Heart Valve Replacement', 'category' => 'Cardiovascular', 'description' => 'Replacement of heart valve'],
            
            // Gynecological Surgery
            ['name' => 'Hysterectomy', 'category' => 'Gynecological', 'description' => 'Removal of uterus'],
            ['name' => 'Cesarean Section (C-Section)', 'category' => 'Gynecological', 'description' => 'Surgical delivery of baby'],
            ['name' => 'Tubal Ligation', 'category' => 'Gynecological', 'description' => 'Female sterilization procedure'],
            ['name' => 'Ovarian Cystectomy', 'category' => 'Gynecological', 'description' => 'Removal of ovarian cyst'],
            ['name' => 'Myomectomy', 'category' => 'Gynecological', 'description' => 'Removal of uterine fibroids'],
            
            // Urological Surgery
            ['name' => 'Prostatectomy', 'category' => 'Urological', 'description' => 'Removal of prostate gland'],
            ['name' => 'Kidney Stone Removal', 'category' => 'Urological', 'description' => 'Removal of kidney stones'],
            ['name' => 'Vasectomy', 'category' => 'Urological', 'description' => 'Male sterilization procedure'],
            ['name' => 'Cystoscopy', 'category' => 'Urological', 'description' => 'Examination of bladder'],
            ['name' => 'Nephrectomy', 'category' => 'Urological', 'description' => 'Removal of kidney'],
            
            // Ophthalmic Surgery
            ['name' => 'Cataract Surgery', 'category' => 'Ophthalmic', 'description' => 'Removal of clouded lens'],
            ['name' => 'LASIK', 'category' => 'Ophthalmic', 'description' => 'Laser eye surgery for vision correction'],
            ['name' => 'Glaucoma Surgery', 'category' => 'Ophthalmic', 'description' => 'Surgery to reduce eye pressure'],
            ['name' => 'Retinal Detachment Repair', 'category' => 'Ophthalmic', 'description' => 'Repair of detached retina'],
            
            // ENT Surgery
            ['name' => 'Tonsillectomy', 'category' => 'ENT', 'description' => 'Removal of tonsils'],
            ['name' => 'Adenoidectomy', 'category' => 'ENT', 'description' => 'Removal of adenoids'],
            ['name' => 'Septoplasty', 'category' => 'ENT', 'description' => 'Correction of deviated septum'],
            ['name' => 'Tympanoplasty', 'category' => 'ENT', 'description' => 'Repair of eardrum'],
            ['name' => 'Sinus Surgery', 'category' => 'ENT', 'description' => 'Surgery for chronic sinusitis'],
            
            // Gastrointestinal Surgery
            ['name' => 'Colonoscopy with Polypectomy', 'category' => 'Gastrointestinal', 'description' => 'Removal of colon polyps'],
            ['name' => 'Gastric Bypass', 'category' => 'Gastrointestinal', 'description' => 'Weight loss surgery'],
            ['name' => 'Colectomy', 'category' => 'Gastrointestinal', 'description' => 'Removal of part of colon'],
            ['name' => 'Endoscopy', 'category' => 'Gastrointestinal', 'description' => 'Examination of digestive tract'],
            
            // Plastic/Cosmetic Surgery
            ['name' => 'Rhinoplasty', 'category' => 'Plastic Surgery', 'description' => 'Nose reshaping surgery'],
            ['name' => 'Liposuction', 'category' => 'Plastic Surgery', 'description' => 'Fat removal procedure'],
            ['name' => 'Breast Augmentation', 'category' => 'Plastic Surgery', 'description' => 'Breast enlargement surgery'],
            ['name' => 'Facelift', 'category' => 'Plastic Surgery', 'description' => 'Facial rejuvenation surgery'],
            
            // Neurosurgery
            ['name' => 'Craniotomy', 'category' => 'Neurosurgery', 'description' => 'Opening of skull for brain surgery'],
            ['name' => 'Laminectomy', 'category' => 'Neurosurgery', 'description' => 'Removal of part of vertebra'],
            ['name' => 'Brain Tumor Resection', 'category' => 'Neurosurgery', 'description' => 'Removal of brain tumor'],
            
            // Dental Surgery
            ['name' => 'Tooth Extraction', 'category' => 'Dental', 'description' => 'Removal of tooth'],
            ['name' => 'Wisdom Teeth Removal', 'category' => 'Dental', 'description' => 'Extraction of wisdom teeth'],
            ['name' => 'Dental Implant', 'category' => 'Dental', 'description' => 'Implantation of artificial tooth'],
            ['name' => 'Root Canal', 'category' => 'Dental', 'description' => 'Treatment of infected tooth pulp'],
        ];

        foreach ($procedures as $procedure) {
            CommonSurgicalProcedure::create($procedure);
        }
    }
}
