<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEasypaisaUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easypaisa_users', function (Blueprint $table) {
            $table->id();
            $table->string('open_id')->unique();
            $table->string('union_id')->unique();
            $table->string('user_msisdn')->unique();
            $table->string('result_code');
            $table->string('result_status');
            $table->string('result_message');
            $table->string('other')->nullable();
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
        Schema::dropIfExists('easypaisa_users');
    }
}
