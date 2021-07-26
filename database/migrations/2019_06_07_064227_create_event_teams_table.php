<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_teams', function (Blueprint $table) {
           /* $table->bigIncrements('id');
            $table->integer('event_id')->nullable();
            $table->integer('team_id')->nullable();
            $table->tinyInteger('status')->default('0');
            $table->timestamps();*/

            $table->primary(['event_id', 'team_id']);
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('team_id')->unsigned();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->tinyInteger('status')->default('0');
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
        Schema::dropIfExists('event_teams');
    }
}
