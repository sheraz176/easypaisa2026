<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customer_information'); // Foreign key to customer_information
            $table->foreignId('beneficiary_id')->nullable()->constrained('beneficiaries'); // Foreign key to beneficiaries table
            $table->date('policy_start_date');
            $table->date('policy_end_date');
            $table->string('eful_policy_number'); // Unique policy number
            $table->string('eful_status'); // Policy status (e.g., active, expired)
            $table->string('eful_data1')->nullable(); // Any additional policy data
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
        Schema::dropIfExists('insurance_data');
    }
}
