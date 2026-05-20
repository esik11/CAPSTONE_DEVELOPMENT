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
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
            $table->string('receipt_number')->unique();
            $table->date('billing_date');
            $table->decimal('total_amount', 10, 2);
            $table->json('items');
            $table->enum('payment_method', ['cash', 'card', 'gcash', 'paymaya', 'bank_transfer'])->nullable();
            $table->enum('payment_status', ['paid', 'pending', 'partial', 'waived'])->default('pending');
            $table->boolean('is_waived')->default(false);
            $table->string('waive_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
