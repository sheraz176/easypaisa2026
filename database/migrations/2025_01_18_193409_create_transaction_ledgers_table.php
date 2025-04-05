<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer_information'); // Reference to the customer
            $table->decimal('amount', 15, 2); // Amount involved in the transaction (profit, credit, withdrawal)
            $table->enum('transaction_type', ['credit', 'debit', 'profit']); // Type of transaction (credit, debit, or profit)
            $table->foreignId('investment_master_id'); // Link to investment, if applicable
            $table->foreignId('refund_case_id')->nullable()->constrained('refund_cases'); // Link to refund case, if applicable
            $table->string('transaction_id')->unique(); // Unique transaction identifier
            $table->date('transaction_date'); // Date of the transaction
            $table->string('status')->default('pending'); // Status of the transaction (e.g., pending, completed)
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
        Schema::dropIfExists('transaction_ledgers');
    }
}
