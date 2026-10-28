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
        Schema::table('patients', function (Blueprint $table) {
            // Emergency/Next of Kin Contact Information
            $table->string('emergency_last_name')->nullable();
            $table->string('emergency_first_name')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->text('emergency_address')->nullable();
            $table->string('emergency_apt_num')->nullable();
            $table->string('emergency_city')->nullable();
            $table->string('emergency_state')->nullable();
            $table->string('emergency_zip_code')->nullable();
            $table->string('emergency_home_phone')->nullable();
            $table->string('emergency_work_phone')->nullable();
            $table->string('emergency_other_phone')->nullable();
            $table->boolean('emergency_other_phone_cell')->default(false)->nullable();
            $table->boolean('emergency_other_phone_pager')->default(false)->nullable();
            $table->boolean('emergency_other_phone_fax')->default(false)->nullable();

            // Other Contact Information (Not Living with Patient)
            $table->string('other_last_name')->nullable();
            $table->string('other_first_name')->nullable();
            $table->string('other_relationship')->nullable();
            $table->text('other_address')->nullable();
            $table->string('other_apt_num')->nullable();
            $table->string('other_city')->nullable();
            $table->string('other_state')->nullable();
            $table->string('other_zip_code')->nullable();
            $table->string('other_home_phone')->nullable();
            $table->string('other_work_phone')->nullable();
            $table->string('other_other_phone')->nullable();
            $table->boolean('other_other_phone_cell')->default(false)->nullable();
            $table->boolean('other_other_phone_pager')->default(false)->nullable();
            $table->boolean('other_other_phone_fax')->default(false)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'emergency_last_name',
                'emergency_first_name',
                'emergency_relationship',
                'emergency_address',
                'emergency_apt_num',
                'emergency_city',
                'emergency_state',
                'emergency_zip_code',
                'emergency_home_phone',
                'emergency_work_phone',
                'emergency_other_phone',
                'emergency_other_phone_cell',
                'emergency_other_phone_pager',
                'emergency_other_phone_fax',
                'other_last_name',
                'other_first_name',
                'other_relationship',
                'other_address',
                'other_apt_num',
                'other_city',
                'other_state',
                'other_zip_code',
                'other_home_phone',
                'other_work_phone',
                'other_other_phone',
                'other_other_phone_cell',
                'other_other_phone_pager',
                'other_other_phone_fax',
            ]);
        });
    }
};
