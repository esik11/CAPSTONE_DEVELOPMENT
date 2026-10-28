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
        Schema::table('diagnostic_tests', function (Blueprint $table) {
            // Make doctor_id nullable so patients/assistants can upload without a doctor
            $table->foreignId('doctor_id')->nullable()->change();

            // Track who uploaded the lab result
            $table->foreignId('uploaded_by')->nullable()->after('consultation_id')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnostic_tests', function (Blueprint $table) {
            $table->dropForeign(['uploaded_by']);
            $table->dropColumn('uploaded_by');
            $table->foreignId('doctor_id')->nullable(false)->change();
        });
    }
};
