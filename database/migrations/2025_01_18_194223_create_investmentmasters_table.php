<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentmastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investmentmasters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer_information'); // Foreign key relation to customer_information table
            $table->foreignId('package_id'); // Foreign key relation to packages table
            $table->decimal('investment_amount', 15, 2); // Investment amount
            $table->string('trnsaction_id'); //from Easypaisa
            $table->date('investment_date');
            $table->decimal('total_dates_of_investment'); // Total number of investment days
            $table->decimal('total_profit', 15, 2)->default(0); // Total profit accumulated (default is 0)
            $table->enum('status', ['active', 'withdrawn']); // Investment status (active or withdrawn)
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
        Schema::dropIfExists('investmentmasters');
    }
}
