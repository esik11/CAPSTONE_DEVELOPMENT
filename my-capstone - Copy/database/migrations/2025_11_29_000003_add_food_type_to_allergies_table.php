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
        // Modify the type enum to include 'food'
        \DB::statement("ALTER TABLE `allergies` MODIFY COLUMN `type` ENUM('medication', 'non_medication', 'food') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        \DB::statement("ALTER TABLE `allergies` MODIFY COLUMN `type` ENUM('medication', 'non_medication') NOT NULL");
    }
};
