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
            $table->bigIncrements('UsrID');
            $table->string('UsrFirstname');
            $table->string('UsrLastname');
            $table->string('UsrEmail')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('UsrPassword');
            $table->integer('UsrRoleID');
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
