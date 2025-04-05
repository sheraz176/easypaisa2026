<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages'); // Foreign key relation to packages table
            $table->string('slab_name');
            $table->decimal('initial_deposit', 15, 2); // Initial deposit required for the slab
            $table->decimal('maximum_deposit', 15, 2); // Maximum deposit allowed
            $table->decimal('daily_return_rate', 5, 2); // Daily return rate percentage
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
        Schema::dropIfExists('slabs');
    }
}
