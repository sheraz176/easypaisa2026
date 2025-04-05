<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlledUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controlled_users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('username')->unique(); // Unique username
            $table->string('password'); // Password (hashed)
            $table->string('email')->unique(); // Unique email address
            $table->string('phone_number'); // Phone number
            $table->string('first_name'); // First name
            $table->string('last_name'); // Last name

            $table->date('registration_date'); // Registration date
            $table->boolean('is_active')->default(true); // Active status
            $table->boolean('is_login')->default(false); // Login status
            $table->enum('role', ['accounts','investment','operations']); // Role (agent or reporter)
            $table->json('permissions')->nullable(); // Permissions (JSON data)

            $table->integer('reports_generated')->default(0); // Number of reports generated

            // Security parameters
            $table->timestamp('last_login_at')->nullable(); // Last login timestamp
            $table->ipAddress('last_login_ip')->nullable(); // Last login IP address
            $table->string('two_factor_code')->nullable(); // Two-factor authentication code
            $table->timestamp('two_factor_expires_at')->nullable(); // Two-factor code expiration time

            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('controlled_users');
    }
}
