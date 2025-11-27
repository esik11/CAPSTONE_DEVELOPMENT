<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if old columns exist before dropping
        $columns = Schema::getColumnListing('allergies');
        
        if (in_array('allergy_type', $columns)) {
            Schema::table('allergies', function (Blueprint $table) {
                $table->dropColumn(['allergy_type', 'description', 'reaction']);
            });
        }
        
        // Add new columns if they don't exist
        if (!in_array('allergen_name', $columns)) {
            Schema::table('allergies', function (Blueprint $table) {
                $table->string('allergen_name')->after('medical_record_id');
                $table->enum('type', ['medication', 'non_medication'])->after('allergen_name');
                $table->enum('severity', ['mild', 'moderate', 'severe'])->nullable()->after('type');
            });
        }
    }

    public function down(): void
    {
        $columns = Schema::getColumnListing('allergies');
        
        if (in_array('allergen_name', $columns)) {
            Schema::table('allergies', function (Blueprint $table) {
                $table->dropColumn(['allergen_name', 'type', 'severity']);
            });
        }
        
        if (!in_array('allergy_type', $columns)) {
            Schema::table('allergies', function (Blueprint $table) {
                $table->enum('allergy_type', ['drug', 'food', 'environment', 'other'])->after('medical_record_id');
                $table->string('description')->after('allergy_type');
                $table->text('reaction')->nullable()->after('description');
            });
        }
    }
};
