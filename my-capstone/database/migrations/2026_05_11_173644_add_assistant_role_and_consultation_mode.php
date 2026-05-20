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
        // Add consultation_mode to consultations table
        Schema::table('consultations', function (Blueprint $table) {
            $table->enum('consultation_mode', ['in-clinic', 'online'])
                  ->default('in-clinic')
                  ->after('consultation_time');
        });
        
        // Note: users.role is already a string field, so we don't need to modify it
        // The 'assistant' role will be handled at the application level
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove consultation_mode from consultations table
        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn('consultation_mode');
        });
    }
};
