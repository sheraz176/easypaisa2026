<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceBenefitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_benefits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages'); // Foreign key relation to packages table
            $table->foreignId('insurance_data_id')
            ->nullable() // Make the column nullable
            ->constrained('insurance_data');
            $table->enum('benefit_type', ['health', 'life', 'accidental', 'other']); // Benefit type (health, life, etc.)
            $table->string('benefit_name'); // Name of the benefit (e.g., hospitalization, accidental death)
            $table->text('benefit_description'); // Description of the benefit
            $table->decimal('amount', 15, 2); // Coverage amount for the benefit
            $table->timestamps(); // Timestamps to track the creation of the benefit
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_benefits');
    }
}
