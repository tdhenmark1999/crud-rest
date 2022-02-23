<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('news', function(Blueprint $table)
        {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->default("0");
            $table->string('title')->nullable();
            $table->text('linked_url')->nullable();
            $table->text('directory')->nullable();
            $table->string('path')->nullable();
            $table->string('filename')->nullable();

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
        Schema::dropIfExists('news');
    }
}
