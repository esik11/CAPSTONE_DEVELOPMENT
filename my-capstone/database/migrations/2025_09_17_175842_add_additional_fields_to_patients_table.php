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
            // Add new columns
            $table->string('middle_name')->nullable()->after('first_name');
            $table->string('nickname')->nullable()->after('middle_name');
            $table->string('social_security_number')->nullable()->unique()->after('date_of_birth');
            $table->string('marital_status')->nullable()->after('gender');
            $table->string('language')->nullable()->after('marital_status');
            $table->string('race')->nullable()->after('language');
            $table->string('region')->nullable()->after('address');
            $table->string('province')->nullable()->after('region');
            $table->string('city')->nullable()->after('province');
            $table->string('barangay')->nullable()->after('city');
            $table->string('zip_code')->nullable()->after('barangay');
            $table->string('employment_status')->nullable()->after('email');

            // Drop old 'address' column
            $table->dropColumn('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            // Re-add 'address' column if rolling back
            $table->text('address')->nullable();

            // Drop new columns
            $table->dropColumn([
                'middle_name',
                'nickname',
                'social_security_number',
                'marital_status',
                'language',
                'race',
                'region',
                'province',
                'city',
                'barangay',
                'zip_code',
                'employment_status',
            ]);
        });
    }
};
