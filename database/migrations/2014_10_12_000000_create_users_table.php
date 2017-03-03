<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('username', 50)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('noavatar.jpg');
            $table->date('birthday')->nullable();
            $table->string('location')->nullable();
            $table->string('contact')->nullable();
            $table->string('about', 500)->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->enum('status', ['activated', 'pending', 'suspended'])->default('pending');
            $table->string('api_token', 60)->unique();
            $table->string('token', 50)->unique();
            $table->string('provider', 50)->default('web');
            $table->string('provider_id', 200)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
