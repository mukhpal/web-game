<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForecastingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasting', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('round_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('team_id')->unsigned();
            $table->integer('type')->default(1);
            $table->decimal('amount', 10, 2)->default(0);

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
        Schema::dropIfExists('forecasting');
    }
}
