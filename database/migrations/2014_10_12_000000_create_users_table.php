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
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('password',60)->nullable();
            $table->string('type', 50)->default('user');
            $table->string('is_verified')->default("no");
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country_iso',3)->nullable();
            $table->string('country_code',5)->nullable();
            $table->string('contact_number',15)->nullable();

            // $table->string('gender', 10)->nullable();
            // $table->date('birthdate')->nullable();
            // $table->text('description')->nullable();
                        
            $table->bigInteger('fb_id')->unsigned()->nullable();
            $table->string('google_id')->nullable();

            $table->string('access_token')->nullable();

            $table->text('path')->nullable();
            $table->text('directory')->nullable();
            $table->string('filename', 100)->nullable();

            $table->dateTime('last_activity')->nullable();
            $table->dateTime('last_login')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
