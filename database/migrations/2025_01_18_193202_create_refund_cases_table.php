<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investment_master_id'); // Foreign key relation to investment_master table
            $table->decimal('refund_amount', 15, 2); // Amount to be refunded
            $table->date('refund_request_date'); // Date when the refund was requested
            $table->date('refund_processed_date')->nullable(); // Date when the refund was processed (nullable)
            $table->decimal('processing_fee_deducted', 10, 2); // Processing fee deducted from refund
            $table->string('status')->default('pending'); // Refund status (default is pending)
            $table->string('type'); // Refund type (e.g., partial, full)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund_cases');
    }
}
