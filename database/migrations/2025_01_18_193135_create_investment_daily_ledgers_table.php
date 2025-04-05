<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentDailyLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_daily_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investment_master_id'); // Foreign key relation to investment_master table
            $table->date('profit_date'); // Date when the profit is recorded
            $table->decimal('daily_profit', 15, 2); // Daily profit earned
            $table->boolean('is_processed')->default(false); // Whether the profit has been processed
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
        Schema::dropIfExists('investment_daily_ledgers');
    }
}
