<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoundTeamAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('round_team_assets', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('round')->unsigned();
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('team_id')->unsigned();
            $table->decimal('total_asset', 10, 2)->unsigned();

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
        Schema::dropIfExists('round_team_assets');
    }
}
