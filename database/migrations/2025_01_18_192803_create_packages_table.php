<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name'); // Name of the package
            $table->enum('type', ['conventional', 'islamic']); // Type of package (Conventional or Islamic)
            $table->integer('min_duration_days'); // Minimum duration of the package in days
            $table->integer('max_duration_days'); // Maximum duration of the package in days
            $table->integer('duration_breakage_days')->nullable(); // Duration breakage, the number of days for intermediate durations (nullable if not applicable)
            $table->decimal('processing_fee', 10, 2); // Processing fee for the slab
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
        Schema::dropIfExists('packages');
    }
}
