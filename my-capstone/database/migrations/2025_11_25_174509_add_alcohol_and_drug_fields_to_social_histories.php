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
            $table->dropColumn(['alcohol_comments', 'drug_type', 'drug_comments']);
        });
    }
};
