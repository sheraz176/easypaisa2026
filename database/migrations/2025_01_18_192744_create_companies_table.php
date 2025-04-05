<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('address');
            $table->string('contact_number');
            $table->string('registration_number')->unique(); // Unique company registration number
            $table->string('ntn')->unique(); // National Tax Number (NTN)
            $table->string('secp_registration')->nullable(); // SECP registration number (nullable)
            $table->string('business_type'); // Type of business (e.g., saving products)
            $table->decimal('authorized_capital', 15, 2)->nullable(); // Authorized capital (nullable)
            $table->date('registration_date'); // Company registration date
            $table->boolean('is_active')->default(true); // Active status
            $table->string('status'); // Company status (active or inactive)
            $table->json('package_assigned')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
