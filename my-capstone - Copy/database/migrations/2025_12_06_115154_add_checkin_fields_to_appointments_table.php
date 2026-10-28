<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->timestamp('checked_in_at')->nullable()->after('status');
            $table->timestamp('consultation_started_at')->nullable()->after('checked_in_at');
            $table->timestamp('completed_at')->nullable()->after('consultation_started_at');
        });
        
        // Update status enum to include new statuses
        DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending', 'confirmed', 'checked_in', 'in_progress', 'completed', 'cancelled', 'declined', 'no_show') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['checked_in_at', 'consultation_started_at', 'completed_at']);
        });
        
        // Revert status enum
        DB::statement("ALTER TABLE appointments MODIFY COLUMN status ENUM('pending', 'approved', 'declined', 'rescheduled', 'completed', 'cancelled') DEFAULT 'pending'");
    }
};
