<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKiborRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kibor_rates', function (Blueprint $table) {
            $table->id();
            $table->date('effective_date'); // Date when the KIBOR rate is effective
            $table->decimal('kibor_rate', 5, 2); // KIBOR rate percentage
            $table->string('status');
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
        Schema::dropIfExists('kibor_rates');
    }
}
