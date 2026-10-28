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
        Schema::table('users', function (Blueprint $table) {
            $table->string('specialization')->nullable()->after('role');
            $table->string('license_number')->nullable()->after('specialization');
            $table->string('ptr_number')->nullable()->after('license_number');
            $table->string('s2_number')->nullable()->after('ptr_number');
            $table->string('contact_number')->nullable()->after('s2_number');
            $table->text('clinic_address')->nullable()->after('contact_number');
            $table->string('profile_photo_path', 2048)->nullable()->after('clinic_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'specialization',
                'license_number',
                'ptr_number',
                's2_number',
                'contact_number',
                'clinic_address',
                'profile_photo_path'
            ]);
        });
    }
};
