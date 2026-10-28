<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gynae_histories', function (Blueprint $table) {
            $table->integer('number_of_pregnancies')->nullable()->after('contraception_comments');
            $table->integer('number_of_children')->nullable()->after('number_of_pregnancies');
            $table->json('pregnancy_complications')->nullable()->after('number_of_children');
            $table->text('pregnancy_complications_comments')->nullable()->after('pregnancy_complications');
        });
    }

    public function down(): void
    {
        Schema::table('gynae_histories', function (Blueprint $table) {
            $table->dropColumn(['number_of_pregnancies', 'number_of_children', 'pregnancy_complications', 'pregnancy_complications_comments']);
        });
    }
};
