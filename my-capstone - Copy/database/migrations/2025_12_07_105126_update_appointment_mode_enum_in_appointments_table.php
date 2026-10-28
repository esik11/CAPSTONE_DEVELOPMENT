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
        // For MySQL, we need to alter the enum column
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_mode ENUM('in-clinic', 'telemedicine', 'online', 'walk-in', 'follow-up') DEFAULT 'in-clinic'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE appointments MODIFY COLUMN appointment_mode ENUM('online', 'walk-in', 'follow-up') DEFAULT 'online'");
    }
};
