<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_information', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cnic')->unique(); // Unique CNIC (national ID)
            $table->string('contact_number');
            $table->string('email')->nullable();
            $table->string('gender');
            $table->string('date_of_birth');
            $table->string('openID');
            $table->string('ep_access_code');
            $table->string('ep_data1');
            $table->string('ep_data2'); // Fixed incorrect '$string' to '$table->string'
            $table->string('beneficiary_id')->nullable();// Foreign key relation to beneficiaries table
            $table->string('status'); // User status (active or inactive)
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
        Schema::dropIfExists('customer_information');
    }
}
