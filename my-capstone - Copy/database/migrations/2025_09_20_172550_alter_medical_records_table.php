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
        Schema::table('medical_records', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['symptoms', 'diagnosis', 'treatment', 'notes']);

            // Add new columns
            $table->text('chief_complaint')->nullable()->after('visit_date');
            $table->longText('history_of_present_illness')->nullable()->after('chief_complaint');
            $table->longText('review_of_systems')->nullable()->after('history_of_present_illness');
            $table->boolean('consent_signed')->default(false)->after('doctor_id');

            // Modify existing columns
            $table->date('visit_date')->default(DB::raw('CURRENT_DATE'))->change();

            // Remove existing foreign key and column for doctor_id, then add new nullable doctor_id and foreign key
            $table->dropForeign(['doctor_id']);
            $table->dropColumn('doctor_id');
            $table->unsignedBigInteger('doctor_id')->nullable()->after('patient_id');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_records', function (Blueprint $table) {
            // Revert new columns
            $table->dropColumn(['chief_complaint', 'history_of_present_illness', 'review_of_systems', 'consent_signed']);

            // Revert old columns (add them back as they were)
            $table->text('symptoms')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->text('notes')->nullable();

            // Revert visit_date to dateTime
            $table->dateTime('visit_date')->change();

            // Revert doctor_id (drop new, add old)
            $table->dropForeign(['doctor_id']);
            $table->dropColumn('doctor_id');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
        });
    }
};
