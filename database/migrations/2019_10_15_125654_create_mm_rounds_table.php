<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMmRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mm_rounds', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('event_id')->unsigned();          
            $table->bigInteger('round')->unsigned();          
            $table->bigInteger('chance')->unsigned();          
            $table->string('start_time')->nullable();          
            $table->bigInteger('crop_id')->unsigned();          
            $table->bigInteger('weather')->unsigned();          
            $table->bigInteger('economy')->unsigned();          
            $table->bigInteger('foreign_production')->unsigned();          
            $table->decimal('market_cost', 10, 2)->unsigned();          
            $table->decimal('demand', 10, 2)->unsigned();          
            $table->bigInteger('max_profit_limit')->unsigned();          
            $table->bigInteger('max_loss_limit')->unsigned();          
            $table->bigInteger('status')->default('1');      

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
        Schema::dropIfExists('mm_rounds');
    }
}
