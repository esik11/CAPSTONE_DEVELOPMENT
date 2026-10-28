<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, update any existing 'telemedicine' appointments to 'online'
        DB::statement("UPDATE appointments SET appointment_mode = 'online' WHERE appointment_mode = 'telemedicine'");
        
        // Then, alter the enum to remove 'telemedicine'
        // Keep: 'in-clinic', 'online', 'walk-in', 'follow-up'
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_mode ENUM('in-clinic', 'online', 'walk-in', 'follow-up') DEFAULT 'in-clinic'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the original enum with 'telemedicine'
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_mode ENUM('in-clinic', 'telemedicine', 'online', 'walk-in', 'follow-up') DEFAULT 'in-clinic'");
    }
};
