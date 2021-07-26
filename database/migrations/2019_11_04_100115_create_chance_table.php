<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chance', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('round_id')->unsigned();
            $table->bigInteger('chance')->unsigned();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->integer('status')->default('1');

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
        Schema::dropIfExists('chance');
    }
}
