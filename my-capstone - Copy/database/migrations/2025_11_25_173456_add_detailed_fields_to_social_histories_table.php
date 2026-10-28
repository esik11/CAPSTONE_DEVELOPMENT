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
        Schema::table('social_histories', function (Blueprint $table) {
            // Parents marital status
            $table->string('parents_status')->nullable()->after('medical_record_id');
            $table->text('parents_comments')->nullable()->after('parents_status');
            
            // Detailed smoking fields
            $table->integer('smoking_years')->nullable()->after('smoking');
            $table->integer('smoking_daily_cigarettes')->nullable()->after('smoking_years');
            $table->text('smoking_comments')->nullable()->after('smoking_daily_cigarettes');
            
            // Detailed alcohol fields
            $table->text('alcohol_comments')->nullable()->after('alcohol');
            
            // Detailed drug use fields
            $table->text('drug_type')->nullable()->after('drug_use');
            $table->text('drug_comments')->nullable()->after('drug_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_histories', function (Blueprint $table) {
            $table->dropColumn([
                'parents_status',
                'parents_comments',
                'smoking_years',
                'smoking_daily_cigarettes',
                'smoking_comments',
                'alcohol_comments',
                'drug_type',
                'drug_comments'
            ]);
        });
    }
};
